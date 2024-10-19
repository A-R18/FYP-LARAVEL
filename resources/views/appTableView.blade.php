<!-- This view files shows the pending appointments of a patient along with the option to navigate to fee payment form -->
@extends('ptDashBrd')


@section('content')
    <!-- Define the content section -->



    @if (isset($appointments) && $appointments->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Slot ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th> <!-- Added Doctor Name -->
                    <th>Appointment Date</th>
                    <th>From</th> <!-- Updated to match the migration attribute -->
                    <th>To</th> <!-- Added to show end time -->
                    <th>Status</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->ap_id }}</td>
                        <td>{{ $appointment->patient_name }}</td>
                        <td>{{ $appointment->doctor_name }}</td> <!-- Display the relevant Doctor Name -->
                        <td>{{ $appointment->ap_date }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->ap_strTime)->format('h:i A') }}</td>
                 <td>{{ \Carbon\Carbon::parse($appointment->ap_endTime)->format('h:i A') }}</td> <!-- Display End Time -->
                        <td>{{ ucfirst($appointment->ap_status) }}</td>
                        <td><button class="btp"><a href="{{ route('payment', $appointment->ap_id) }}">Pay Fee</a></button>
                        </td>
                        <td><button class="lobt lobbt"><a
                                    href="{{ route('deleteByPatient', $appointment->ap_id) }}">Delete</a></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No reserved slots yet.</p>
    @endif
    @php
        // dd($appointments);
    @endphp
@endsection
