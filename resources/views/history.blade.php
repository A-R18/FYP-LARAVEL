

<!-- A view file for doctor to view the appointment history of his patient with him  -->
@extends('dtDashBrd') 

@section('doctorToPatientContent') <!-- Define the content section -->
    @if (session()->has('success'))
    <div class="npr">
        <div class="lrt">
            <p>{{ session()->get('success') }}</p>
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="npr">
        <div class="dgr">
            <p>{{ session()->get('error') }}</p>
        </div>
    </div>
    @endif

    @if (isset($appointments) && $appointments->count() > 0)
    <table>
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
                <td>{{ \Carbon\Carbon::parse($appointment->ap_strTime)->format('h:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($appointment->ap_endTime)->format('h:i A') }}</td>
                <td>{{ ucfirst($appointment->ap_status) }}</td>
                <td><button class="btp btvt"><a href="{{ route('showPrescriptionToDoctor', ['appointment_id' => $appointment->ap_id]) }}">Prescription</a></button></td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No past appointments with you.</p>
    @endif
@endsection
