<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Refuge;
use App\Models\Rat;
use App\Models\Specialrat;
use App\Models\Adoptionrequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_users' => User::count(),
            'pending_users' => User::where('status', 2)->count(),
            'banned_users' => User::where('status', 3)->count(),
            'total_refuges' => Refuge::count(),
            'active_refuges' => Refuge::where('status', 1)->count(),
            'total_rats' => Rat::count(),
            'special_rats' => Specialrat::count(),
            'total_requests' => Adoptionrequest::count(),
            'pending_requests' => Adoptionrequest::where('status', 2)->count(),
        ];

        $users = User::orderBy('created_at', 'desc')->get();

        $refuges = Refuge::with('manager') 
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.dashboard', compact('user', 'stats', 'users', 'refuges'));
    }


    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role == 3 && $user->id != Auth::id()) {
            return redirect()->back()->with('error', 'No puedes banear a otro administrador');
        }

        $newStatus = $user->status == 3 ? 1 : 3;
        $user->update(['status' => $newStatus]);

        $action = $newStatus == 3 ? 'baneado' : 'activado';
        return redirect()->back()->with('success', "Usuario {$action} correctamente");
    }

    public function changeUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role == 3 && $user->id != Auth::id()) {
            return redirect()->back()->with('error', 'No puedes cambiar el rol de otro administrador');
        }

        $request->validate([
            'new_role' => 'required|in:1,2,3'
        ]);

        $user->update(['role' => $request->new_role]);

        $roleNames = [1 => 'Usuario', 2 => 'Manager', 3 => 'Admin'];
        return redirect()->back()->with('success', "Rol cambiado a {$roleNames[$request->new_role]} correctamente");
    }

    public function toggleRefugeStatus($id)
    {
        $refuge = Refuge::findOrFail($id);
        $newStatus = $refuge->status == 0 ? 1 : 0;
        $refuge->update(['status' => $newStatus]);

        $action = $newStatus == 0 ? 'suspendido' : 'activado';
        return redirect()->back()->with('success', "Refugio {$action} correctamente");
    }

    public function createRefuge(Request $request)
    {
        $request->validate([
            'manager_email' => 'required|email|exists:users,email',
            'name' => 'required|string|max:45',
            'contact' => 'required|string|max:20',
            'address' => 'required|string|max:500'
        ]);

        $manager = User::where('email', $request->manager_email)->first();
        
        if ($manager->role != 1 && $manager->role != 2) {
            return redirect()->back()->with('error', 'El usuario debe ser User o Manager');
        }

        if ($manager->role == 1) {
            $manager->update(['role' => 2]);
        }

        Refuge::create([
            'idManager' => $manager->id,
            'name' => $request->name,
            'address' => $request->address,
            'maleCount' => 0,
            'femaleCount' => 0,
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Refugio creado correctamente');
    }
}