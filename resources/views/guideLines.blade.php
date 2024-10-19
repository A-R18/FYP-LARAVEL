{{-- A static view which explains the services provided by this platform --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'User Guide' }}</title>
    <link rel="stylesheet" href="login.css">
    {{-- <link rel="stylesheet" href="{{ asset('/css/homePage.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('/css/guideLines.css') }}">
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


        <div class="mn_Ad">USER GUIDELINES</div>
        <div class="md">
            <div class="mdch mdtxt">
                <div class="hdng">BOOKING AN APPOINTMENT</div>

                <div class="pra">
                    <li>It's necessary for a user to register with this system in order to access the features offered
                        by this system i.e. appointment booking, online appointment booking, doctor's prescription
                        viewing, doctor's prescription writing.</li>
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/register.png" alt="Registration"></div>


                <div class="pra">
                    <li>If a user is already registered he can log in by entering his correct credentials and then proceed towards further preceeings which involve any related operation to scheduling or prescription.</li>
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/login.png" alt="Login"></div>


                <div class="pra">
                    <li>After landing inside your account's dashboard, if you want to book an appointment you can simply click on the doctors option, where you'll find the list of the relevant doctors.</li>
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/doctorOptionClick.png" alt="Doctors option"></div>


                <div class="pra">
                    <li>As anlayzing the doctors it's time to book an appointment with the right doctor, for this purpose you can click on the button "Take Appointment" to choose relevant doctor.</li>
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/chooseDoctor.png" alt="choose Doctor"></div>


                <div class="pra">
                    <li>Now you have the appointment booking interface opened, here you can click on the date which you want to see a doctor on.</li>
                   
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/chooseSlot.png" alt="Choose Date"></div>


                <div class="pra">
                    <li>Upon clicking Reserve Slot you'll successfully reserve a slot on your name which will also show a success message about your successful slot reservation.</li>
                    
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/appointmentSuccess.png" alt="Appointment Success"></div>

 
                <div class="pra">
                    
                    <li>After successfull reservation you can have a look on your reserved slot, if you're not satisfied with your time slot you can simply delete this slot by clicking on delete button. That slot will become avaiable in system again. You can book another slot which suits you the best.Until your payment verification the status of your apponitment slot remains pending, when it's verified your payment's status become checked.</li>
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/payFeeForSlot.png" alt="Reserved Slot"></div>


                <div class="pra">
                    
                    <li>If things are good at your end you can proceed to the procedure of payment.</li>
                    <li>For process of payment you'll have to transfer respective amount (doctor's charges) on <span>  Account no.  #############</span>      <span> Account Title.  Mr.ABCDEFGHIJK</span> by your mobile device or any physical mean.</li>
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/payFeeForSlot.png" alt="Payment Details"></div>


                <div class="pra">
                    
                    <li>Now Enter the details i.e account no, your account's name which you've used to pay the relevant amount for appointment.</li>
                   
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/submitPaymentDetails.png" alt="Payment Details"></div>

            </div>


            <div class="mdch mdtxt">
                <div class="mn_Ad">APPOINTMENT HISTORY & PAYMENT</div>

                <div class="pra">
                    
                    <li>Now Enter the details i.e account no, your account's name which you've used to pay the relevant amount for appointment.</li>
                   
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/submitPaymentDetails.png" alt="Payment Details"></div>



                <div class="pra">
                    
                    <li>After submission of your payment details, if your payment status is appearing unchecked for more than 40 minutes, it means that your appointment hasn't been verified yet by the admin or transaction hasn't happened.</li>
                   
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/payment.png" alt="Payment Details"></div>


                <div class="pra">
                    
                    <li>Otherwise, if your payment status is appearing checked, it means that your appointment has been verified by the admin after a successful payment transaction.</li>
                   
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/paymentUnchecked.png" alt="Payment Details"></div>


                <div class="pra">
                    
                    <li>Upon successful visit, you can preview your relevant prescription which is written by your doctor, actually there appears complete history of your visits, you can choose whichever you want to see based on dates and appointment time.</li>
                   
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/prescriptionClick.png" alt="Prescription menu"></div>


                <div class="pra">
                    
                    <li>After clicking on prescription button, you can now view what your physician has prescribed to you, along with the diagnosis, laboratory routines, medications etc.</li>
                   
                </div>
                <div class="guide-img" ><img  src="/css/guideImages/prescription.png" alt="Prescription"></div>


            </div>
          


        </div>



    </div>

</body>

</html>
