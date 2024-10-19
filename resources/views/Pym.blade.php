{{--This is a form oriented view which enables a patient to send credentials of a payment done through any payment platform   --}}
@extends('ptDashBrd')


<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Payment Verification' }}</title>
    <link rel="stylesheet" href="{{ asset('/css/Pym.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700&display=swap"
        rel="stylesheet">
</head>
@section('content')
<body>
   


    <div class="pymmn">
        <h2>PLEASE FILL THE FORM WITH YOUR PAYMENT DETAILS FOR YOUR APPOINTMENT VERIFICATION</h2>
        <h2 style="color: rgb(255, 84, 16)">Note! Please pay within 30 minutes of your slot reservation in order to ensure appointment verification</h2>
       

        <form class="pymfrm" action="{{ route('PyFrm') }}" method="post">
            @csrf

            @php
                // dd($patient);
            @endphp
            <input type="hidden" name="role" value="patient">
            <input type="hidden" name="pym_status" value="unchecked">

            <div class="ch">
                <div class="chl"><label for="uname">Name</label></div>
                <div class="chi">
                    <input type="text"  name="uname" id="uname" placeholder="Account Name/Title of payer" required>
                    <span>
                        @error('uname')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="sid">Slot ID</label></div>
                <div class="chi">
                    <input type="text" value="{{ $patient->ap_id }}" id="sid" name="sid" placeholder="Slot ID" readonly>
                    <span>
                        @error('sid')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="accNo">Account no.</label></div>
                <div class="chi">
                    <input type="text" value="{{ old('accNo') }}" id="accNo" name="accNo" placeholder="Account No. (IBAN/BAN)" required>
                    <span>
                        @error('accNo')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="amount">Amount</label></div>
                <div class="chi">
                    <input type="number" id="amount" name="amount" value="{{ $patient->dt_fee  }}" readonly>    
                    <span>
                        @error('amount')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>

            <div class="ch btn">
                <button type="submit" class="pymsbmt">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
@endsection
