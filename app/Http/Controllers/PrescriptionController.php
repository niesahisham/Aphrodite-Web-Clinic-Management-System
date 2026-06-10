<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Drug;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'drug'])->get();
        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $drugs = Drug::all();
        return view('prescriptions.create', compact('patients', 'drugs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'drug_id' => 'required',
            'dosage_instructions' => 'required',
            'duration' => 'required',
        ]);

        $patient = Patient::find($request->patient_id);
        $drug = Drug::find($request->drug_id);

        // --- NURIN'S ALLERGY WARNING FLAG SYSTEM ---
        // Checks if the patient's allergy field contains the prescribed drug name
        if ($patient && $patient->allergies && stripos($patient->allergies, $drug->name) !== false) {
            return redirect()->back()
                ->withInput()
                ->with('error', "⚠️ CRITICAL ALERT: Patient is allergic to {$drug->name}! Prescription blocked.");
        }

        Prescription::create($request->all());

        return redirect()->route('prescriptions.index')->with('success', 'Digital prescription generated successfully!');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prescription $prescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prescription $prescription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        //
    }
}
