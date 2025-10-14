<?php

namespace App\Http\Controllers;

use App\Models\Rat;
use App\Models\Specialrat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $validated = $request->validate([
            'rat_id' => 'required|exists:rats,id',
            'name' => 'required|string|max:50',
            'color' => 'nullable|string|max:30',
            'sex' => 'required|in:M,F',
            'ageMonths' => 'nullable|integer|min:1|max:36',
        ]);

        try {
            $rat = Rat::findOrFail($validated['rat_id']);
            
            if ($rat->idUser !== Auth::id()) {
                return redirect()->back()
                    ->with('error', 'No tienes permiso para modificar esta rata.')
                    ->with('open_rename_modal', true)
                    ->with('rename_rat_id', $validated['rat_id']);
            }

            $rat->update([
                'name' => $validated['name'],
                'color' => $validated['color'],
                'sex' => $validated['sex'],
                'ageMonths' => $validated['ageMonths'],
            ]);

            return redirect()->back()->with('successEditRat', 'Rata actualizada correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al actualizar la rata: ' . $e->getMessage()])
                ->withInput()
                ->with('open_rename_modal', true)
                ->with('rename_rat_id', $validated['rat_id']);
        }
    }


}