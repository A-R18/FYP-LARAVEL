{{-- This view file is responsible for providing a form for patient registration --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Patient Registration' }}</title>
    <link rel="stylesheet" href="{{ asset('/css/PatientReg.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="prt"></div>
    <div class="mn">
        <div class="msg">
            @if (session('success'))
                {{ session('success') }}
            @endif
        </div>
        <form action="{{ route('ptrg') }}" method="post">
            @csrf
            <input type="hidden" name="role" value="patient">

            <div class="ch">
                <div class="chl"><label for="uname">Name</label></div>
                <div class="chi">
                    <input type="text" value="{{ old('uname') }}" name="uname" id="uname" placeholder="Patient Name" required>
                    <div>
                        <span> @error('uname') {{ $message }} @enderror </span>
                    </div>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="udob">DOB</label></div>
                <div class="chi">
                    <input type="date" value="{{ old('udob') }}" name="udob" id="udob">
                    <div>
                        <span> @error('udob') {{ $message }} @enderror </span>
                    </div>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="ucontact">Ph no.</label></div>
                <div class="chi">
                    <input type="number" id="ucontact" value="{{ old('ucontact') }}" name="ucontact" placeholder="03xxxxxxxx" required>
                    <div>
                        <span> @error('ucontact') {{ $message }} @enderror </span>
                    </div>
                </div>
            </div>

            <div class="ch rdch">
                <label for="ugender">Gender</label>
                <div class="chrd">
                    <div class="rdbt">
                        <label for="male">Male</label>
                        <input type="radio" name="ugender" id="male" class="rbt" value="male" required>
                    </div>
                    <div class="rdbt">
                        <label for="female">Female</label>
                        <input type="radio" name="ugender" id="female" class="rbt" value="female" required>
                    </div>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="uemail">Email</label></div>
                <div class="chi eml">
                    <input type="email" value="{{ old('uemail') }}" id="uemail" name="uemail" placeholder="Email" required>
                    <div>
                        <span> @error('uemail') {{ $message }} @enderror </span>
                    </div>
                </div>
            </div>
            

            <div class="ch">
                <div class="chl"><label for="upass">Password</label></div>
                <div class="chi">
                    <input type="password" id="upass" name="upass" placeholder="Password" required>
                    <div>
                        <span> @error('upass') {{ $message }} @enderror </span>
                    </div>
                </div>
            </div>

            <div class="ch addr">
                <div class="chl addr"><label for="ptaddr">Address</label></div>
                <div class="chi tar">
                    <textarea name="ptaddr" id="ptaddr" cols="30" rows="5" placeholder="Address">{{ old('ptaddr') }}</textarea>
                    <div>
                        <span> @error('ptaddr') {{ $message }} @enderror </span>
                    </div>
                </div>
            </div>

            <div class="chb">
                <button>Register</button>
            </div>
        </form>
    </div>
</body>

</html>
