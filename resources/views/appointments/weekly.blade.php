@extends('layouts.app')

@section('title', 'Weekly Calendar - MediCare')

@section('page-title', 'Weekly Appointment Calendar')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <form method="GET" action="{{ route('appointments.weekly') }}" class="flex gap-2">
            <input type="date" name="week" value="{{ $startDate->toDateString() }}"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                View Week
            </button>
        </form>

        <a href="{{ route('appointments.index') }}"
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
            Back to List
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-7 gap-4">
        @for($day = $startDate->copy(); $day->lte($endDate); $day->addDay())
            <div class="bg-white rounded-xl shadow p-4 min-h-80">
                <h3 class="text-sm font-bold text-gray-800 mb-1">{{ $day->format('D') }}</h3>
                <p class="text-xs text-gray-400 mb-4">{{ $day->format('d M Y') }}</p>

                <div class="space-y-2">
                    @forelse($appointments->get($day->format('Y-m-d'), collect()) as $appointment)
                        <div class="border border-gray-200 rounded-lg p-3 text-xs">
                            <p class="font-bold text-gray-800">{{ $appointment->scheduled_at->format('h:i A') }}</p>
                            <p class="text-gray-700">{{ $appointment->patient->full_name }}</p>
                            <p class="text-gray-400">Dr. {{ $appointment->doctor->name }}</p>
                            <span class="inline-block mt-2 px-2 py-1 rounded-full text-xs font-medium
                                {{ $appointment->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $appointment->status === 'waiting' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400">No appointments</p>
                    @endforelse
                </div>
            </div>
        @endfor
    </div>

@endsection