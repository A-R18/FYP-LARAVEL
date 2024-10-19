
{{-- This is the view file for patient to book appointments, fill payment forms, view their prescriptions --}}

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Appointments</title>
   <link rel="stylesheet" href="{{ asset('/css/ptDashBrd.css') }}">
   <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>

<body>
   <div class="prt"></div>
   <div class="box">
      <div class="ttb">
         <div class="crdntlz">
         <div class="nam">Welcome {{ $userInfo->uname }}</div>
         <div class="nam">Age: {{ $age }}</div>
      </div>
         <div class="btnz">
            <button class="btt pbt2 rsltz"><a href="{{ route('myBookings') }}">Reserved Slots</a></button>
            <button class="btt pbt1"><a href="{{ route('my-visits') }}">My Visits</a></button>
            <button class="btt pbt2"><a href="{{ route('my-Payments') }}">Payments</a></button>
            <button class="btt pbt2"><a href="{!! route('dtrz') !!}">Doctors</a></button>
            @if (session()->has('user_id'))
                <button class="btt lobt"><a href="{!! route('logout') !!}">Log Out</a></button>
            @endif
         </div>
      </div>
      <div class="npr">
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
   </div>
      <div class="mn">
         
       
         @yield('content') <!-- Content from different Views will be injected here -->
      </div>
   </div>
</body>

</html>
