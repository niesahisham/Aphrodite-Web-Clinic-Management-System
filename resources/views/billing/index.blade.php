@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <h4 class="mb-4">Invoices</h4>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice No.</th><th>Patient</th>
                        <th>Amount (RM)</th><th>Status</th>
                        <th>Date</th><th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($invoices as $inv)
                    <tr>
                        <td>INV-{{ str_pad($inv->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $inv->patient->name ?? '—' }}</td>
                        <td>{{ number_format($inv->total_amount, 2) }}</td>
                        <td>
                            @if($inv->status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($inv->status == 'partial')
                                <span class="badge bg-warning text-dark">Partial</span>
                            @else
                                <span class="badge bg-danger">Unpaid</span>
                            @endif
                        </td>
                        <td>{{ $inv->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $inv->id) }}"
                               class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No invoices yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $invoices->links() }}</div>
</div>
@endsection