{{-- This form-oriented view is responsible for showing the interface which enables an admin to enter Zoom Credintials to database --}}
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoom Credentials</title>
    <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/doctorAvailabilityStatus.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

</head>

<body>
   
   
        
    @extends('dtDashBrd')
    @section('doctorToPatientContent')
    
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



<div class="mnForm">
    <form action="{!! route('updatemyStatus') !!}" method="post">  
       
        @csrf
        @php
            // dd($user_id);
            // dd($doctor);
        @endphp
        <input type="hidden" name="id" value="{{$user_id}}">
        <div class="ch">
            <label for="uname">Name</label>
            <input type="text" name="uname" id="uname" value= "{{$doctor->uname}}" readonly>
           
        </div>
        <div class="ch">

            <div class="chl"><label for="status">Availability Status</label></div>
            <div class="chi"><select type="select" value= "{{$doctor->status}}" name="status" id="status" required>

                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
            </select>
                <span> @error('status')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        
        <div class="ch chbt">
            <button type="submit">Submit</button>
        </div>
    </form>
    
    </div>
    @endsection
</body>
</html>
