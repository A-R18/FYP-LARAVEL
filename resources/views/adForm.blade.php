{{-- This is the view file which enables an authorized person to register an admin  --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="{{ asset('/css/adform.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/universal.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="prt"></div>
    <div class="mn">
        <form action="{{ route('adReg') }}" method="post">
            @csrf


            <input type="hidden" name="role" value="admin">
            <div class="ch">
                <div class="chl"><label for="uname">Name</label></div>
                <div class="chi"><input type="text" name="uname" id="uname" placeholder="Staff Name" required>
                    <span> @error('uname')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>


            <div class="ch">
                <div class="chl"><label for="udob">DOB</label></div>
                <div class="chi"><input type="date" name="udob" id="udob" required>
                    <span> @error('udob')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>


            <div class="ch">

                <div class="chl"><label for="ucontact">Ph no.</label></div>
                <div class="chi"><input type="number" id="ucontact" name="ucontact" placeholder="03xxxxxxxx" required>
                    <span> @error('ucontact')
                        {{ $message }}
                        @enderror
                    </span>
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
                <div class="chi"><input type="email" id="uemail" name="uemail" placeholder="Email" required>
                    <span> @error('uemail')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>


            <div class="ch">

                <div class="chl"><label for="upass">Password</label></div>
                <div class="chi"><input type="password" id="upass" name="upass" placeholder="Passowrd" required>
                    <span> @error('upass')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>



            <div class="ch">
                <div class="chl"><label for="stdesg">Desg.</label></div>
                <div class="chi"><input type="text" name="stdesg" id="stdesg" placeholder="Designation" required>
                    <span> @error('stdesg')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>

            <div></div>
            <div></div>
            <div class="ch">

                <button>Register</button>
            </div>






        </form>
    </div>

</body>

</html>