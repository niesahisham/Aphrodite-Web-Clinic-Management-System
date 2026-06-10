@extends('layouts.app')

@section('title', 'Issue Prescription - MediCare')

@section('page-title', 'Create Digital Prescription')

@section('content')
<div class="container" style="max-width: 600px; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">Prescription Form</h2>

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; margin-bottom: 20px; border-radius: 5px; font-weight: bold; border: 1px solid #f87171;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('prescriptions.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Select Patient:</label>
            <select name="patient_id" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">-- Choose Patient --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->full_name }} (Allergies: {{ $patient->allergies ?? 'None' }})</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Select Medication:</label>
            <select name="drug_id" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">-- Choose Drug --</option>
                @foreach($drugs as $drug)
                    <option value="{{ $drug->id }}">{{ $drug->name }} - {{ $drug->dosage }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Dosage Instructions:</label>
            <input type="text" name="dosage_instructions" placeholder="e.g. 1 tablet twice daily after meals" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Duration:</label>
            <input type="text" name="duration" placeholder="e.g. 7 days" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <button type="submit" style="background: #2563eb; color: #fff; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Issue Prescription</button>
        <a href="{{ route('prescriptions.index') }}" style="margin-left: 10px; color: #6b7280; text-decoration: none;">Cancel</a>
    </form>
</div>
@endsection