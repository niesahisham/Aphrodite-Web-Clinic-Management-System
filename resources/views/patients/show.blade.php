<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $patient->full_name }} - MediCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $patient->full_name }}</h1>
                <p class="text-gray-500 text-sm">{{ $patient->gender }} · {{ \Carbon\Carbon::parse($patient->dob)->age }} years old · ID: {{ $patient->patient_code }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $patient->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $patient->status }}
            </span>
        </div>

        {{-- Basic Info & Allergies --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-sm font-semibold text-gray-600 mb-3">Patient Info</h2>
                <p class="text-sm text-gray-700"><span class="font-medium">Phone:</span> {{ $patient->phone }}</p>
                <p class="text-sm text-gray-700 mt-1"><span class="font-medium">Address:</span> {{ $patient->address ?? 'N/A' }}</p>
                <p class="text-sm text-gray-700 mt-1"><span class="font-medium">Blood Type:</span> {{ $patient->blood_type ?? 'N/A' }}</p>
                <p class="text-sm text-gray-700 mt-1"><span class="font-medium">Date of Birth:</span> {{ \Carbon\Carbon::parse($patient->dob)->format('M d, Y') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-sm font-semibold text-gray-600 mb-3">Allergies</h2>
                @if($patient->allergies)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <p class="text-red-600 font-medium">⚠ {{ $patient->allergies }}</p>
                    </div>
                @else
                    <p class="text-gray-400 text-sm">No known allergies</p>
                @endif
            </div>
        </div>

        {{-- Recent Visit History --}}
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-sm font-semibold text-gray-600 mb-4">Recent Visit History</h2>
            @forelse($patient->medicalRecords as $record)
            <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $record->diagnosis }}</p>
                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($record->visit_date)->format('M d, Y') }} · Dr. {{ $record->doctor->name }}</p>
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
                class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                Back
            </a>
            @if(Auth::user()->role !== 'admin')
            <a href="{{ route('patients.edit', $patient) }}"
                class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                Edit Patient
            </a>
            <form action="{{ route('patients.destroy', $patient) }}" method="POST"
                onsubmit="return confirm('Delete this patient?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600">
                    Delete Patient
                </button>
            </form>
            @endif
        </div>
    </div>
</body>
</html>