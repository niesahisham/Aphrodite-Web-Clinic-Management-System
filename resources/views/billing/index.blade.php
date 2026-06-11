@extends('layouts.app')

@section('title', 'Billing & Payments - MediCare')
@section('page-title', 'Billing & Payments')

@section('content')

{{-- Header with Generate Invoice button --}}
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold text-gray-800">All Invoices</h2>
    <a href="{{ route('invoices.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
        + Generate Invoice
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
    {{ session('success') }}
</div>
@endif


@if(session('success'))
<div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Invoice No.</th>
                <th class="px-6 py-3">Patient</th>
                <th class="px-6 py-3">Total (RM)</th>
                <th class="px-6 py-3">Paid (RM)</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Issued</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($invoices as $invoice)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $invoice->invoice_number }}</td>
                <td class="px-6 py-4">{{ $invoice->patient->full_name }}</td>
                <td class="px-6 py-4">{{ number_format($invoice->total_amount, 2) }}</td>
                <td class="px-6 py-4">{{ number_format($invoice->paid_amount, 2) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $invoice->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $invoice->payment_status === 'unpaid' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $invoice->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ ucfirst($invoice->payment_status) }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($invoice->issued_at)->format('d M Y') }}</td>
                <td class="px-6 py-4 flex gap-2">
                    <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400">No invoices found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $invoices->links() }}</div>
</div>

@endsection