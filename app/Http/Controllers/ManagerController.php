<?php

namespace App\Http\Controllers;

use App\Models\Adoptionrequest;
use App\Models\Rat;
use App\Models\Specialrat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('manager.dashboard', compact('user'));
    }    
}
