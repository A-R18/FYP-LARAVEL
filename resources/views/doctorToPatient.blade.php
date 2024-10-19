<!-- This is the view file which provides a view to the doctor for writing prescription, marking a patient's appointment as attended & veiwing his patient's appointment history -->

@extends('dtDashBrd') <!--  This view extends the doctor's dashboard layout -->

@section('doctorToPatientContent')
    <!-- Section to inject content into the .mn section -->
    @php
        // dd($appointments);
    @endphp
    @if (isset($appointments) && count($appointments) > 0)
        <table class="tbl">
            <thead>
                <tr>
                    <th>Patient's Name</th>
                    <th>Starts at</th>
                    <th>Ends at</th>
                    <th>Patient's Age</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // dd($appointments);
                @endphp
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient_name }}</td>
                        <td>{{ $appointment->ap_strTime }}</td>
                        <td>{{ $appointment->ap_endTime }}</td>
                        <td>{{ $appointment->patient_age }}</td>
                        <td>
                            <button class=" bthst ">
                                <a href="{{ route('doctor.patientHistory', ['patientId' => $appointment->patient_id]) }}">View
                                    History</a>

                            </button>
                        </td>
                    </tr>
                    <tr class="prcpt">
                        <td colspan="3">
                            <form action="{{ route('prescription.store') }}" method="post" required>
                                @csrf
                                <!-- Hidden fields to pass doctor_id and patient_id -->
                                <input type="hidden" name="doctor_id" value="{{ session()->get('user_id') }}">
                                <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                                <input type="hidden" name="appointment_id" value="{{ $appointment->ap_id }}">
                                <textarea name="pr_desc" cols="85" rows="20" placeholder="Write Prescription & Diagnosis" required></textarea>
                        </td>
                        <td class="">
                            <button class="bt2" type="submit">Upload</button>
                        </td>
                        </form>
                        <td class=" tick">
                            <!-- Update status to 'attended' -->
                            <a href="{{ route('appointment.attended', ['appointmentId' => $appointment->ap_id]) }}">
                                <button class="bt2">Tick</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- @if (isset($appointments) && count($appointments) > 2)
        <!-- Pagination links -->
        {{ $appointment->links() }}
        @endif --}}
    @else
        <p>NO APPOINTMENTS YET </p>
    @endif
@endsection
