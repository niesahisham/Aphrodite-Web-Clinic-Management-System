<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     * // 1. Show the list of all drugs
     */
    public function index()
    {
        $drugs = Drug::all();
        return view('drugs.index', compact('drugs'));
    }

    /**
     * Show the form for creating a new resource.
     * // 2. Show the form to add a new drug
     */
    public function create()
    {
        return view('drugs.create');
    }

    /**
     * Store a newly created resource in storage.
     * // 3. Save the new drug to the database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'dosage_form' => 'required|string|max:100',
            'strength'    => 'required|string|max:100',
            'category'    => 'required|string|max:100', // 🔥 Changed from nullable to required!
            'unit_price'  => 'nullable|numeric|min:0',
            'contraindications' => 'nullable|string',
        ]);

        Drug::create($request->only([
            'name', 'dosage_form', 'strength', 'category', 'unit_price', 'contraindications'
        ]));

        return redirect()->route('drugs.index')->with('success', 'Drug added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Drug $drug)
    {
        return view('drugs.show', compact('drug'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drug $drug)
    {
        return view('drugs.edit', compact('drug'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drug $drug)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'dosage_form' => 'required|string|max:100',
            'strength'    => 'required|string|max:100',
            'category'    => 'required|string|max:100',
            'unit_price'  => 'nullable|numeric|min:0',
        ]);

        // Use specific fields instead of $request->all() for safety
        $drug->update($request->only([
            'name', 'dosage_form', 'strength', 'category', 'unit_price', 'contraindications'
        ]));

        return redirect()->route('drugs.index')->with('success', 'Drug updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drug $drug)
    {
        $drug->delete();

        return redirect()->route('drugs.index')->with('success', 'Drug deleted successfully!');
    }
}
