<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Payment;
use App\Http\Controllers\adminAction;
use App\Http\Controllers\adminReg;
use App\Http\Controllers\docReg;
use App\Http\Controllers\doctors;
use App\Http\Controllers\drPrescription;
use App\Http\Controllers\Login;
use App\Http\Controllers\Registration;
use App\Http\Controllers\DataManager;
use App\Http\Controllers\ForgotPassword;
use App\Http\Controllers\patientView;
use App\Http\Controllers\payFrm;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Models\Usrdata;
use App\Models\Pymnt;
use App\Http\Controllers\AppointmentController;




// to test the model this has been written 

Route::get('/', function () {

    return view('homePage');
})->name('log');

Route::get('/zoom-form', function () {

    return view('zoomCredentials');
})->name('ZoomForm');


Route::get('/services', function () {

    return view('services');
})->name('services');


Route::get('/guideLines-for-users', function () {

    return view('guideLines');
})->name('Userguide');


Route::get('/appointment-mail', function () {

    return view('onlineAppointmentMail');
})->name('showMailView');







Route::get('docz/', [DataManager::class, 'drzDataDsp'])->name('docz');



// Route to view appointments
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');

// Route to creating  an appointment
Route::get('/appointments/create/{doctor_id}', [AppointmentController::class, 'create'])->name('appointments.create');


Route::get('/mydashboard/{uname}/{udob}/{age}', [AppointmentController::class, 'afterAppointment'])->name('ptDash');



//route for storing the appointment
Route::post('/appointments/store/{doctor_id}', [AppointmentController::class, 'storeAppointment'])->name('appointments.store');




// Route to view doctors as a visitor
Route::get('/dtrs', [DataManager::class, 'drzData'])->name('dtrz');

// Route to view doctor details and assign patient
Route::get('/dtrsz/{doctor_id}/{patient_id}', [DataManager::class, 'drzData'])->name('docdtasnd');

//Route for button inside ptDashBrd  (My Bookings) which shows pending appointments

Route::get('/my-bookings', [AppointmentController::class, 'fetchPtApp'])->name('myBookings');

//Route for button inside ptDashBrd  (My Visits) which shows attended appointments along with prescription viewing option

Route::get('/my-visits-to-doctor', [AppointmentController::class, 'fetchBookedAppointments'])->name('my-visits');

//Route for Admin to view all appointments which are needed to be verified after a due process.
Route::get('/pending-patients', [AppointmentController::class, 'fetchPendingAppointments'])->name('pending-appointments');

//Route for Admin for viewing the online appointments
Route::get('/online-verified-appointments', [AppointmentController::class, 'fetchVerifiedOnlineAppointments'])->name('onlineAppointments');

  

Route::get('/verifyable-slots', [AppointmentController::class, 'fetchPendingAppointments'])->name('paidSlots');




Route::get('/unchecked-payments', [Payment::class, 'uncheckedPayments'])->name('unchecked-Payments');


// Route for admin to check the payments

Route::get('/check-payment/{id}', [Payment::class, 'checkPayment'])->name('checkPayment');

//Route for admin to verify appointments
Route::get('/appointments/verify/{id}', [AppointmentController::class, 'verifyAppointment'])->name('appointments.verify');

// Route for patients to view their payments
Route::get('/my-payments', [Payment::class, 'myPaymentz'])->name('my-Payments');



//Route for doctor to reach check the appointments history between him and respective patient
// In routes/web.php This route is required to be checked whether it is working or not in terms of utilization
Route::get('/doctor/{appointmentId}/appointments', [AppointmentController::class, 'bwPatientDoc'])->name('doctor.appointments');



Route::get('/login', [Registration::class, 'showlogin'])->name('login');
Route::post('/login', [Registration::class, 'loginUser']);


Route::get('/pReg', [Registration::class,  'ptshow'])->name('ptreg');
Route::post('/pReg', [Registration::class, 'Store'])->name('ptrg');




Route::get('/stfReg', [Registration::class, 'adshow']);
Route::post('/stfReg', [Registration::class, 'Store'])->name('adReg');



Route::get('/docReg', [Registration::class, 'docFrmshow']);
Route::post('/docReg', [Registration::class, 'Store'])->name('dReg');


Route::get('/pym/{appointmentID}', [Payment::class, 'pyshow'])->name('payment');


