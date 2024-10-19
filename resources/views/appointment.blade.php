{{-- This view shows the appointment form which enables a patient to book an appointment --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Book Appointment' }}</title>
    <link rel="stylesheet" href="{{ asset('/css/appointment.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <script src="{{ asset('scripts/appointmentForm.js') }}" defer></script>
</head>

<body>
    <div class="prt"></div>

    <div class="errmn">

        @if (session()->has('error'))
        <div class="npr">
    
            <div class="dgr">
                <p>{{ session()->get('error') }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="mn">
        
        @if(isset($doctor))
            @php
              
            @endphp
        @else
            <p>Doctor data is not available.</p>
        @endif



     
       

        <form action="{{ route('appointments.store', ['doctor_id' => $doctor->id]) }}" method="post" id="appointment-form">
            @csrf


          
            <input type="hidden" id="booked-slots-data" value='@json($bookedSlots)'>
            <input type="hidden" id="doctor-start-time" value="{{ $doctor->strtime }}">
            <input type="hidden" id="doctor-end-time" value="{{ $doctor->endtime }}">   
            <input type="hidden" id="doctor-status" value="{{ $doctor->status }}">
            <input type="hidden" id="doctor_id" value="{{ $doctor->id }}"> 
            {{-- <input type="hidden" id="patient_id" value="{{ $patientId }}">     --}}
            {{-- @php
            dd($bookedSlots);
@endphp --}}    
           
            <div class="ch">
                <div class="chl"><label for="uname">Name</label></div>
                <div class="chi"><input type="text" name="uname" id="uname" value="{{ $doctorName }}" readonly></div>
            </div>

            <div class="ch">
                <div class="chl"><label for="apdate">Date</label></div>
                <div class="chi"><input type="date" name="apdate" id="apdate" required>
                    <span>@error('apdate'){{ $message }}@enderror</span>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="timing">Time</label></div>
                <div class="chi"><select name="timing" id="timing">
                    <option value="">Select Time</option>
                </select>
                    <span>@error('timing'){{ $message }}@enderror</span>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="aptime">Type</label></div>
                <div class="chi"><select name="aptime" id="aptime">
                    <option value="Physical">Physical</option>
                    <option value="Online">Online</option>
                </select>
                    <span>@error('aptime'){{ $message }}@enderror</span>
                </div>
            </div>

            <div class="ch btch">
                <button type="submit">Reserve Slot</button>
            </div>
        </div>
        </form>
    
</body>
</html>
