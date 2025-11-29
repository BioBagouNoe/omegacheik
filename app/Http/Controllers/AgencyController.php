<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agencies = Agency::with('line')->get();
        return view('agency.index', compact('agencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lines = \App\Models\Line::all();
        return view('agency.create', compact('lines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_agency' => 'required|string|max:255',
            'adress_agency' => 'required|string|max:255',
            'line_id' => 'required|exists:lines,id',
        ]);
        $agency = Agency::create($validated);
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'agency' => $agency], 201);
        }
        return redirect()->route('agencies.index')->with('success', 'Agence créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agency $agency)
    {
        return view('agency.show', compact('agency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agency $agency)
    {
        $lines = \App\Models\Line::all();
        return view('agency.edit', compact('agency', 'lines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agency $agency)
    {
        $validated = $request->validate([
            'name_agency' => 'required|string|max:255',
            'adress_agency' => 'required|string|max:255',
            'line_id' => 'required|exists:lines,id',
        ]);
        $agency->update($validated);
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'agency' => $agency], 200);
        }
        return redirect()->route('agencies.index')->with('success', 'Agence modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agency $agency)
    {
        $agency->delete();
        return redirect()->route('agencies.index')->with('success', 'Agence supprimée avec succès');
    }
}
