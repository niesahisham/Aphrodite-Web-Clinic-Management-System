<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Drug;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'drug', 'doctor'])->latest()->get();
            return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::where('status', 'Active')->orderBy('full_name')->get();
        $drugs = Drug::orderBy('name')->get();
        return view('prescriptions.create', compact('patients', 'drugs'));

        PrescriptionItem::create([
        'prescription_id' => $prescription->id,
        'drug_id'         => $request->drug_id,
        'dosage'          => $request->dosage_instructions,
        'frequency'       => 'as prescribed',
        'duration_days'   => 7, // parse from $request->duration if needed
        'instructions'    => $request->dosage_instructions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'drug_id'    => 'required|exists:drugs,id',
            'dosage_instructions' => 'required|string|max:255',
            'duration'   => 'required|string|max:100',
        ]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        // Create prescription + prescription item:
        $prescription = Prescription::create([
            'patient_id'  => $request->patient_id,
            'doctor_id'   => Auth::id(),
            'status'      => 'active',
            'issued_at'   => now(),
        ]);

        return redirect()->route('prescriptions.index')->with('success', 'Prescription issued successfully!');
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
