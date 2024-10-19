<!DOCTYPE html>
<html lang="en">
@php
    // dd($patient);
    // dd($zoomCred);
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p
        style="
    font-family: 'ubuntu';

    margin:20px auto;
    text-align: justify;
    font-size: 15px;
    height: auto;
    width: 330px;
    display: flex;
    align-items: center; 
    justify-content: center;">
        <strong>AOA, {{ $patient->uname }}, your online appointment will start on {{ \Carbon\Carbon::parse($patient->ap_strTime)->format('h:i A') }}, here are
            the credientials you can use in zoom link to join the meeting.</strong> </p>
    <p
        style="
    font-family: 'ubuntu';

    margin:20px auto;
    text-align: justify;
    font-size: 15px;
    height: auto;
    width: 330px;
    display: flex;
    align-items: center; 
    justify-content: center; color: red;">
        <strong> Note! You'll be only allowed to join the meeting at sharp {{ \Carbon\Carbon::parse($patient->ap_strTime)->format('h:i A') }}.

           
        </strong> </p>
    <div class="box"
        style="
    font-family: 'ubuntu';
    margin:auto;
    height: 250px;
    width: 330px;
    display: flex;
    align-items: center; 
    justify-content: center;
    background-color: rgba(142, 255, 255, 0.411);
    border-radius:10px;
    border:solid blue 4px;">

        <div class="cred">
            <div style="margin-bottom: 20px;
            font-weight: bolder;
            font-size:18px"
                class="meetingID">Meeting ID: {{$zoomCred->meetingID}}</div>
            <div style="margin-bottom: 20px; 
            font-weight: bolder;
            font-size:18px"
                class="meetingPasscode">Passcode: {{$zoomCred->meetingPasscode}}</div>
            <div style="height: 30px;
            width: 115px; display: flex;
            justify-content: center;
            align-items: center;
            background-color: blue;
            border-radius: 20px; "
                class="meetingLink"><a target="blank"
                    style="text-decoration: none;
            font-weight: bolder; 
            font-size: 18px; margin: auto;
            color: rgb(255, 255, 255);
            font-family: sans-serif;"
                    href="https://app.zoom.us/wc/join">Zoom Link</a></div>
        </div>
    </div>
</body>

</html>
