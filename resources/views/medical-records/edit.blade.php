@extends('layouts.app')

@section('title', 'Edit Medical Record - MediCare')

@section('page-title', 'Edit Medical Record')

@section('content')

    {{-- Error Messages --}}
    @if($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl">
        <form action="{{ route('medical-records.update', $medicalRecord) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Appointment</label>
                <select name="appointment_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    @foreach($appointments as $appointment)
                        <option value="{{ $appointment->id }}" {{ old('appointment_id', $medicalRecord->appointment_id) == $appointment->id ? 'selected' : '' }}>
                            {{ $appointment->scheduled_at->format('d M Y, h:i A') }}
                            - {{ $appointment->patient->patient_code }}
                            - {{ $appointment->patient->full_name }}
                            - Dr. {{ $appointment->doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Visit Date</label>
                <input type="datetime-local" name="visit_date"
                    value="{{ old('visit_date', $medicalRecord->visit_date->format('Y-m-d\TH:i')) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                <textarea name="diagnosis" rows="3" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Symptoms</label>
                <textarea name="symptoms" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('symptoms', $medicalRecord->symptoms) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Treatment Notes</label>
                <textarea name="treatment_notes" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('treatment_notes', $medicalRecord->treatment_notes) }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                    Update Medical Record
                </button>
                <a href="{{ route('medical-records.show', $medicalRecord) }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>

@endsection