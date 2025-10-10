<?php

namespace App\Http\Controllers;

use App\Models\Adoptionrequest;
use App\Models\Rat;
use App\Models\Specialrat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $rats = Rat::where('idUser', $user->id)
                  ->where('status', 1)
                  ->orderBy('adoptedAt', 'desc')
                  ->get();

        $adoptionRequests = Adoptionrequest::where('idUser', $user->id)
                                         ->orderBy('created_at', 'desc')
                                         ->get();

        return view('users.dashboard', compact('user', 'rats', 'adoptionRequests'));
    }
}