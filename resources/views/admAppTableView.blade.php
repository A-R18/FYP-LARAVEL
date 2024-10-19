{{-- This sub view shows the pending appointments to the admin which he can verify --}}
@extends('adminAction')

@section('content')

    @if (isset($appointments) && count($appointments) > 0)
        <table>
            <thead>
                <tr>
                    <th>Slot ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th colspan="2">Action</th>
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
                        <td>{{ $appointment->ap_status }}</td>
                        <td>
                            @if ($appointment->ap_status === 'pending')
                                <button><a href="{{ route('appointments.verify', $appointment->ap_id) }}"
                                        class="btt">Verify</a></button>
                            @else
                                <span>Verified</span>
                            @endif
                        </td>
                        <td><button class="lobt lobbt"><a
                                    href="{{ route('deleteByAdmin', $appointment->ap_id) }}">Delete</a></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No verifiable slots yet.</p>
    @endif

@endsection
