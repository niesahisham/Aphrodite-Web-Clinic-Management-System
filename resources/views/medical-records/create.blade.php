@extends('layouts.app')

@section('title', 'Create Medical Record - MediCare')

@section('page-title', 'Create Medical Record')

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
        <form action="{{ route('medical-records.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Appointment</label>
                <select name="appointment_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <option value="">Select Appointment</option>
                    @foreach($appointments as $appointment)
                        <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                            {{ $appointment->scheduled_at->format('d M Y, h:i A') }}
                            - {{ $appointment->patient->patient_code }}
                            - {{ $appointment->patient->full_name }}
                            - Dr. {{ $appointment->doctor->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Patient and doctor will be linked automatically based on the selected appointment.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Visit Date</label>
                <input type="datetime-local" name="visit_date" value="{{ old('visit_date') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                <textarea name="diagnosis" rows="3" required
                    placeholder="Enter diagnosis..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('diagnosis') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Symptoms</label>
                <textarea name="symptoms" rows="3"
                    placeholder="Enter symptoms reported by patient..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('symptoms') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Treatment Notes</label>
                <textarea name="treatment_notes" rows="4"
                    placeholder="Enter treatment notes, advice, or follow-up instructions..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('treatment_notes') }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                    Save Medical Record
                </button>
                <a href="{{ route('medical-records.index') }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>

@endsection