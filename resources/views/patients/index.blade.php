@extends('layouts.app')

@section('title', 'Patient Management - MediCare')

@section('page-title', 'Patient Management')

@section('content')

    {{-- Header Actions --}}
    <div class="flex justify-between items-center mb-6">
        @if(Auth::user()->role !== 'receptionist')
            <a href="{{ route('patients.create') }}">+ New Patient</a>
        @endif
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- Search Bar --}}
    <form method="GET" action="{{ route('patients.index') }}" class="mb-6">
        <input type="text" name="search" value="{{ $search }}"
            placeholder="Search patients by name or ID..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
    </form>

    {{-- Patient Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Patient ID</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Age</th>
                    <th class="px-6 py-3">Gender</th>
                    <th class="px-6 py-3">Phone</th>
                    <th class="px-6 py-3">Allergies</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($patients as $patient)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $patient->patient_code }}</td>
                    <td class="px-6 py-4">{{ $patient->full_name }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($patient->dob)->age }} yrs</td>
                    <td class="px-6 py-4">{{ $patient->gender }}</td>
                    <td class="px-6 py-4">{{ $patient->phone }}</td>
                    <td class="px-6 py-4">
                        @if($patient->allergies)
                            <span class="text-red-500 font-medium">⚠ {{ $patient->allergies }}</span>
                        @else
                            <span class="text-gray-400">None</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $patient->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $patient->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('patients.show', $patient) }}"
                            class="text-blue-600 hover:underline">View</a>
                        @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('patients.edit', $patient) }}"
                            class="text-yellow-600 hover:underline">Edit</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-400">No patients found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection