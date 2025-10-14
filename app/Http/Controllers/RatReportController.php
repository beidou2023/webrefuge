<?php

namespace App\Http\Controllers;

use App\Models\Rat;
use App\Models\Ratreport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RatReportController extends Controller
{
    public function report(Request $request)
{
    $validated = $request->validate([
        'rat_id' => 'required|exists:rats,id',
        'status' => 'required|in:0,2,3', 
        'comment' => 'required|string|max:500',
    ]);

    try {
        $rat = Rat::findOrFail($validated['rat_id']);

        if ($rat->idUser !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'No tienes permiso para reportar esta rata.')
                ->with('open_report_modal', true)
                ->with('report_rat_id', $validated['rat_id']);
        }

        Ratreport::create([
            'idUser' => Auth::id(),
            'idRat' => $validated['rat_id'],
            'status' => $validated['status'],
            'comment' => $validated['comment'],
            'resolved' => false, 
            'reviewedBy' => null, 
        ]);

        $rat->update([
            'status' => $validated['status'] 
        ]);

        return redirect()->back()->with('success', 'Reporte enviado correctamente. Revisaremos tu caso pronto.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->withErrors(['error' => 'Error al enviar el reporte: ' . $e->getMessage()])
            ->withInput()
            ->with('open_report_modal', true)
            ->with('report_rat_id', $validated['rat_id']);
    }
}
}
