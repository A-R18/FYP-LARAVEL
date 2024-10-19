
{{-- This view is responsible for fetching a form in which the patient is supposed to enter his email for password recovery. --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Enter Email' }}</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="{{ asset('/css/forgetPass.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">


</head>

<body>
    <div class="prt">
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
    <p class = "hdng">Enter the Email (of your account) for resetting the password</p>
        <form action="{!!route('frgtPswdsend')!!}" method="post">
            @csrf
            <div class="ch">

                <label for="uemail">Enter your Email (Registered)</label>

                <input type="email" name="uemail" id="uemail" placeholder="Email for resetting password" required>
                
                <span> @error('uemail')
                    {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="ch"><button>Reset</button></div>

        </form>
    </div>




</body>

</html>