
<!-- A view file which shows payment status of patients about their appointments -->
@extends('ptDashBrd') 


@section('content')

    
    
    @if($payments->isEmpty())
        <p>You have no payments recorded.</p>
    @else
        <table class="p_py_tb">
            <thead>
                <tr>
                    <th>Slot ID</th>
                    <th>Name</th>
                    <th>Account Number</th>
                    <th>Amount</th>
                    <th>Status</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->slot_id }}</td>
                        <td>{{ $payment->uname }}</td>
                        <td>{{ $payment->acc_no }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->pym_status }}</td>
                      
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="pagination-links">
            {{ $payments->links() }}
    @endif
@endsection
