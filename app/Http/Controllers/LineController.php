<?php

namespace App\Http\Controllers;

use App\Models\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lines = Line::all();
        return view('line.index', compact('lines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_line' => 'required|string|max:255',
        ]);
       Line::create($validated);
        return redirect()->route('lines.index')->with('success', 'Ligne créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Line $line)
    {
        return view('line.show', compact('line'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Line $line)
    {
        $validated = $request->validate([
            'name_line' => 'required|string|max:255',
        ]);
        $line->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'name_line' => $line->name_line]);
        }
        return redirect()->route('lines.index')->with('success', 'Ligne modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Line $line)
    {
        $line->delete();
        return redirect()->route('lines.index')->with('success', 'Ligne supprimée avec succès');
    }
}
