@extends('layouts.app')
@section('title', 'Drugs List - MediCare')
@section('page-title', 'Pharmacy Inventory')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold text-gray-800">Registered Medications</h2>
    <a href="{{ route('drugs.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
        + Add New Drug
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
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Form</th>
                <th class="px-6 py-3">Category</th> <th class="px-6 py-3">Strength</th>
                <th class="px-6 py-3">Unit Price</th> <th class="px-6 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($drugs as $drug)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $drug->name }}</td>
                <td class="px-6 py-4">{{ $drug->dosage_form }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $drug->category }}</td> <td class="px-6 py-4">{{ $drug->strength }}</td>
                <td class="px-6 py-4 text-gray-600">RM {{ number_format($drug->unit_price, 2) }}</td> <td class="px-6 py-4 flex justify-center gap-4">
                    <a href="{{ route('drugs.edit', $drug->id) }}" 
                       class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('drugs.destroy', $drug->id) }}" method="POST"
                          onsubmit="return confirm('Delete this drug?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400"> No drugs registered yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection