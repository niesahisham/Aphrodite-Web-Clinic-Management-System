@extends('layouts.app')

@section('title', 'Appointment Management - MediCare')

@section('page-title', 'Appointment Management')

@section('content')

    {{-- Header Actions --}}
    <div class="flex justify-between items-center mb-6">
        <div class="flex gap-2">
            <a href="{{ route('appointments.daily') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 text-sm font-medium">
                Daily View
            </a>
            <a href="{{ route('appointments.weekly') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 text-sm font-medium">
                Weekly View
            </a>
            <a href="{{ route('queue.index') }}"
                class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 text-sm font-medium">
                Queue
            </a>
        </div>

        @if(Auth::user()->role !== 'admin')
        <a href="{{ route('appointments.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
            + New Appointment
        </a>
        @endif
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- Search and Filter --}}
    <form method="GET" action="{{ route('appointments.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">
        <input type="text" name="search" value="{{ $search }}"
            placeholder="Search patient or doctor..."
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

        <input type="date" name="date" value="{{ $date }}"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

        <select name="status"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            <option value="">All Status</option>
            <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="waiting" {{ $status === 'waiting' ? 'selected' : '' }}>Waiting</option>
            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
            Filter
        </button>
    </form>

    {{-- Appointment Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Time</th>
                    <th class="px-6 py-3">Patient</th>
                    <th class="px-6 py-3">Doctor</th>
                    <th class="px-6 py-3">Type</th>
                    <th class="px-6 py-3">Queue</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($appointments as $appointment)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">
                        {{ $appointment->scheduled_at->format('d M Y') }}<br>
                        <span class="text-gray-400">{{ $appointment->scheduled_at->format('h:i A') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $appointment->patient->full_name }}<br>
                        <span class="text-gray-400">{{ $appointment->patient->patient_code }}</span>
                    </td>
                    <td class="px-6 py-4">Dr. {{ $appointment->doctor->name }}</td>
                    <td class="px-6 py-4">{{ $appointment->appointment_type }}</td>
                    <td class="px-6 py-4">
                        @if($appointment->queue_no)
                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs font-medium">
                                Q{{ str_pad($appointment->queue_no, 3, '0', STR_PAD_LEFT) }} - {{ ucfirst($appointment->queue_status) }}
                            </span>
                        @else
                            <span class="text-gray-400">Not in queue</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $appointment->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $appointment->status === 'waiting' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex gap-2 flex-wrap">
                        <a href="{{ route('appointments.show', $appointment) }}"
                            class="text-blue-600 hover:underline">View</a>

                        @if(Auth::user()->role !== 'admin' && $appointment->status !== 'cancelled')
                        <a href="{{ route('appointments.edit', $appointment) }}"
                            class="text-yellow-600 hover:underline">Edit</a>

                        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST"
                            onsubmit="return confirm('Cancel this appointment?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-red-600 hover:underline">Cancel</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">No appointments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection