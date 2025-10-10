<?php

namespace App\Http\Controllers;

use App\Models\Rat;
use App\Models\Specialrat;
use Illuminate\Http\Request;

class RatController extends Controller
{
    public function available()
    {
        $availableRats = Rat::where('status', 1)
                           ->whereNull('idUser')
                           ->whereNull('adoptedAt')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('users.rats.available', compact('availableRats'));
    }

    public function special()
    {
        $specialRats = Specialrat::where('status', 1)
                               ->orderBy('created_at', 'desc')
                               ->get();

        return view('users.rats.special', compact('specialRats'));
    }

    public function show($id)
    {
        $rat = Rat::findOrFail($id);
        
        if ($rat->status != 1) {
            abort(404, 'Esta rata no está disponible');
        }

        return view('users.rats.show', compact('rat'));
    }

    public function showSpecial($id)
    {
        $specialRat = Specialrat::findOrFail($id);

        if ($specialRat->status != 1) {
            abort(404, 'Esta rata especial no está disponible');
        }

        return view('users.rats.show-special', compact('specialRat'));
    }

    public function byGender($gender)
    {
        $validGenders = ['M', 'F'];
        
        if (!in_array(strtoupper($gender), $validGenders)) {
            abort(404);
        }

        $rats = Rat::where('status', 1)
                  ->where('sex', strtoupper($gender))
                  ->whereNull('idUser')
                  ->whereNull('adoptedAt')
                  ->orderBy('created_at', 'desc')
                  ->get();

        $genderName = $gender == 'M' ? 'Machos' : 'Hembras';

        return view('users.rats.by-gender', compact('rats', 'genderName'));
    }

    public function rename(Request $request)
    {
        $request->validate([
            'rat_id' => 'required|exists:rats,id',
            'new_name' => 'required|string|max:45'
        ]);

        $rat = Rat::findOrFail($request->rat_id);
        
        if ($rat->idUser != auth()->id()) {
            abort(403, 'No tienes permisos para renombrar esta rata');
        }

        $rat->name = $request->new_name;
        $rat->save();

        return redirect()->back()->with('success', 'Rata renombrada correctamente');
    }
}