Route::post('/pym-save', [Payment::class, 'paydta'])->name('PyFrm');

Route::get('/logout', [Registration::class, 'logOut'])->name('logout');


Route::get('/forgetPass', [ForgotPassword::class, 'showForget'])->name('frgtPswd');
Route::post('/forgetPass', [ForgotPassword::class, 'Forgetpassword'])->name('frgtPswdsend');


Route::get('/frgtPassMail/{token}', [ForgotPassword::class, 'resetPassword'])->name('resetPswd');
Route::post('/resetPass', [ForgotPassword::class, 'resetPasswordpost'])->name('resetPswdpost');

Route::get('/dAppmnt', [AppointmentController::class, 'showAppointment'])->name('dAppt');

// Route::get('/dctrz',[DataManager::class, 'doczshow'])->name('doctors');


//Button click route for doctor to view patients who have booked the appointment with them today

Route::get('/doctor-appointments', [AppointmentController::class, 'fetchDoctorAppointments'])->name('doctorAppointments');


//Route for doctor for clicking button to change status of appointment record from booked to attended

Route::get('/appointment/attended/{appointmentId}', [AppointmentController::class, 'markAsAttended'])->name('appointment.attended');

//Route for deleting the appointment with pending status of patients by themselves

Route::get('/delete my-appointment/{appointmentID}', [AppointmentController::class, 'patientDeletesAppointment'])->name('deleteByPatient');

//Route of deleting the appointment with pending status of patients by admin if he finds something wrong.
Route::get('/delete patient-appointment/{appointmentId}', [AppointmentController::class, 'adminDeletesAppointment'])->name('deleteByAdmin');



//Route for doctor to submit a prescription written for a patient:

Route::post('/store-prescription', [PrescriptionController::class, 'storePrescription'])->name('prescription.store');


//Route to show prescription to patient
Route::get('/my-prescription/{appointment_id}', [PrescriptionController::class, 'showPrescriptionToPatient'])->name('showPrescriptionToPatient');

//Route to show prescription to doctor
Route::get('/pt-prescription/{appointment_id}', [PrescriptionController::class, 'showPrescriptionToDoctor'])->name('showPrescriptionToDoctor');


// Route for fetching the patient's appointment history by the doctor
Route::get('/doctor/patient-history/{patientId}', [AppointmentController::class, 'fetchPatientHistory'])->name('doctor.patientHistory');

//Insert data into zoom credentials table through form using post
Route::post('/store-zoom-credentials', [ZoomOperation::class, 'insertZoomCredentials'])->name('zoomCredentialsPost');

// Route to show the existing zoom table record to admin 
Route::get('/show-zoom-table', [ZoomOperation::class, 'showZoomCredentials'])->name('showZoomTable');



// Route for deleting zoom record by admin
Route::get('/delete-zoom-credentials/{zoomRecordID}', [ZoomOperation::class, 'deleteZoomCredentials'])->name('deleteZoomRecord');

// Route for accessing update form of zoom record by admin
Route::get('/open-existing-zoom-credentials/{zoomRecordID}', [ZoomOperation::class, 'showUpdateZoomForm'])->name('showUpdateZoomForm');

//Route for sending updated data to Database 
Route::post('/update-zoom-record', [ZoomOperation::class, 'updateZoomCredentials'])->name('UpdateZoomData');


//Route for checking fetched data
Route::get('/mail-with-userdata/{appointmentID}', [ZoomOperation::class, 'putZoomCredentialsInMail'])
->name('putZoomCredentialsInMail');  

//Route for changing status of appointment's mail
Route::get('/mark-as-mail-sent/{appointmentID}', [ZoomOperation::class, 'tickMailStatus'])
->name('markAsAppointmentSent');  


//Route for doctor to fetch his existing availabilty status in a form:
    Route::get('/show-my-existing-status/{doctorID}', [Registration::class, 'showDoctorUpdateForm'])->name('changeDoctorStatus');

//Route for doctor to update his availabilty status:
    Route::post('/update-my-status', [Registration::class, 'updateDoctorStatus'])->name('updatemyStatus');






Route::get('/stf', function () {
    return view('adForm');
});


Route::get('/admAct', function () {
    return view('adminAction');
})->name('adminact');


Route::get('/ptDash', function () {
    return view('ptDashBrd');
})->name('ptdshb');


