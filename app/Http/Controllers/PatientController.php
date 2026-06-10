<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    // Show all patients
    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $patients = Patient::when($search, function ($query, $search) {
            $query->where('full_name', 'like', "%{$search}%")
                  ->orWhere('patient_code', 'like', "%{$search}%");
        })->latest()->get();

        return view('patients.index', compact('patients', 'search'));
    }

    // Show form to create new patient
    public function create()
    {
        return view('patients.create');
    }

    // Save new patient to database
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'dob'       => 'required|date',
            'gender'    => 'required|in:Male,Female',
            'phone'     => 'required|string|max:20',
            'address'   => 'nullable|string',
            'blood_type'=> 'nullable|string|max:5',
            'allergies' => 'nullable|string',
        ]);

        // Auto-generate patient code
        $count = Patient::count() + 1;
        $patientCode = 'P' . str_pad($count, 3, '0', STR_PAD_LEFT);

        Patient::create([
            'patient_code' => $patientCode,
            'full_name'    => $request->full_name,
            'dob'          => $request->dob,
            'gender'       => $request->gender,
            'phone'        => $request->phone,
            'address'      => $request->address,
            'blood_type'   => $request->blood_type,
            'allergies'    => $request->allergies,
            'status'       => 'Active',
            'registered_by'=> Auth::id(),
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully!');
    }

    // Show single patient profile
    public function show(Patient $patient)
    {
        $patient->load('medicalRecords.doctor', 'prescriptions', 'invoices');
        return view('patients.show', compact('patient'));
    }

    // Show form to edit patient
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    // Update patient in database
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'dob'       => 'required|date',
            'gender'    => 'required|in:Male,Female',
            'phone'     => 'required|string|max:20',
            'address'   => 'nullable|string',
            'blood_type'=> 'nullable|string|max:5',
            'allergies' => 'nullable|string',
            'status'    => 'required|in:Active,Inactive',
        ]);

        $patient->update($request->only([
            'full_name', 'dob', 'gender', 'phone',
            'address', 'blood_type', 'allergies', 'status'
        ]));

        return redirect()->route('patients.show', $patient)->with('success', 'Patient updated successfully!');
    }

    // Delete patient
    public function destroy(Patient $patient)
    {
        if (Auth::user()->role === 'admin') {
            abort(403, 'Admins cannot delete patients.');
        }
        // or restrict to specific roles:
        if (!in_array(Auth::user()->role, ['doctor', 'nurse'])) {
            abort(403, 'Unauthorized.');
        }
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully!');
    }   
}