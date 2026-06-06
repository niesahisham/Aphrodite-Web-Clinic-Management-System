@extends('layouts.app')

@section('title', $patient->full_name . ' - MediCare')

@section('page-title', 'Patient Profile')

@section('content')

    {{-- Patient Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $patient->full_name }}</h2>
            <p class="text-sm text-gray-500">{{ $patient->gender }} · {{ \Carbon\Carbon::parse($patient->dob)->age }} years old · ID: {{ $patient->patient_code }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-sm font-medium
            {{ $patient->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
            {{ $patient->status }}
        </span>
    </div>

    {{-- Info & Allergies --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="text-sm font-semibold text-gray-600 mb-3">Patient Info</h3>
            <p class="text-sm text-gray-700"><span class="font-medium">Phone:</span> {{ $patient->phone }}</p>
            <p class="text-sm text-gray-700 mt-2"><span class="font-medium">Address:</span> {{ $patient->address ?? 'N/A' }}</p>
            <p class="text-sm text-gray-700 mt-2"><span class="font-medium">Blood Type:</span> {{ $patient->blood_type ?? 'N/A' }}</p>
            <p class="text-sm text-gray-700 mt-2"><span class="font-medium">Date of Birth:</span> {{ \Carbon\Carbon::parse($patient->dob)->format('M d, Y') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="text-sm font-semibold text-gray-600 mb-3">Allergies</h3>
            @if($patient->allergies)
                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                    <p class="text-red-600 font-medium text-sm">⚠ {{ $patient->allergies }}</p>
                </div>
            @else
                <p class="text-gray-400 text-sm">No known allergies</p>
            @endif
        </div>
    </div>

    {{-- Recent Visit History --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-600 mb-4">Recent Visit History</h3>
        @forelse($patient->medicalRecords as $record)
        <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ $record->diagnosis }}</p>
                <p class="text-xs text-gray-500">
                    {{ \Carbon\Carbon::parse($record->visit_date)->format('M d, Y') }} · 
                    Dr. {{ $record->doctor->name }}
                </p>
            </div>
            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Completed</span>
        </div>
        @empty
        <p class="text-gray-400 text-sm">No visit history yet.</p>
        @endforelse
    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-3">
        <a href="{{ route('patients.index') }}"
            class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
            Back
        </a>
        @if(Auth::user()->role !== 'admin')
        <a href="{{ route('patients.edit', $patient) }}"
            class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 text-sm font-medium">
            Edit Patient
        </a>
        <form action="{{ route('patients.destroy', $patient) }}" method="POST"
            onsubmit="return confirm('Delete this patient?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 text-sm font-medium">
                Delete Patient
            </button>
        </form>
        @endif
    </div>

@endsection