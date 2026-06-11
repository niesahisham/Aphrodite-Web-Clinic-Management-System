@extends('layouts.app')
@section('title', 'Prescription Details - MediCare')
@section('page-title', 'Prescription Details')
@section('content')
<div class="container" style="max-width:700px;padding:20px;background:#fff;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,.1);margin:0 auto">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <h2 style="margin:0;">{{ $prescription->patient->full_name }}</h2>
            <p style="color:#6b7280;margin:4px 0 0;">Dr. {{ $prescription->doctor->name }}</p>
        </div>
        <span style="padding:4px 12px;border-radius:20px;font-size:12px;
            background:{{ $prescription->status === 'active' ? '#d1fae5' : '#f3f4f6' }};
            color:{{ $prescription->status === 'active' ? '#065f46' : '#374151' }}">
            {{ ucfirst($prescription->status) }}
        </span>
    </div>

    <p style="font-size:13px;color:#9ca3af;margin-bottom:16px;">
        Issued: {{ \Carbon\Carbon::parse($prescription->issued_at)->format('d M Y, h:i A') }}
    </p>

    <h3 style="font-size:15px;margin-bottom:10px;">Medications</h3>
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
        <thead>
            <tr style="background:#f9fafb;">
                <th style="padding:10px;text-align:left;border-bottom:1px solid #e5e7eb;">Drug</th>
                <th style="padding:10px;text-align:left;border-bottom:1px solid #e5e7eb;">Dosage</th>
                <th style="padding:10px;text-align:left;border-bottom:1px solid #e5e7eb;">Frequency</th>
                <th style="padding:10px;text-align:left;border-bottom:1px solid #e5e7eb;">Duration</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prescription->items as $item)
            <tr style="border-bottom:1px solid #f3f4f6;">
                <td style="padding:10px;">{{ $item->drug->name }} ({{ $item->drug->strength }})</td>
                <td style="padding:10px;">{{ $item->dosage }}</td>
                <td style="padding:10px;">{{ $item->frequency }}</td>
                <td style="padding:10px;">{{ $item->duration_days }} day(s)</td>
            </tr>
            @empty
            <tr><td colspan="4" style="padding:10px;color:#9ca3af;">No medications listed.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;display:flex;gap:10px;">
        @if(Auth::user()->role !== 'admin')
        <a href="{{ route('prescriptions.edit', $prescription) }}"
           style="background:#d97706;color:#fff;padding:8px 16px;border-radius:5px;text-decoration:none;">Edit</a>
        @endif
        <a href="{{ route('prescriptions.index') }}"
           style="background:#e5e7eb;color:#374151;padding:8px 16px;border-radius:5px;text-decoration:none;">Back</a>
    </div>
</div>
@endsection