@extends('layouts.app')

@section('title', 'Queue Management - MediCare')

@section('page-title', 'Queue Management')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <form method="GET" action="{{ route('queue.index') }}" class="flex gap-2">
            <input type="date" name="date" value="{{ $date }}"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                View
            </button>
        </form>

        <a href="{{ route('queue.display') }}" target="_blank"
            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 text-sm font-medium">
            Open Display Board
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Queue No.</th>
                    <th class="px-6 py-3">Time</th>
                    <th class="px-6 py-3">Patient</th>
                    <th class="px-6 py-3">Doctor</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($appointments as $appointment)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold text-purple-700">
                        @if($appointment->queue_no)
                            Q{{ str_pad($appointment->queue_no, 3, '0', STR_PAD_LEFT) }}
                        @else
                            <span class="text-gray-400 font-normal">Not checked in</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $appointment->scheduled_at->format('h:i A') }}</td>
                    <td class="px-6 py-4">
                        {{ $appointment->patient->full_name }}<br>
                        <span class="text-gray-400">{{ $appointment->patient->patient_code }}</span>
                    </td>
                    <td class="px-6 py-4">Dr. {{ $appointment->doctor->name }}</td>
                    <td class="px-6 py-4">
                        @if($appointment->queue_status)
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $appointment->queue_status === 'waiting' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $appointment->queue_status === 'called' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $appointment->queue_status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $appointment->queue_status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($appointment->queue_status) }}
                            </span>
                        @else
                            <span class="text-gray-400">Confirmed</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 flex gap-2 flex-wrap">
                        @if(!$appointment->queue_no && $appointment->status === 'confirmed')
                            <form action="{{ route('queue.check-in', $appointment) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-purple-600 hover:underline">Check In</button>
                            </form>
                        @endif

                        @if($appointment->queue_status === 'waiting')
                            <form action="{{ route('queue.call', $appointment) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-blue-600 hover:underline">Call</button>
                            </form>
                        @endif

                        @if(in_array($appointment->queue_status, ['waiting', 'called']))
                            <form action="{{ route('queue.complete', $appointment) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-green-600 hover:underline">Complete</button>
                            </form>

                            <form action="{{ route('queue.cancel', $appointment) }}" method="POST" onsubmit="return confirm('Cancel this queue?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-red-600 hover:underline">Cancel</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">No queue records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection