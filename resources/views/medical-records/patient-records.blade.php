@extends('layouts.app')

@section('title', $patient->full_name . ' Medical Records - MediCare')

@section('page-title', 'Patient Medical Records')

@section('content')

    {{-- Patient Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $patient->full_name }}</h2>
            <p class="text-sm text-gray-500">
                {{ $patient->patient_code }}
                · {{ $patient->gender }}
                · {{ \Carbon\Carbon::parse($patient->dob)->age }} years old
            </p>
        </div>

        <a href="{{ route('patients.show', $patient) }}"
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
            Back to Patient
        </a>
    </div>

    {{-- Allergy Alert --}}
    @if($patient->allergies)
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
        ⚠ Allergy Alert: {{ $patient->allergies }}
    </div>
    @endif

    {{-- Medical Records --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-sm font-semibold text-gray-600 mb-4">Medical Record History</h3>

        @forelse($patient->medicalRecords->sortByDesc('visit_date') as $record)
        <div class="border border-gray-200 rounded-lg p-4 mb-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="font-bold text-gray-800">{{ $record->diagnosis }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $record->visit_date->format('d M Y, h:i A') }}
                        · Dr. {{ $record->doctor->name }}
                    </p>
                </div>

                <a href="{{ route('medical-records.show', $record) }}"
                    class="text-blue-600 hover:underline text-sm">
                    View Details
                </a>
            </div>

            <p class="text-sm text-gray-700">
                <span class="font-medium">Symptoms:</span>
                {{ $record->symptoms ? Str::limit($record->symptoms, 100) : 'N/A' }}
            </p>

            <p class="text-sm text-gray-700 mt-2">
                <span class="font-medium">Treatment:</span>
                {{ $record->treatment_notes ? Str::limit($record->treatment_notes, 100) : 'N/A' }}
            </p>
        </div>
        @empty
        <p class="text-gray-400 text-sm">No medical records found for this patient.</p>
        @endforelse
    </div>

@endsection