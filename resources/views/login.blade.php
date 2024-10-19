{{-- This view file enables a user to login and reset the forgot password. --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Login Please' }}</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    {{-- <script>
        var userRole = @json($userRole);
            if (userRole === 'doctor' || userRole === 'admin') {
                document.getElementById('reg').style.display = 'none';
            }
    </script> --}}
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

        <form action="{{ url('/') }}/login" method="post">
            @csrf
            <div class="ch">

                <label for="uemail">Email</label>

                <input type="email" name="uemail" id="uemail" placeholder="Your Email" required>

                <span> @error('uemail')
                    {{ $message }}
                    @enderror

            </div>
            <div class="ch">


                <label for="upassword">Password</label>

                <input type="password" name="upassword" id="upassword" placeholder="●●●●●●●●●"  required>

                <span> @error('upassword')
                    {{ $message }}
                    @enderror

            </div>
            <div class="ch"><button>Login</button></div>
            <div class="lnk">

                <span>

                    <a href=" {!! route('frgtPswd') !!}" target="_blank">Forgot Password</a>
                </span>

                <span id="rg">

                    <a href="{!! route('ptreg') !!}" target="_blank">New? Register</a>
                </span>
            </div>
        </form>
    </div>




</body>

</html>