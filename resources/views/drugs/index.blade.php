@extends('layouts.app')

@section('title', 'Drugs List - MediCare')

@section('page-title', 'Pharmacy Inventory')

@section('content')
<div class="container" style="padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Registered Medications</h2>
        <a href="{{ route('drugs.create') }}" style="background: #2563eb; color: #fff; padding: 10px 15px; border-radius: 5px; text-decoration: none;">+ Add New Drug</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 12px;">Name</th>
                <th style="padding: 12px;">Form</th>
                <th style="padding: 12px;">Dosage</th>
                <th style="padding: 12px;">Strength</th>
            </tr>
        </thead>
        <tbody>
            @forelse($drugs as $drug)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 12px; font-weight: bold;">{{ $drug->name }}</td>
                    <td style="padding: 12px;">{{ $drug->form }}</td>
                    <td style="padding: 12px;">{{ $drug->dosage }}</td>
                    <td style="padding: 12px;">{{ $drug->strength }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding: 12px; text-align: center; color: #6b7280;">No drugs registered in inventory yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection