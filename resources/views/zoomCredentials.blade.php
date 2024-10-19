{{-- This form-oriented view is responsible for showing the interface which enables an admin to enter Zoom Credintials to database --}}
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoom Credentials</title>
    <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/zoomCredentials.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

</head>

<body>
   
        
    @extends('adminAction')
    @section('content')
    
<div class="mnForm">
    <form action="{!! route('zoomCredentialsPost') !!}" method="post">  
        @csrf
        
        <div class="ch">
            <label for="meetingID">Meeting ID</label>
            <input type="text" name="meetingID" id="meetingID" placeholder="Zoom ID"  required>
            <span class="error">@error('meetingID') {{ $message }} @enderror</span>
        </div>
        
        <div class="ch eml">
            <label for="meetingPasscode">Meeting Passcode</label>
            <input type="text" name="meetingPasscode" id="meetingPasscode" placeholder="Zoom Passcode" 
             required>
            <span class="error">@error('meetingPasscode') {{ $message }} @enderror</span>
        </div>
        
        <div class="ch chbt">
            <button type="submit">Submit</button>
        </div>
    </form>
    
    </div>
    @endsection
</body>
</html>
