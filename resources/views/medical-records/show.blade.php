@extends('layouts.app')

@section('title', 'Medical Record Details - MediCare')

@section('page-title', 'Medical Record Details')

@section('content')

    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $medicalRecord->patient->full_name }}</h2>
                <p class="text-sm text-gray-500">
                    {{ $medicalRecord->patient->patient_code }}
                    · {{ $medicalRecord->patient->gender }}
                    · {{ \Carbon\Carbon::parse($medicalRecord->patient->dob)->age }} years old
                </p>
            </div>

            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                Completed
            </span>
        </div>

        {{-- Patient and Visit Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-600 mb-3">Patient Information</h3>
                <p class="text-sm text-gray-700"><span class="font-medium">Phone:</span> {{ $medicalRecord->patient->phone }}</p>
                <p class="text-sm text-gray-700 mt-2"><span class="font-medium">Blood Type:</span> {{ $medicalRecord->patient->blood_type ?? 'N/A' }}</p>
                <p class="text-sm text-gray-700 mt-2">
                    <span class="font-medium">Allergies:</span>
                    @if($medicalRecord->patient->allergies)
                        <span class="text-red-600 font-medium">⚠ {{ $medicalRecord->patient->allergies }}</span>
                    @else
                        No known allergies
                    @endif
                </p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-600 mb-3">Visit Information</h3>
                <p class="text-sm text-gray-700"><span class="font-medium">Doctor:</span> Dr. {{ $medicalRecord->doctor->name }}</p>
                <p class="text-sm text-gray-700 mt-2"><span class="font-medium">Visit Date:</span> {{ $medicalRecord->visit_date->format('d M Y, h:i A') }}</p>
                <p class="text-sm text-gray-700 mt-2"><span class="font-medium">Appointment Type:</span> {{ $medicalRecord->appointment->appointment_type ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Diagnosis --}}
        <div class="mb-5">
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Diagnosis</h3>
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $medicalRecord->diagnosis }}</p>
            </div>
        </div>

        {{-- Symptoms --}}
        <div class="mb-5">
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Symptoms</h3>
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $medicalRecord->symptoms ?? 'No symptoms recorded.' }}</p>
            </div>
        </div>

        {{-- Treatment Notes --}}
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Treatment Notes</h3>
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $medicalRecord->treatment_notes ?? 'No treatment notes recorded.' }}</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-2">
            <a href="{{ route('medical-records.index') }}"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
                Back
            </a>

            @if(Auth::user()->role !== 'receptionist')
            <a href="{{ route('medical-records.edit', $medicalRecord) }}"
                class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 text-sm font-medium">
                Edit
            </a>

            <form action="{{ route('medical-records.destroy', $medicalRecord) }}" method="POST"
                onsubmit="return confirm('Delete this medical record?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 text-sm font-medium">
                    Delete
                </button>
            </form>
            @endif
        </div>
    </div>

@endsection