<?php

namespace App\Http\Controllers;

use App\Models\TravelDetail;
use Illuminate\Http\Request;

class TravelDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = TravelDetail::all();
        return view('manifest_detail.index', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manifest_detail.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bar_code' => 'required|string|unique:travel_details,bar_code',
            'bl' => 'required|string',
            'consignor' => 'required|string',
            'destination' => 'required|string',
            'consignor_adress' => 'required|string',
            'chassis' => 'required|string',
            'mark' => 'required|string',
            'type' => 'required|string',
            'year_make' => 'required|integer',
            'travel_id' => 'required|exists:travel,id',
        ]);
        $detail = TravelDetail::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Détail ajouté',
            'detail' => $detail
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TravelDetail $travel_detail)
    {
        return view('manifest_detail.show', compact('travel_detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelDetail $travel_detail)
    {
        return view('manifest_detail.edit', compact('travel_detail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TravelDetail $travel_detail)
    {
        $validated = $request->validate([
            'bar_code' => 'required|string|unique:travel_details,bar_code,' . $travel_detail->id,
            'bl' => 'required|string',
            'consignor' => 'required|string',
            'destination' => 'required|string',
            'consignor_adress' => 'required|string',
            'chassis' => 'required|string',
            'mark' => 'required|string',
            'type' => 'required|string',
            'year_make' => 'required|integer',
            'travel_id' => 'required|exists:travel,id',
        ]);
        $travel_detail->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Détail modifié',
            'detail' => $travel_detail
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelDetail $travel_detail)
    {
        $travel_detail->delete();
        return response()->json([
            'success' => true,
            'message' => 'Détail supprimé'
        ]);
    }
}
