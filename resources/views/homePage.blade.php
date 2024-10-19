{{-- This is the main landing page which contains the login, doctor, services and other necessary  information about the website. --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Welcome' }}</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="{{ asset('/css/homePage.css') }}">
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
    <div class="mn">
        <nav>
            <div class="nav">
                <div class="logo"><img src="/css/logo.png" alt="logoPic"></div>
                <ul>
                    <li class="hiddenOnMobile"><a href="{!! route('ptreg') !!}" target="_blank">Register</a></li>
                    <li class="hiddenOnMobile"><a href="{!! route('login') !!}" target="_blank">Login</a></li>
                    <li class="hiddenOnMobile"><a href="{!! route('docz') !!}" target="_blank">Doctors</a></li>
                    <li class="hiddenOnMobile"><a href="{!! route('services') !!}">Services</a></li>
                    <li class="hiddenOnMobile"><a href="{!! route('Userguide') !!}">Guidelines</a></li>
                    <li><img id="hambtn" class="hideHambutton" src="/css/icons/hamb.png" alt=""></li>
                </ul>

            </div>
            <div id="sdbr" class="sidebar">
                <ul class="s_ftr_list s_md_list">

                    
                        <li><img id="close" src="/css/icons/close.png" alt=""></li>
                        <li><a href="{!! route('ptreg') !!}" target="_blank">Register</a></li>
                        <li><a href="{!! route('login') !!}" target="_blank">Login</a></li>
                        <li><a href="{!! route('docz') !!}" target="_blank">Doctors</a></li>
                        <li><a href="{!! route('services') !!}">Services</a></li>
                        <li><a href="{!! route('Userguide') !!}">Guidelines</a></li>
                        
                    


                </ul>
            </div>
        </nav>


        <div class="mn_Ad">BOOK AN APPOINTMENT & SEE A DOCTOR!</div>
        <div class="mn_pra">Best health care providers with state of the art facilities, equipped with extremely
            professional individuals</div>

        <footer>
            <div class="ftr">
                <div class="chf ftch1">
                    <ul class="ftr_list">
                        <li><img class="ftr_icnz" src="/css/icons/location.png" alt="">
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iste quasi repudiandae error
                                veniam corporis minus porro possimus, reiciendis dolorem quibusdam.</p>
                        </li>
                        <li><img class="ftr_icnz" src="/css/icons/phone.png" alt="">0333-2258214, 0343-2258214
                        </li>
                        <li><img class="ftr_icnz" src="/css/icons/timings.png" alt=""> 3pm - 11pm 7 days a week
                        </li>

                    </ul>
                </div>
              


                <div class="chf mlchf ftch2">
                    <ul class="ftr_list md_list">
                        <li><img id="fb" class="mlnkz" src="/css/icons/facebook.png" alt=""> </li>
                        <li><img id="x" class="mlnkz" src="/css/icons/x.png" alt=""></li>
                        <li><img id="thrd" class="mlnkz" src="/css/icons/threads.png" alt=""></li>
                        <li><img id="wapp" class="mlnkz" src="/css/icons/whatsapp.png" alt=""></li>
                        <li><img id="tgrm" class="mlnkz" src="/css/icons/telegram.png" alt=""></li>
                        <li><img id="yt" class="mlnkz" src="/css/icons/youtube.png" alt=""></li>


                    </ul>
                </div>
                <div class="chf ">
                    <ul class="ftr_list ">
                        <li><img class="ftr_icnz" src="/css/icons/copyright.png" alt="">
                            <p> The website developed by Abdullah Rashid is fully protected under copyright law, with
                                legal advocacy provided by high court lawyer Mr. X. This copyright ensures that all
                                design, content, and intellectual property on the site remain exclusively owned by Mr.
                                X, preventing unauthorized use or reproduction by others.</p>
                        </li>

                    </ul>
                </div>
            </div>
        </footer>

    </div>

</body>
<script src="scripts/homepage.js"></script>

</html>
