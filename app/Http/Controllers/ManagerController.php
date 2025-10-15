<?php

namespace App\Http\Controllers;

use App\Models\Refuge;
use App\Models\Rat;
use App\Models\Specialrat;
use App\Models\Adoptionrequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function dashboard()
{
    $user = Auth::user();
    
    $refuge = Refuge::where('idManager', $user->id)->first();
    
    if (!$refuge) {
        $refuge = Refuge::create([
            'idManager' => $user->id,
            'name' => 'Refugio de ' . $user->firstName,
            'address' => $user->address,
            'maleCount' => 0,
            'femaleCount' => 0,
            'status' => 1
        ]);
    }

    $stats = [
        'total_rats' => Rat::count(),
        'male_rats' => Rat::where('sex', 'M')->count(),
        'female_rats' => Rat::where('sex', 'F')->count(),
        'special_rats' => Specialrat::where('status', 1)->count(),
        'pending_requests' => Adoptionrequest::where('status', 2)->count(),
        'total_users' => User::where('status', 1)->count(),
        'refuge_rats' => Rat::where('status', 1)->count(),
    ];

    $normalRequests = Adoptionrequest::with(['user', 'approver'])
        ->where('status', 2) // Pendientes
        ->whereNull('idSpecialRat')
        ->orderBy('created_at', 'desc')
        ->get();

    $specialRequests = Adoptionrequest::with(['user', 'approver', 'specialRat'])
        ->where('status', 2) 
        ->whereNotNull('idSpecialRat')
        ->orderBy('created_at', 'desc')
        ->get();

    $pendingRequests = Adoptionrequest::where('status', 2)->get();

    $specialRats = Specialrat::where('status', 1)
                           ->orderBy('created_at', 'desc')
                           ->get();

    $activeUsers = User::where('status', 1)
                      ->where('role', 1)
                      ->orderBy('created_at', 'desc')
                      ->get();

    return view('manager.dashboard', compact(
        'user', 
        'refuge', 
        'stats', 
        'specialRats', 
        'pendingRequests', 
        'activeUsers',
        'normalRequests',  
        'specialRequests'  
    ));
}

    public function addRat(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:45',
            'sex' => 'required|in:M,F',
            'color' => 'nullable|string|max:45',
            'ageMonths' => 'nullable|integer|min:1|max:36',
            'origin' => 'required|string|max:100'
        ]);

        Rat::create([
            'name' => $request->name,
            'sex' => $request->sex,
            'color' => $request->color,
            'ageMonths' => $request->ageMonths,
            'type' => 1,
            'status' => 1,
        ]);

        $refuge = Refuge::where('idManager', Auth::id())->first();
        if ($request->sex == 'M') {
            $refuge->increment('maleCount');
        } else {
            $refuge->increment('femaleCount');
        }

        return redirect()->back()->with('success', 'Rata agregada correctamente');
    }

    public function addSpecialRat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45',
            'description' => 'required|string|max:500',
            'sex' => 'required|in:M,F',
            'ageMonths' => 'nullable|integer|min:1|max:36',
            'imgUrl' => 'nullable|image|max:2048'
        ]);

        $refuge = Refuge::where('idManager', Auth::id())->first();

        $imagePath = null;
        if ($request->hasFile('imgUrl')) {
            $imagePath = $request->file('imgUrl')->store('special-rats', 'public');
        }

        Specialrat::create([
            'idRefuge' => $refuge->id,
            'name' => $request->name,
            'description' => $request->description,
            'sex' => $request->sex,
            'imgUrl' => $imagePath,
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Rata especial agregada correctamente');
    }

    public function processRequest(Request $request, $id)
{
    try {
        $adoptionRequest = Adoptionrequest::with('specialRat')->findOrFail($id);
        $action = $request->input('action');

        if ($action === 'approve') {
            $adoptionRequest->update([
                'status' => 1, // Aprobado
                'aprovedBy' => Auth::id(),
            ]);

            if ($adoptionRequest->idSpecialRat && $adoptionRequest->specialRat) {
                $adoptionRequest->specialRat->update([
                    'status' => 0 
                ]);

                Rat::create([
                    'idUser' => $adoptionRequest->idUser,
                    'name' => $adoptionRequest->specialRat->name,
                    'sex' => $adoptionRequest->specialRat->sex,
                    'ageMonths' => $adoptionRequest->specialRat->ageMonths,
                    'color' => $adoptionRequest->specialRat->color,
                    'type' => 2, 
                    'status' => 1, 
                    'adoptedAt' => now(),
                ]);

                $message = 'Solicitud ESPECIAL aprobada correctamente. Rata asignada al usuario.';

            } else {
                $quantity = $adoptionRequest->quantityExpected;
                $sex = $adoptionRequest->couple == 1 ? ['M', 'F'] : 
                      ($adoptionRequest->couple == 0 ? ['M'] : ['F']);
                
                for ($i = 0; $i < $quantity; $i++) {
                    Rat::create([
                        'idUser' => $adoptionRequest->idUser,
                        'name' => 'Rata ' . ($i + 1),
                        'sex' => $sex[array_rand($sex)],
                        'type' => 1,
                        'status' => 1, 
                        'adoptedAt' => now(),
                    ]);
                }

                $message = 'Solicitud NORMAL aprobada correctamente. ' . $quantity . ' ratas asignadas al usuario.';
            }

        } elseif ($action === 'reject') {
            $adoptionRequest->update([
                'status' => 0, 
                'aprovedBy' => Auth::id(),
            ]);

            $message = 'Solicitud rechazada correctamente.';

        } else {
            return redirect()->back()->with('error', 'Acción no válida.');
        }

        return redirect()->back()->with('successAccept');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
    }
}

    public function banUser($id)
    {
        $user = User::where('id', $id)->where('role', 1)->firstOrFail();
        $user->update(['status' => 3]);

        return redirect()->back()->with('success', 'Usuario baneado correctamente');
    }

    
}