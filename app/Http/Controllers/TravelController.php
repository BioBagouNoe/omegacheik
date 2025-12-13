<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $travels = \App\Models\Travel::with('travelDetails')->get();
        return response()->json($travels);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Si vous avez une vue pour créer un travel, retournez-la ici
        // return view('travel.create');
        return response()->json(['message' => 'Show create travel form']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'num_travel' => 'required|string',
            'arrival_date' => 'required|date',
            'docking_date' => 'required|date',
            'end_unloading' => 'required|date',
            'status' => 'required|in:scheduled,in_progress,completed,canceled',
        ]);
        $travel = \App\Models\Travel::registerTravel($validated);
        return response()->json($travel, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Travel $travel)
    {
        $travel->load('travelDetails');
        return response()->json($travel);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Travel $travel)
    {
        // Si vous avez une vue pour éditer un travel, retournez-la ici
        // return view('travel.edit', compact('travel'));
        return response()->json(['message' => 'Show edit travel form', 'travel' => $travel]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Travel $travel)
    {
        $validated = $request->validate([
            'num_travel' => 'sometimes|required|string',
            'arrival_date' => 'sometimes|required|date',
            'docking_date' => 'sometimes|required|date',
            'end_unloading' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:scheduled,in_progress,completed,canceled',
        ]);
        $travel->updateTravel($validated);
        return response()->json($travel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Travel $travel)
    {
        $travel->deleteTravel();
        return response()->json(['message' => 'Travel deleted successfully']);
    }
}
