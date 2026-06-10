@extends('layouts.app')

@section('title', 'Invoice Details - MediCare')
@section('page-title', 'Invoice Details')

@section('content')

<div class="bg-white rounded-xl shadow p-6 max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $invoice->invoice_number }}</h2>
            <p class="text-sm text-gray-400">{{ $invoice->patient->full_name }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-medium
            {{ $invoice->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
            {{ $invoice->payment_status === 'unpaid' ? 'bg-red-100 text-red-700' : '' }}
            {{ $invoice->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-700' : '' }}">
            {{ ucfirst($invoice->payment_status) }}
        </span>
    </div>

    <div class="grid grid-cols-2 gap-4 text-sm mb-6">
        <div><p class="text-gray-400">Total Amount</p>
             <p class="font-medium">RM {{ number_format($invoice->total_amount, 2) }}</p></div>
        <div><p class="text-gray-400">Paid Amount</p>
             <p class="font-medium">RM {{ number_format($invoice->paid_amount, 2) }}</p></div>
        <div><p class="text-gray-400">Balance Due</p>
             <p class="font-medium text-red-600">RM {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</p></div>
        <div><p class="text-gray-400">Issued At</p>
             <p class="font-medium">{{ \Carbon\Carbon::parse($invoice->issued_at)->format('d M Y, h:i A') }}</p></div>
    </div>

    {{-- Payment History --}}
    <h3 class="text-sm font-semibold text-gray-600 mb-3">Payment History</h3>
    @forelse($invoice->payments as $payment)
    <div class="flex justify-between items-center py-2 border-b border-gray-100 text-sm">
        <span>{{ ucfirst($payment->payment_method) }}</span>
        <span>RM {{ number_format($payment->amount_paid, 2) }}</span>
        <span class="text-gray-400">{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}</span>
    </div>
    @empty
    <p class="text-gray-400 text-sm">No payments recorded yet.</p>
    @endforelse

    {{-- Record Payment Form --}}
    @if($invoice->payment_status !== 'paid')
    <div class="mt-6 border-t pt-4">
        <h3 class="text-sm font-semibold text-gray-600 mb-3">Record Payment</h3>
        <form action="{{ route('invoices.pay', $invoice->id) }}" method="POST" class="flex gap-3 flex-wrap">
            @csrf
            <input type="number" name="amount_paid" step="0.01" placeholder="Amount (RM)"
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <select name="payment_method" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="online">Online</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                Record Payment
            </button>
        </form>
    </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('invoices.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
            Back
        </a>
    </div>
</div>

@endsection