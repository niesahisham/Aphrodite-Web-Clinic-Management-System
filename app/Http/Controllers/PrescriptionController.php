<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Patient;
use App\Models\Drug;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'items.drug', 'doctor'])
            ->latest()
            ->get();
        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $patients = Patient::where('status', 'Active')->orderBy('full_name')->get();
        $drugs = Drug::orderBy('name')->get();
        return view('prescriptions.create', compact('patients', 'drugs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'          => 'required|exists:patients,id',
            'drug_id'             => 'required|exists:drugs,id',
            'dosage_instructions' => 'required|string|max:255',
            'duration'            => 'required|string|max:100',
        ]);

        // Prescriptions require a medical_record_id (NOT NULL in migration).
        // You need to either make it nullable or pass one. 
        // For now, abort if no medical record exists for this patient.
        $medicalRecord = MedicalRecord::where('patient_id', $request->patient_id)
            ->latest()
            ->first();

        if (!$medicalRecord) {
            return back()->withErrors([
                'patient_id' => 'No medical record found. A consultation must exist before prescribing.'
            ])->withInput();
        }

        $prescription = Prescription::create([
            'medical_record_id' => $medicalRecord->id,
            'patient_id'        => $request->patient_id,
            'doctor_id'         => Auth::id(),
            'status'            => 'active',
            'issued_at'         => now(),
        ]);

        // Parse duration (e.g. "7 days" → 7)
        $durationDays = (int) filter_var($request->duration, FILTER_SANITIZE_NUMBER_INT) ?: 7;

        PrescriptionItem::create([
            'prescription_id' => $prescription->id,
            'drug_id'         => $request->drug_id,
            'dosage'          => $request->dosage_instructions,
            'frequency'       => 'as prescribed',
            'duration_days'   => $durationDays,
            'instructions'    => $request->dosage_instructions,
        ]);

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription issued successfully!');
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'items.drug', 'doctor']);
        return view('prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription)
    {
        $drugs = Drug::orderBy('name')->get();
        return view('prescriptions.edit', compact('prescription', 'drugs'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'status' => 'required|in:active,administered,completed,cancelled',
        ]);

        $prescription->update([
            'status'     => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription updated.');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription deleted.');
    }
}