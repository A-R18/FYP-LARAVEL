

{{-- This form-oriented view is responsible for showing the interface which enables a user to enter existing email and new password  --}}
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Reset Password' }}</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="{{ asset('/css/resetPass.css') }}">
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

        <form action="{!!route('resetPswdpost')!!}" method="post">
            @csrf

                <input type="hidden" name="token" value="{{$token}}">
                <div class="ch">

                <label for="uemail">Email</label>

                <input type="email" name="uemail" id="uemail" placeholder="Enter Email" required>

                <span> @error('uemail')
                    {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="ch eml">

                <label for="upass">New Password</label>

                <input type="password" name="upass" id="upass" placeholder="Enter new password for your account" required>
                
                <span> @error('uemail')
                    {{ $message }}
                    @enderror

            </div>

            <div class="ch"><button>Reset</button></div>

        </form>
    </div>




</body>

</html>