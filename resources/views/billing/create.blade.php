@extends('layouts.app')

@section('title', 'Generate Invoice - MediCare')
@section('page-title', 'Generate Invoice')

@section('content')

@if($errors->any())
<div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
    @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form action="{{ route('invoices.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Completed Appointment
            </label>
            <select name="appointment_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none
                       focus:ring-2 focus:ring-blue-500 text-sm">
                <option value="">-- Select Appointment --</option>
                @forelse($appointments as $apt)
                    <option value="{{ $apt->id }}">
                        {{ $apt->scheduled_at->format('d M Y, h:i A') }}
                        — {{ $apt->patient->full_name }}
                        ({{ $apt->patient->patient_code }})
                        — Dr. {{ $apt->doctor->name }}
                    </option>
                @empty
                    <option disabled>No completed appointments without invoices.</option>
                @endforelse
            </select>
            <p class="text-xs text-gray-400 mt-1">
                Only completed appointments without existing invoices are listed.
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Total Amount (RM)
            </label>
            <input type="number" name="total_amount" step="0.01" min="0.01"
                   placeholder="e.g. 150.00" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none
                          focus:ring-2 focus:ring-blue-500 text-sm">
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                Generate Invoice
            </button>
            <a href="{{ route('invoices.index') }}"
                class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection