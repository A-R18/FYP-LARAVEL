
{{-- This is the view file which enables an admin or ceo to register a doctor --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration</title>
    <link rel="stylesheet" href="{{ asset('/css/dtForm.css') }}">
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
        <form action="{{ route('dReg') }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="role" value="doctor">

            <div class="ch">
                <div class="chl"><label for="uname">Name</label></div>
                <div class="chi"><input type="text" value="{{ old('uname') }}" name="uname" id="uname"
                        placeholder="Doctor Name" required>
                    <span> @error('uname')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>


            <div class="ch">
                <div class="chl"><label for="udob">DOB</label></div>
                <div class="chi"><input type="date" value="{{ old('udob') }}" name="udob" id="udob" required>
                    <span> @error('udob')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>


            <div class="ch">

                <div class="chl"><label for="ucontact">Ph no.</label></div>
                <div class="chi"><input type="number" id="ucontact" value="{{ old('ucontact') }}" name="ucontact"
                        placeholder="03xxxxxxxx" required>

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
                <div class="chi"><input type="email" id="uemail" name="uemail" value="{{ old('uemail') }}"
                        placeholder="Email" required>

                    <span> @error('uemail')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>


            <div class="ch">

                <div class="chl"><label for="upass">Password</label></div>
                <div class="chi"><input type="password" id="upass" name="upass" value="{{ old('upass') }}"
                        placeholder="Passowrd" required>

                    <span> @error('upass')
                            {{ $message }}
                        @enderror
                    </span>

                </div>
            </div>



            <div class="ch">
                <div class="chl"><label for="dtspez">Specz.</label></div>
                <div class="chi"><input type="text" name="dtspez" id="dtspez" value="{{ old('dtspez') }}" placeholder="Specialization"
                        required>
                    <span> @error('dtspez')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="dtimg">Photo</label></div>
                <div class="chi"><input type="file" name="dtimg" id="dtimg" required>

                    <span> @error('dtimg')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="ch">
                <div class="chl"><label for="status">Status</label></div>
                <div class="chi"><select type="select" name="status" id="status" required>

                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
                    <span> @error('dtimg')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>



            <div class="ch">
                <div class="chl"><label for="strtime">Start time</label></div>
                <div class="chi"><input type="time" value="{{ old('strtime') }}" name="strtime"
                        id="strtime" required>
                    <span> @error('strtime')
                            {{ $message }}
                        @enderror
                    </span>
                </div >
            </div>

            <div class="ch">
                <div class="chl"><label for="endtime">End time</label></div>
                <div class="chi"><input type="time" value="{{ old('endtime') }}" name="endtime"
                        id="endtime" required>
                    <span> @error('endtime')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>

            <div class="ch">
                <div class="chl"><label for="dt_fee">Fee Amount</label></div>
                <div class="chi"><input type="number" value="{{ old('dt_fee') }}" name="dt_fee"
                        id="dt_fee" required>
                    <span> @error('dt_fee')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>

        <div ></div>
        <div ></div>




          


            <div class="ch btch ">

                <button>Register</button>
            </div>

        </form>
    </div>

</body>

</html>
