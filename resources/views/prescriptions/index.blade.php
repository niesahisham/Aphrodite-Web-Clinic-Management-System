@extends('layouts.app')

@section('title', 'Prescriptions - MediCare')

@section('page-title', 'Medical Prescriptions')

@section('content')
<div class="container" style="padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Prescription History</h2>
        <a href="{{ route('prescriptions.create') }}" style="background: #2563eb; color: #fff; padding: 10px 15px; border-radius: 5px; text-decoration: none;">+ Issue New Prescription</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 12px;">ID</th>
                <th style="padding: 12px;">Patient Name</th>
                <th style="padding: 12px;">Medication</th>
                <th style="padding: 12px;">Instructions</th>
                <th style="padding: 12px;">Duration</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prescriptions as $p)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 12px;">{{ $p->id }}</td>
                    <td style="padding: 12px;">{{ $p->patient->name }}</td>
                    <td style="padding: 12px; font-weight: bold;">{{ $p->drug->name }}</td>
                    <td style="padding: 12px;">{{ $p->dosage_instructions }}</td>
                    <td style="padding: 12px;">{{ $p->duration }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 12px; text-align: center; color: #6b7280;">No prescriptions issued yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection