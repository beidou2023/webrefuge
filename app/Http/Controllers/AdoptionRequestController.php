<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 

class AdoptionRequestController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'imgUrl' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'reason' => 'required|string|max:100',
                'experience' => 'required|string|max:500',
                'quantityExpected' => 'required|integer|min:1|max:10',
                'couple' => 'required|integer|in:0,1,2',
                'contactTravel' => 'required|string|max:255',
                'contactReturn' => 'required|string|max:255',
                'petsInfo' => 'nullable|string|max:500',
                'hasPets' => 'required|boolean',
                'noReturn' => 'required|boolean',
                'care' => 'required|boolean',
                'followUp' => 'required|boolean',
                'canPayVet' => 'required|boolean',
            ]);

            if ($request->hasFile('imgUrl')) {
                $imagePath = $request->file('imgUrl')->store('adoption-jaulas', 'public');
                $validated['imgUrl'] = $imagePath;
            }

            $validated['idUser'] = Auth::id();
            $validated['status'] = 2;

            AdoptionRequest::create($validated);

            return redirect()->route('user.dashboard')->with('successRequest', 'Solicitud de adopción enviada correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }


    public function storeSpecial(Request $request)
{
    try {
        $validated = $request->validate([
            'imgUrl' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'reason' => 'required|string|max:1000', 
            'experience' => 'required|string|max:1000',
            'idSpecialRat' => 'required|integer|exists:rats,id', 
            'contactTravel' => 'required|string|max:255',
            'contactReturn' => 'required|string|max:255',
            'petsInfo' => 'nullable|string|max:500',
            'hasPets' => 'required|boolean',
            'noReturn' => 'boolean',
            'care' => 'boolean',
            'followUp' => 'boolean',
            'canPayVet' => 'boolean',
        ]);

        if ($request->hasFile('imgUrl')) {
            $imagePath = $request->file('imgUrl')->store('adoption-especial-jaulas', 'public');
            $validated['imgUrl'] = $imagePath;
        }

        $validated['idUser'] = Auth::id();
        $validated['status'] = 2;
        $validated['quantityExpected'] = 1; 
        $validated['couple'] = 0; 

        AdoptionRequest::create($validated);

        return redirect()->back()->with('success', 'Solicitud de adopción especial enviada correctamente. Será revisada con prioridad.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->withErrors($e->getMessage())
            ->withInput();
    }
}
}