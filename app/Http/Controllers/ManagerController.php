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

        $specialRats = Specialrat::where('status', 1)
                               ->orderBy('created_at', 'desc')
                               ->get();

        $pendingRequests = Adoptionrequest::where('status', 2)
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
            'activeUsers'
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
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string|max:500'
        ]);

        $adoptionRequest = Adoptionrequest::findOrFail($id);
        
        if ($request->action == 'approve') {
            $adoptionRequest->update([
                'status' => 1,
                'aprovedBy' => Auth::id()
            ]);
            $message = 'Solicitud aprobada correctamente';
        } else {
            $adoptionRequest->update([
                'status' => 0,
                'aprovedBy' => Auth::id()
            ]);
            $message = 'Solicitud rechazada correctamente';
        }

        return redirect()->back()->with('success', $message);
    }


    public function banUser($id)
    {
        $user = User::where('id', $id)->where('role', 1)->firstOrFail();
        $user->update(['status' => 3]);

        return redirect()->back()->with('success', 'Usuario baneado correctamente');
    }
}