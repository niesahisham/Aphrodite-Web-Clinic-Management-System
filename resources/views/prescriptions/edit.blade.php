@extends('layouts.app')
@section('title', 'Edit Prescription - MediCare')
@section('page-title', 'Edit Prescription')
@section('content')
<div class="container" style="max-width:600px;padding:20px;background:#fff;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,.1);margin:0 auto">
    <h2 style="margin-bottom:20px;">Update Prescription Status</h2>

    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:10px;margin-bottom:15px;border-radius:5px;">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form action="{{ route('prescriptions.update', $prescription) }}" method="POST">
        @csrf
        @method('PATCH')

        <div style="margin-bottom:15px;">
            <label style="display:block;margin-bottom:5px;font-weight:bold;">Patient</label>
            <input type="text" value="{{ $prescription->patient->full_name }}" disabled
                style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;background:#f3f4f6;">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block;margin-bottom:5px;font-weight:bold;">Status</label>
            <select name="status" required style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;">
                @foreach(['active','administered','completed','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $prescription->status === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" style="background:#2563eb;color:#fff;padding:10px 15px;border:none;border-radius:5px;cursor:pointer;">
            Update
        </button>
        <a href="{{ route('prescriptions.index') }}" style="margin-left:10px;color:#6b7280;text-decoration:none;">Cancel</a>
    </form>
</div>
@endsection