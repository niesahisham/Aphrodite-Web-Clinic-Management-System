<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    // Show all medical records
    public function index(Request $request)
    {
        $search = $request->query('search');
        $date = $request->query('date');

        $records = MedicalRecord::with(['patient', 'doctor', 'appointment'])
            ->when($search, function ($query, $search) {
                $query->where('diagnosis', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($patientQuery) use ($search) {
                        $patientQuery->where('full_name', 'like', "%{$search}%")
                            ->orWhere('patient_code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('doctor', function ($doctorQuery) use ($search) {
                        $doctorQuery->where('name', 'like', "%{$search}%");
                    });
            })
            ->when($date, function ($query, $date) {
                $query->whereDate('visit_date', $date);
            })
            ->latest('visit_date')
            ->get();

        return view('medical-records.index', compact('records', 'search', 'date'));
    }

    // Show form to create medical record
    public function create()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereNotIn('status', ['cancelled'])
            ->latest('scheduled_at')
            ->get();

        return view('medical-records.create', compact('appointments'));
    }

    // Save new medical record
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string',
            'symptoms' => 'nullable|string',
            'treatment_notes' => 'nullable|string',
            'visit_date' => 'required|date',
        ]);

        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($request->appointment_id);

        MedicalRecord::create([
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'diagnosis' => $request->diagnosis,
            'symptoms' => $request->symptoms,
            'treatment_notes' => $request->treatment_notes,
            'visit_date' => $request->visit_date,
        ]);

        return redirect()->route('medical-records.index')->with('success', 'Medical record created successfully!');
    }

    // Show single medical record
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'appointment']);
        return view('medical-records.show', compact('medicalRecord'));
    }

    // Show form to edit medical record
    public function edit(MedicalRecord $medicalRecord)
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereNotIn('status', ['cancelled'])
            ->latest('scheduled_at')
            ->get();

        return view('medical-records.edit', compact('medicalRecord', 'appointments'));
    }

    // Update medical record
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string',
            'symptoms' => 'nullable|string',
            'treatment_notes' => 'nullable|string',
            'visit_date' => 'required|date',
        ]);

        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($request->appointment_id);

        $medicalRecord->update([
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'diagnosis' => $request->diagnosis,
            'symptoms' => $request->symptoms,
            'treatment_notes' => $request->treatment_notes,
            'visit_date' => $request->visit_date,
        ]);

        return redirect()->route('medical-records.show', $medicalRecord)->with('success', 'Medical record updated successfully!');
    }

    // Delete medical record
    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('medical-records.index')->with('success', 'Medical record deleted successfully!');
    }

    // Show medical records for one patient
    public function patientRecords(Patient $patient)
    {
        $patient->load(['medicalRecords.doctor', 'medicalRecords.appointment']);

        return view('medical-records.patient-records', compact('patient'));
    }
}