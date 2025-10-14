<?php

namespace App\Http\Controllers;

use App\Models\Adoptionrequest;
use App\Models\Rat;
use App\Models\Specialrat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $rats = Rat::where('idUser', $user->id)
                ->where('status', '!=', 0)
                ->orderBy('adoptedAt', 'desc')
                ->get();

        $adoptionRequests = Adoptionrequest::where('idUser', $user->id)
                                         ->orderBy('created_at', 'desc')
                                         ->get();

        return view('users.dashboard', compact('user', 'rats', 'adoptionRequests'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->firstName = $validated['firstName'];
        $user->lastName = $validated['lastName'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'La contraseña actual es incorrecta.'])
                    ->withInput();
            }
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('successEdit', 'Perfil actualizado correctamente.');
    }
}