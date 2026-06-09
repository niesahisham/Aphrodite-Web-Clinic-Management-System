@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex align-items-center gap-3 mb-4">
        <h4 class="mb-0">INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</h4>
        @if($invoice->payment_status == 'paid')
            <span class="badge bg-success">Paid</span>
        @elseif($invoice->payment_status == 'partial')
            <span class="badge bg-warning text-dark">Partial</span>
        @else
            <span class="badge bg-danger">Unpaid</span>
        @endif
    </div>

    <p class="text-muted">
        Patient: <strong>{{ $invoice->patient->full_name }}</strong> &nbsp;·&nbsp;
        Total: <strong>RM {{ number_format($invoice->total_amount, 2) }}</strong>
    </p>

    <div class="row g-3">
        <div class="col-md-7">
            <div class="card p-3">
                <h6 class="mb-3">Payment History</h6>
                <table class="table table-sm">
                    <thead><tr><th>Amount</th><th>Method</th><th>Date</th></tr></thead>
                    <tbody>
                    @forelse($invoice->payments as $payment)
                        <tr>
                            <td>RM {{ number_format($payment->amount_paid, 2) }}</td>
                            <td>{{ ucfirst($payment->payment_method) }}</td>
                            <td>{{ $payment->paid_at?->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-muted">No payments recorded.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($invoice->status !== 'paid')
        <div class="col-md-5">
            <div class="card p-3">
                <h6 class="mb-3">Record a Payment</h6>
                @if(session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('invoices.pay', $invoice->id) }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small">Amount (RM)</label>
                        <input type="number" step="0.01" name="amount_paid"
                               class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="online">Online Transfer</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Payment</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection