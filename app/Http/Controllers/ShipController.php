<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use App\Models\Line;
use App\Imports\ShipsImport;
use App\Exports\ShipsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ships = Ship::with('line')->get();
        $lines = Line::all();
        return view('ship.index', compact('ships', 'lines'));
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
        $request->validate([
            'name_nav' => 'required',
            'line_id' => 'required|exists:lines,id',
        ]);
        Ship::create($request->only('name_nav', 'line_id'));
        return redirect()->back()->with('success', 'Navire ajouté !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ship $ship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ship $ship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ship $ship)
    {
        $request->validate([
            'name_nav' => 'required',
            'line_id' => 'required|exists:lines,id',
        ]);
        $ship->update($request->only('name_nav', 'line_id'));
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ship $ship)
    {
        $ship->delete();
        return response()->json(['success' => true]);
    }

    // Import ships from Excel/CSV
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);
        Excel::import(new ShipsImport, $request->file('file'));
        return redirect()->back()->with('success', 'Importation terminée !');
    }

    // Export ships to Excel/CSV
    public function export()
    {
        return Excel::download(new ShipsExport, 'navires.xlsx');
    }
}
