@extends('layouts.app')

@section('title', 'Add Drug - MediCare')

@section('page-title', 'Register New Drug')

@section('content')
<div class="container" style="max-width: 600px; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">Drug Information Form</h2>

    <form action="{{ route('drugs.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Drug Name:</label>
            <input type="text" name="name" placeholder="e.g., Amoxicillin, Paracetamol" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Form:</label>
            <input type="text" name="dosage_form" placeholder="e.g., Tablet, Capsule, Syrup" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Category:</label>
            <input type="text" name="category" placeholder="e.g., Analgesic, Antibiotic" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Strength:</label>
            <input type="text" name="strength" placeholder="e.g., 500mg, 10mg, 5ml" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Unit Price (RM):</label>
            <input type="number" step="0.01" name="unit_price" placeholder="e.g., 0.50" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <button type="submit" style="background: #2563eb; color: #fff; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Save Drug</button>
        <a href="{{ route('drugs.index') }}" style="margin-left: 10px; color: #6b7280; text-decoration: none;">Cancel</a>
    </form>
</div>
@endsection