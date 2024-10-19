{{-- This is view the file which shows the doctors to a patient (for booking an appointment) and visitor of the website (for viewing the doctors ) --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors</title>

    <link rel="stylesheet" href="{{ asset('/css/drDisplay.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="prt"></div>
    <div class="mn">
        @php

            // dd($doctors);
        @endphp
        @foreach ($doctors as $doctorz)
            <div class="crd">
                <img src="{{ asset('uploads/' . $doctorz->dtimg) }}" alt="dr_pic">
                <h3 class="cditm">{{ $doctorz->uname }}</h3>
                <h5 class="cditm">{{ $doctorz->dtspez }}</h5>
                <h5 class="cditm">Fee : {{ $doctorz->dt_fee }}</h5>
                <h5 class="cditm">Status : {{ $doctorz->status }}</h5>
                <h6 class="cditm">
                    <span>{{ \Carbon\Carbon::parse($doctorz->strtime)->format('h:i A') }}</span>
                    <span>{{ '  -  ' }}</span>
                    <span>{{ \Carbon\Carbon::parse($doctorz->endtime)->format('h:i A') }}</span>
                    
                </h6>
                {{--  <span>{{ \Carbon\Carbon::parse($prescription->ap_strTime)->format('h:i A') }}</span> --}}
                {{-- Ensure the route parameters are correctly passed to 'docdtasnd' route --}}
                <a href="{{ route('appointments.create', ['doctor_id' => $doctorz->id]) }}" class="cditm">
                    <button class="cditm" value="take_appointment">Take Appointment</button>
                </a>
            </div>
        @endforeach
    </div>
</body>

</html>
