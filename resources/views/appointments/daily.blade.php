@extends('layouts.app')

@section('title', 'Daily Calendar - MediCare')

@section('page-title', 'Daily Appointment Calendar')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <form method="GET" action="{{ route('appointments.daily') }}" class="flex gap-2">
            <input type="date" name="date" value="{{ $date }}"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                View
            </button>
        </form>

        <a href="{{ route('appointments.index') }}"
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">{{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}</h2>

        <div class="space-y-3">
            @forelse($appointments as $appointment)
                <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-center hover:bg-gray-50">
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ $appointment->scheduled_at->format('h:i A') }} - {{ $appointment->patient->full_name }}</p>
                        <p class="text-xs text-gray-400">Dr. {{ $appointment->doctor->name }} | {{ $appointment->appointment_type }}</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $appointment->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $appointment->status === 'waiting' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            @empty
                <p class="text-center text-gray-400 py-8">No appointments for this date.</p>
            @endforelse
        </div>
    </div>

@endsection