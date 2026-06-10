@extends('layouts.app')

@section('title', 'Electronic Medical Records - MediCare')

@section('page-title', 'Electronic Medical Records')

@section('content')

    {{-- Header Actions --}}
    <div class="flex justify-between items-center mb-6">
        <form method="GET" action="{{ route('medical-records.index') }}" class="flex gap-2 w-2/3">
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Search by patient, doctor, or diagnosis..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

            <input type="date" name="date" value="{{ $date }}"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                Search
            </button>
        </form>

        @if(Auth::user()->role !== 'receptionist')
        <a href="{{ route('medical-records.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
            + New Medical Record
        </a>
        @endif
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- Medical Records Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Visit Date</th>
                    <th class="px-6 py-3">Patient</th>
                    <th class="px-6 py-3">Doctor</th>
                    <th class="px-6 py-3">Diagnosis</th>
                    <th class="px-6 py-3">Symptoms</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($records as $record)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">
                        {{ $record->visit_date->format('d M Y') }}<br>
                        <span class="text-gray-400">{{ $record->visit_date->format('h:i A') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $record->patient->full_name }}<br>
                        <span class="text-gray-400">{{ $record->patient->patient_code }}</span>
                    </td>
                    <td class="px-6 py-4">Dr. {{ $record->doctor->name }}</td>
                    <td class="px-6 py-4">{{ Str::limit($record->diagnosis, 40) }}</td>
                    <td class="px-6 py-4">
                        {{ $record->symptoms ? Str::limit($record->symptoms, 40) : '-' }}
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('medical-records.show', $record) }}"
                            class="text-blue-600 hover:underline">View</a>

                        @if(Auth::user()->role !== 'receptionist')
                        <a href="{{ route('medical-records.edit', $record) }}"
                            class="text-yellow-600 hover:underline">Edit</a>

                        <form action="{{ route('medical-records.destroy', $record) }}" method="POST"
                            onsubmit="return confirm('Delete this medical record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">No medical records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection