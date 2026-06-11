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
            <tr style="background:#f3f4f6;border-bottom:2px solid #e5e7eb;">
                <th style="padding:12px;">ID</th>
                <th style="padding:12px;">Patient Name</th>
                <th style="padding:12px;">Medication</th>
                <th style="padding:12px;">Instructions</th>
                <th style="padding:12px;">Duration</th>
                <th style="padding:12px;">Status</th>
                <th style="padding:12px;">Issued Date</th>
                <th style="padding:12px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prescriptions as $p)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 12px;">{{ $p->id }}</td>
                    
                    <td style="padding: 12px;">
                        @if($p->patient)
                            {{ $p->patient->name ?? $p->patient->full_name ?? $p->patient->patient_name ?? ($p->patient->first_name . ' ' . ($p->patient->last_name ?? '')) }}
                        @else
                            <span style="color: #9ca3af;">No Patient Assigned</span>
                        @endif
                    </td>
                    
                    <td style="padding: 12px; font-weight: bold;">
                        @foreach($p->items as $item)
                            <div>{{ $item->drug->name ?? 'Unknown Drug' }}</div>
                        @endforeach
                    </td>

                    <td style="padding: 12px;">
                        @foreach($p->items as $item)
                            <div>{{ $item->dosage }} <span style="color: #6b7280; font-size: 0.85em;">({{ $item->frequency }})</span></div>
                        @endforeach
                    </td>

                    <td style="padding: 12px;">
                        @foreach($p->items as $item)
                            <div>{{ $item->duration_days }}</div>
                        @endforeach
                    </td>
                    
                    <td style="padding: 12px;">
                        <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px;" 
                              class="{{ $p->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
            
                    <td style="padding: 12px;">{{ \Carbon\Carbon::parse($p->issued_at)->format('d M Y') }}</td>

                    <td style="padding:12px;">
                        <a href="{{ route('prescriptions.show', $p) }}" style="color:#2563eb;text-decoration:underline;">View</a>
                        @if(Auth::user() && Auth::user()->role !== 'admin')
                            | <a href="{{ route('prescriptions.edit', $p) }}" style="color:#d97706;text-decoration:underline;">Edit</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="padding: 12px; text-align: center; color: #6b7280;">No prescriptions issued yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection