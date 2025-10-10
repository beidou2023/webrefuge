<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PharIo\Manifest\Author;

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
            if(Auth::user()->role==1){
                return redirect()->intended('/user/dashboard');
            }
            else if(Auth::user()->role==2){
                return redirect()->intended('/manager/dashboard');
            }
            else if(Auth::user()->role==3){
                return redirect()->intended('/admin/dashboard');
            }
            else{
                return redirect()->intended('/');
            }
        }

        return back()->withErrors(['email' => 'Credenciales inválidas'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
