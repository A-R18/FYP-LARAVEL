{{-- A view file which enables doctor to view history of his patient with prescription and appointments. --}}

@extends('dtDashBrd')

@section('doctorToPatientContent')
    @if (isset($appointments) && $appointments->count() > 0)
        <table style="width: 65vw">
            <thead>
                <tr>
                    <th>Slot ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Appointment Date</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->ap_id }}</td>
                        <td>{{ $appointment->patient_name }}</td>
                        <td>{{ $appointment->doctor_name }}</td>
                        <td>{{ $appointment->ap_date }}</td>
                        <td>{{ $appointment->ap_strTime }}</td>
                        <td>{{ $appointment->ap_endTime }}</td>
                        <td>{{ ucfirst($appointment->ap_status) }}</td>
                        <td><button class="btp btvt"><a href="{{ route('payment') }}">Prescription</a></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No appointments found.</p>
    @endif
@endsection
