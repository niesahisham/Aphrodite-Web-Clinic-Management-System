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
        // 🌟 FIXED: Eager load the nested relationship path (patient, items, and item drugs)
        $prescriptions = Prescription::with(['patient', 'items.drug'])->get();
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
        // 1. Validate ALL incoming inputs from the form
        $request->validate([
            'patient_id'          => 'required|exists:patients,id',
            'drug_id'             => 'required|exists:drugs,id',
            'dosage_instructions' => 'required', // Keeps tracking your blade form field name
            'duration'            => 'required',
        ]);

        $patient = Patient::find($request->patient_id);
        $drug = Drug::find($request->drug_id);

        // --- NURIN'S ALLERGY WARNING FLAG SYSTEM ---
        if ($patient && $patient->allergies && stripos($patient->allergies, $drug->name) !== false) {
            return redirect()->back()
                ->withInput()
                ->with('error', "⚠️ CRITICAL ALERT: Patient is allergic to {$drug->name}! Prescription blocked.");
        }

        // 2. Create the Parent Prescription Record 
        $prescription = Prescription::create([
            'patient_id'        => $request->patient_id,
            'doctor_id'         => auth()->id() ?? 1, 
            'status'            => 'active',
            'issued_at'         => now(),
            'medical_record_id' => null, 
        ]);

        // 3. Create the Child Item 
        // 🌟 FIXED: Changed 'dosage_instructions' key to match your database column 'dosage'
        $prescription->items()->create([
            'drug_id'  => $request->drug_id,
            'dosage'   => $request->dosage_instructions, 
            'frequency' => 'As directed',
            'duration_days' => $request->duration,
        ]);

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