@extends('layouts.app')

@section('title', 'Edit Drug - MediCare')
@section('page-title', 'Edit Drug')

@section('content')
<div class="container" style="max-width: 600px; padding: 20px; background: #fff;
     border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">Edit Drug Information</h2>

    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:10px;margin-bottom:15px;border-radius:5px;">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form action="{{ route('drugs.update', $drug->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label style="display:block;margin-bottom:5px;font-weight:bold;">Drug Name:</label>
            <input type="text" name="name" value="{{ old('name', $drug->name) }}" required
                style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display:block;margin-bottom:5px;font-weight:bold;">Form:</label>
            <input type="text" name="dosage_form" value="{{ old('dosage_form', $drug->dosage_form) }}" required
                style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display:block;margin-bottom:5px;font-weight:bold;">Strength:</label>
            <input type="text" name="strength" value="{{ old('strength', $drug->strength) }}" required
                style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;">
        </div>

        <button type="submit" style="background:#2563eb;color:#fff;padding:10px 15px;
            border:none;border-radius:5px;cursor:pointer;">Update Drug</button>
        <a href="{{ route('drugs.index') }}" style="margin-left:10px;color:#6b7280;text-decoration:none;">Cancel</a>
    </form>
</div>
@endsection