{{-- This view is doctor's dashboard from where a doctor can view appointment history of a patient or write prescription for a respective patient. Moreover, a doctor can mark a patient as attended by clicking on the button tick --}}

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Today's Patients</title>
   <link rel="stylesheet" href="{{ asset('/css/dtDashBrd.css') }}">
   <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link
       href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
       rel="stylesheet">
</head>

<body>
   <div class="prt"></div>
   <div class="box">
      <div class="ttb">
         <div class="drcred">
            <span class=" drdp"> <img src="{{ asset('uploads/' . $docInfo->dtimg) }}" alt="Doctor Image"></span>
            <div class="nmspz">
            <div class="nam drnm">{{ $userInfo->uname }}</div>
            <div class="nam drspecz">{{ $docInfo->dtspez }}</div>
            </div>
         </div>

     

         <div class="btnz">
            <button class="pbt1"><a href="{{ route('doctorAppointments') }}" class="btn">Patients</a>
            </button>
            <button class="pbt1"><a href="{{ route('changeDoctorStatus', $user_id )}}" class="btn">My Status</a>
            </button>
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

    @yield('doctorToPatientContent')
    
      </div>
   </div>
</body>

</html>
