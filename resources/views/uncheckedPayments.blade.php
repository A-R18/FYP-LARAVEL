<!-- View for admin to check the payments record after verifying them in the appointments view -->

@extends('adminAction')

@section('content')
<div class="admin-payments">
    @if($payments->isEmpty())
        <p style="text-align: center;">No unchecked payments available.</p>
    @else
        <table class="payment-table">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Patient Name</th>
                    <th>Slot ID</th>
                    <th>Account Number</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->py_id }}</td>
                        <td>{{ $payment->uname }}</td>
                        <td>{{ $payment->slot_id }}</td>
                        <td>{{ $payment->acc_no }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->pym_status }}</td>
                        <td>
                            <button class="btt">
                                <a href="{{ route('checkPayment', $payment->py_id) }}">Check</a>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="pagination-links" style="text-align: center;">
            {{ $payments->links() }}
        </div>
    @endif
</div>
@endsection
