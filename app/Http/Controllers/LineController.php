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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('line.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_line' => 'required|string|max:255',
        ]);
        $line = Line::create($validated);
        return redirect()->route('lines.index')->with('success', 'Line créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Line $line)
    {
        return view('line.show', compact('line'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Line $line)
    {
        return view('line.edit', compact('line'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Line $line)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Ajoute d'autres champs selon le modèle Line
        ]);
        $line->update($validated);
        return redirect()->route('lines.index')->with('success', 'Line modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Line $line)
    {
        $line->delete();
        return redirect()->route('lines.index')->with('success', 'Line supprimée avec succès');
    }
}
