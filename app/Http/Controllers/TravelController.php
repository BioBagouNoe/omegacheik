<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\Ship;
class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $travels = Travel::all();
        $ships = Ship::all();
        $agencies = Agency::all();
        return view('manifest.index', compact('travels', 'ships', 'agencies'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'agency_id' => 'required|exists:agencies,id',
            'ship_id' => 'required|exists:ships,id',
        ]);
        $travel = Travel::registerTravel($validated);
        // Charger les relations nécessaires pour la réponse JS
        $travel->load(['ship', 'agency']);
        return response()->json([
            'success' => true,
            'message' => 'Voyage ajouté avec succès !',
            'id' => $travel->id,
            'num_travel' => $travel->num_travel,
            'arrival_date' => $travel->arrival_date,
            'docking_date' => $travel->docking_date,
            'end_unloading' => $travel->end_unloading,
            'status' => $travel->status,
            'agency_id' => $travel->agency_id,
            'ship_id' => $travel->ship_id,
            'ship' => $travel->ship,
            'agency' => $travel->agency,
        ], 201);
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
            'agency_id' => 'sometimes|required|exists:agencies,id',
            'ship_id' => 'sometimes|required|exists:ships,id',
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
