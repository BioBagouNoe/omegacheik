<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AgencyController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);
        $import = new \App\Imports\AgenciesImport;
        Excel::import($import, $request->file('file'));
        if (count($import->errors) > 0) {
            return response()->json(['success' => false, 'errors' => $import->errors], 422);
        }
        return response()->json(['success' => true]);
    }

    public function export()
    {
        return Excel::download(new \App\Exports\AgenciesExport, 'agencies.xlsx');
    }
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
            'pays_id' => 'required|exists:pays,id',
        ]);
        $agency = Agency::create($validated);
        if ($request->expectsJson() || $request->ajax()) {
            $agency->load('line', 'pays');
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
        try {
            $validated = $request->validate([
                'name_agency' => 'required|string|max:255',
                'adress_agency' => 'required|string|max:255',
                'line_id' => 'required|exists:lines,id',
                'pays_id' => 'required|exists:pays,id',
                '_method' => 'sometimes|in:PUT,PATCH,DELETE',
            ]);
            
            // Si c'est une requête DELETE
            if ($request->has('_method') && $request->input('_method') === 'DELETE') {
                $agency->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Agence supprimée avec succès'
                ], 200);
            }
            
            // Mise à jour de l'agence
            $agency->update([
                'name_agency' => $validated['name_agency'],
                'adress_agency' => $validated['adress_agency'],
                'line_id' => $validated['line_id'],
                'pays_id' => $validated['pays_id'],
            ]);
            
            if ($request->expectsJson() || $request->ajax()) {
                $agency->load('line', 'pays');
                return response()->json([
                    'success' => true, 
                    'message' => 'Agence mise à jour avec succès',
                    'agency' => $agency,
                    'line_name' => $agency->line->name_line ?? '',
                    'pays_name' => $agency->pays->nom ?? ''
                ], 200);
            }
            
            return redirect()->route('agencies.index')
                ->with('success', 'Agence modifiée avec succès');
                
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->errors() ?? null
                ], 422);
            }
            
            return back()->withErrors($e->errors() ?? $e->getMessage());
        }
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
