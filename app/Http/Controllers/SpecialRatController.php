<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialRat;

class SpecialRatController extends Controller
{
    public function index()
    {
        $specialRats = SpecialRat::where('status', 1)
            ->with('refuge')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('all.adoption', compact('specialRats'));
    }
}

