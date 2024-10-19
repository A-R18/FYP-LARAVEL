<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;


namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Usrdata;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use DateTime;



class PrescriptionController extends Controller
{
    // function for doctor's prescription writing (storing the prescription):


        public function storePrescription(Request $request)
        {
            // Retrieve doctor_id from session
            $doctor_id = session()->get('user_id'); // Adjust as necessary
         
            // Validate the input data
            $validated = $request->validate([
                'pr_desc' => 'required|string',
                'patient_id' => 'required|exists:patients,users_id', // Validing the patient id against patients table
                'appointment_id' => 'required|exists:appointments,ap_id', // Validating the appointment id against appointments table.
            ]);

          
        
            // Ensure doctor_id from session exists in doctors table
            $doctorExists = DB::table('doctors')->where('users_id', $doctor_id)->exists();
            // dd($doctorExists);

        
            if (!$doctorExists) {
                return redirect()->back()->with('error', 'Invalid doctor ID.');
            }

              // Checking if a prescription already exists for this doctor, patient, and appointment
    $prescriptionExists = DB::table('prescriptions')
    ->where('doctor_id', $doctor_id)
    ->where('patient_id', $validated['patient_id'])
    ->where('appointment_id', $validated['appointment_id'])
    ->exists();

if ($prescriptionExists) {
    return redirect()->back()->with( 'error','A prescription has already been written for this appointment.');
}
        
            // Insert the prescription into the database
              DB::table('prescriptions')->insert([
                'pr_desc' => $validated['pr_desc'],
                'doctor_id' => $doctor_id, // From session
                'patient_id' => $validated['patient_id'], // From view
                'appointment_id' => $validated['appointment_id'], // From view
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // dd($a);
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Prescription added successfully');
        }
        
        



        //function for patient's prescription viewing:



public function showPrescriptionToPatient($appointment_id)

{
    $user_id = session()->get('user_id'); // Ensure this is set correctly during login

    if (!$user_id) {
        // Handle the case where the user ID is not available in the session
        return redirect()->route('login')->with('error', 'You need to be logged in to view your appointments.');
    }

    // Fetch the patient ID using the session user_id
    $patient = DB::table('patients')->where('users_id', $user_id)->first();
    if (!$patient) {
        // Handle the case where the patient record is not found
        return redirect()->route('login')->with('error', 'Patient record not found');
    }
    // Fetch the prescription for the given appointment ID
    $prescription = DB::table('prescriptions')
    ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.ap_id')
    ->join('patients', 'appointments.patient_id', '=', 'patients.id')
    ->join('users as patients_users', 'patients.users_id', '=', 'patients_users.user_id')
    ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
    ->join('users as doctors_users', 'doctors.users_id', '=', 'doctors_users.user_id')
    ->where('prescriptions.appointment_id', $appointment_id)
    ->select(
        'appointments.ap_id',
        'patients_users.uname as patient_name',
        'doctors_users.uname as doctor_name',
        'appointments.ap_date',
        'appointments.ap_strTime',
        'prescriptions.pr_desc'
    )
    ->first();


    if (!$prescription) {
        // Handle the case where no prescription is found
        return redirect()->back()->with('error', 'Prescription not found');
    }



    $userInfo = DB::table('users')
    ->where('user_id', $user_id)
    ->select('uname', 'udob')
    ->first();
    // dd($userInfo);

// Calculate age
$dob = new DateTime($userInfo->udob);
$today = new DateTime();
$ageInterval = $today->diff($dob);
$age = $ageInterval->y . ' years, ' . $ageInterval->m . ' months, ' . $ageInterval->d . ' days';

    // Load the prescription view and inject it into the patient dashboard
    return view('patientPrescription', compact('prescription', 'userInfo','age'));
}






 //function for doctor's prescription viewing:


public function showPrescriptionToDoctor($appointment_id)

{
    $user_id = session()->get('user_id'); // Ensure this is set correctly during login

    if (!$user_id) {
        // Handle the case where the user ID is not available in the session
        return redirect()->route('login')->with('error', 'You need to be logged in to view your appointments.');
    }

    // Fetch the patient ID using the session user_id
 
    // Fetch the prescription for the given appointment ID
    $prescription = DB::table('prescriptions')
    ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.ap_id')
    ->join('patients', 'appointments.patient_id', '=', 'patients.id')
    ->join('users as patients_users', 'patients.users_id', '=', 'patients_users.user_id')
    ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
    ->join('users as doctors_users', 'doctors.users_id', '=', 'doctors_users.user_id')
    ->where('prescriptions.appointment_id', $appointment_id)
    ->select(
        'appointments.ap_id',
        'patients_users.uname as patient_name',
        'doctors_users.uname as doctor_name',
        'appointments.ap_date',
        'appointments.ap_strTime',
        'prescriptions.pr_desc'
    )
    ->first();


    if (!$prescription) {
        // Handle the case where no prescription is found
        return redirect()->back()->with('error', 'Prescription not found');
    }



   
    $userInfo = DB::table('users')
    ->where('user_id', $user_id)
    ->select('uname', 'udob')
    ->first();

$docInfo = DB::table('doctors')
    ->where('users_id', $user_id)
    ->select('dtimg', 'dtspez')
    ->first();



    // Load the prescription view and inject it into the doctor dashboard
    return view('doctorPrescription', compact('prescription', 'userInfo','docInfo', 'user_id'));
}


}
