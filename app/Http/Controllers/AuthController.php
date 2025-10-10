<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Credenciales inválidas'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|min:3|max:40',
            'lastName' => 'required|string|min:3|max:40',
            'email' => [
                'required',
                'email',
                'max:75',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\User::where('email', $value)
                        ->whereIn('status', [1, 2])
                        ->exists();

                    if ($exists) {
                        $fail('Este correo ya está registrado.');
                    }
                },
                function ($attribute, $value, $fail) {
                    if (!preg_match('/@gmail\.com$/', $value)) {
                        $fail('El correo debe ser un @gmail.com válido.');
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'confirmed',
                function ($attribute, $value, $fail) {
                    if (
                        !preg_match('/[A-Z]/', $value) ||
                        !preg_match('/[a-z]/', $value) ||
                        !preg_match('/[0-9]/', $value) ||
                        !preg_match('/[\W_]/', $value)
                    ) {
                        $fail('La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.');
                    }
                },
            ],
            'phone' => [
                'required',
                'regex:/^[67][0-9]{7}$/',
            ],
            'address' => 'required|string|min:3|max:495',
        ],
        [],
        [
            'firstName' => 'nombre',
            'lastName' => 'apellido',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'phone' => 'teléfono',
            'address' => 'dirección',
        ]);

        $user = User::create([
            'firstName' => strtoupper($request->firstName),
            'lastName' => strtoupper($request->lastName),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => strtoupper($request->address),
            'role' => 1,        
            'status' => 2,
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }
}