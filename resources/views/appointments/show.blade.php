@extends('layouts.app')

@section('title', 'Appointment Details - MediCare')

@section('page-title', 'Appointment Details')

@section('content')

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $appointment->patient->full_name }}</h2>
                <p class="text-sm text-gray-400">{{ $appointment->patient->patient_code }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-medium
                {{ $appointment->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $appointment->status === 'waiting' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                {{ ucfirst($appointment->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Doctor</p>
                <p class="font-medium">Dr. {{ $appointment->doctor->name }}</p>
            </div>
            <div>
                <p class="text-gray-400">Booked By</p>
                <p class="font-medium">{{ $appointment->bookedBy->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Appointment Type</p>
                <p class="font-medium">{{ $appointment->appointment_type }}</p>
            </div>
            <div>
                <p class="text-gray-400">Scheduled At</p>
                <p class="font-medium">{{ $appointment->scheduled_at->format('d M Y, h:i A') }}</p>
            </div>
            <div>
                <p class="text-gray-400">Queue No.</p>
                <p class="font-medium">
                    @if($appointment->queue_no)
                        Q{{ str_pad($appointment->queue_no, 3, '0', STR_PAD_LEFT) }} - {{ ucfirst($appointment->queue_status) }}
                    @else
                        Not in queue
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-400">Reason</p>
                <p class="font-medium">{{ $appointment->reason ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-5">
            <p class="text-gray-400 text-sm">Notes</p>
            <p class="text-sm font-medium">{{ $appointment->notes ?? '-' }}</p>
        </div>

        <div class="mt-6 flex gap-2">
            <a href="{{ route('appointments.index') }}"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
                Back
            </a>
            @if(Auth::user()->role !== 'admin')
            <a href="{{ route('appointments.edit', $appointment) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                Edit
            </a>
            @endif
        </div>
    </div>

@endsection