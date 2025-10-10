<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('all.index');
    }
    public function adoption()
    {
        return view('all.adoption');
    }
    public function cares()
    {
        return view('all.cares');
    }
    public function myths()
    {
        return view('all.myths');
    }
}