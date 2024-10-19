
{{-- This view file is the admin dashboard which enables an admin to verify an appointment, delete an appointment or check a payment record submitted by a patient --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('/css/adminAction.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="prt"></div>
    <div class="box">
        <div class="ttb">
            <div class="nam">Welcome Admin</div>
            <div class="btnz">
                
                <button class="bttz sltz"><a href="{!! route('pending-appointments') !!}">Verify Slots</a></button>
                <button class="bttz sltz onlbt"><a href="{!! route('onlineAppointments') !!}">Online Slots</a></button>
                <button class="bttz"><a href="{!! route('unchecked-Payments') !!}">Payments</a></button>
                <button class="bttz sltz"><a href="{!! route('ZoomForm') !!}">Zoom Form</a></button>
                <button class="bttz updbt sltz"><a href="{!! route('showZoomTable') !!}">Update Zoom</a></button>
                @if (session()->has('user_id'))
                    <button class="btt lobt"><a href="{!! route('logout') !!}">Log Out</a></button>
                @endif
            </div>
        </div>

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

        <div class="mn">
            @yield('content')
        </div>
    </div>
</body>

</html>
