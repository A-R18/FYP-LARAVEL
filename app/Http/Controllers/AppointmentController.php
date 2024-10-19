<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


namespace App\Http\Controllers;

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
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;


class AppointmentController extends Controller
{
    public function index()
    {

        return view('appointment');
    }

/* This function is written for displaying appointment details, where it is necessary to keep the current doctor and patient in view file. The patient ID is retrieved from session data, and the doctor ID is passed to the function, which is obtained from the doctor's card. The function fetches appointments booked for the doctor with future dates from the database. If there are any appointments, they are assigned to the bookedSlots variable, which contains keys as dates and their corresponding values as the start times of the booked appointments. */

    public function create($doctor_id)
    {
        // Fetch doctor details
        $doctor = Doctor::findOrFail($doctor_id);
        //    dd($doctor_id); 
        // Fetch doctor status
        $doctorStatus = $doctor->status; // Adjust accordingly based on your Doctor model and attribute


        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->where('ap_date', '>=', now()->format('Y-m-d')) // Ensure future dates only
            ->get();

        // Appointments are fetched to Prepare booked slots for respective doctor & assign those slots to booked slots

        $bookedSlots = $appointments->groupBy('ap_date')->map(function ($dateSlots) {
            return $dateSlots->pluck('ap_strTime');
            //pluck function can attain maximum two attributes
        });
       

        $patient = session()->get('user_id');
        // dd($patient);
        // Assuming $patientId is an integer and you want to find a patient with that user_id

        //  dd($patientId);                     


        // Doctor's name retrieval
        $doctorName = DB::table('doctors')
            ->join('users', 'doctors.users_id', '=', 'users.user_id')
            ->where('doctors.id', $doctor_id)
            ->value('users.uname');


        // dd($bookedSlots);    

        // Passing data to view for using these variables & data stored in them
        return view('appointment', compact('doctor', 'bookedSlots', 'doctorStatus', 'doctorName', 'patient'));
    }


    

    public function storeAppointment(Request $request, $doctor_id)
    {
        // Retrieve patient ID from session
        $user_id = session()->get('user_id');

        // Fetch the patient record using the session user_id
        $patient = DB::table('patients')->where('users_id', $user_id)->first();
        if (!$patient) {
            return redirect()->route('login')->with('error', 'Patient record not found');
        }

        $patient_id = $patient->id; // Use patient ID from the patients table

        // Validate appointment data
        $validatedData = $request->validate([
            'apdate' => 'required|date',
            'timing' => 'required',
            'aptime' => 'required|in:Physical,Online',
        ]);

        // Fetch booked slots for the doctor
        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->where('ap_date', '>=', now()->format('Y-m-d'))
            ->get();

        // Assuming $appointments is a collection of appointments
        $bookedSlots = $appointments->groupBy('ap_date')->map(function ($dateSlots) {
            // Return an array of start times as strings
            return $dateSlots->pluck('ap_strTime')->toArray();
        })->toArray(); // Convert the result to a standard array

        // Convert the array to JSON
        $bookedSlotsJson = json_encode($bookedSlots);

        // Fetch user info from users table
        $userInfo = DB::table('users')
            ->where('user_id', $user_id)
            ->select('uname', 'udob')
            ->first();

        if (!$userInfo) {
            return redirect()->route('login')->with('error', 'User not found');
        }

        // Calculate the age
        $dob = new DateTime($userInfo->udob);
        $today = new DateTime();
        $ageInterval = $today->diff($dob);
        $age = $ageInterval->y . ' years, ' . $ageInterval->m . ' months, ' . $ageInterval->d . ' days';

        // Fetch doctor's name
        $doctorName = DB::table('doctors')
            ->join('users', 'doctors.users_id', '=', 'users.user_id')
            ->where('doctors.id', $doctor_id)
            ->value('users.uname'); // Retrieve the doctor's name

        // Create new appointment instance
        $appointment = new Appointment();
        $appointment->doctor_id = $doctor_id;
        $appointment->patient_id = $patient_id;
        $appointment->ap_date = $validatedData['apdate'];
        $appointment->ap_strTime = $validatedData['timing']; // the timing attribute comes from appointment view value
        $appointment->ap_endTime = date('H:i', strtotime($validatedData['timing']) + 15 * 60);
         //This strotime function converts time elapsed since Jan 1970 into seconds, here 15 more minutes are being added in terms of seconds in it in order to get precise 15 minutes, this is actually an automatic calculatoin of time for making the precise 15 minutes slot calculation  Example: 15 minutes duration
         
        $appointment->ap_type = $validatedData['aptime'];
        $appointment->ap_status = 'pending'; // Initial status

        // Check if the slot is already taken
        $isSlotTaken = Appointment::where('doctor_id', $doctor_id)
            ->where('ap_date', $validatedData['apdate'])
            ->where('ap_strTime', $validatedData['timing'])
            ->exists();

        if ($isSlotTaken) {
            return redirect()->back()->with('error', 'This time slot is already booked.');
        } else {
            // Save the appointment
            $appointment->save();
            session()->flash('success', 'Slot reserved successfully!');
        }

        // Debugging output
        // dd([
        //     'doctor_id' => $doctor_id,
        //     'patient_id' => $patient_id,
        // ]);

        // Redirect with additional doctor name information
        return redirect()->route('ptDash', [
            'uname' => $userInfo->uname,
            'udob' => $userInfo->udob,
            'age' => $age,
            'doctorName' => $doctorName, // Include doctor's name
            'bookedSlotsJson' => $bookedSlotsJson
        ]);
    }



    public function afterAppointment($uname, $udob, $age)
    {
        // Construct userInfo object The array is being casted to an object here. 
        $userInfo = (object) [
            'uname' => $uname,
            'udob' => $udob,
        ];

        // Retrieve the success message from the session
        $success = session('success');

        // Return the view with the passed data
        return view('ptDashBrd', compact('userInfo', 'age', 'success'));
    }





    public function fetchPtApp()
    {
        // Get the user ID from the session
        $user_id = session()->get('user_id');

        // Retrieve user information
        $userInfo = DB::table('users')
            ->where('user_id', $user_id)
            ->select('uname', 'udob')
            ->first();

        // Check if userInfo is found, else redirect to login with an error
        if (!$userInfo) {
            return redirect()->route('login')->with('error', 'User not found');
        }

        // Calculate the age
        $dob = new DateTime($userInfo->udob); //The DateTime constructor takes the date as a parameter, and returns the object contaiing the date.
        $today = new DateTime(); //current date is calculated
        $ageInterval = $today->diff($dob);
        $age = $ageInterval->y . ' years, ' . $ageInterval->m . ' months, ' . $ageInterval->d . ' days';

        // Fetch the patient record using the session user_id

        $patient = DB::table('patients')->where('users_id', $user_id)->first();
        if (!$patient) {
            return redirect()->route('login')->with('error', 'Patient record not found');
        }

        // Fetching appointment data with proper joins, including the doctor name
        $appointments = DB::table('appointments')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id') 
            //joining patients table with appointment table  where patient_id in appointments table is equal to id in patients
            ->join('users as patients_users', 'patients.users_id', '=', 'patients_users.user_id')
            //joining users table with appointment table  where users_id in patients table is equal to user_id in users
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            //joining doctors table with appointment table  where doctor_id in appointments table is equal to id in doctors
            ->join('users as doctors_users', 'doctors.users_id', '=', 'doctors_users.user_id')
            //joining users table with appointment table  where users_id in doctors table is equal to user_id in users
            ->where('appointments.patient_id', $patient->id)
            ->where('appointments.ap_status', 'pending')
            ->select(
                'appointments.ap_id', // Include the appointment ID
                'patients_users.uname as patient_name', //retreivnig the patient's name
                'doctors_users.uname as doctor_name', //retreivnig the doctor's name
                'appointments.ap_date', //retreving appointment date where patient id = session id ($patient->id)
                'appointments.ap_strTime',//retreving appointment startTime
                'appointments.ap_endTime',//retreving appointment endTime
                'appointments.ap_status'//retreving appointment status
            )
            ->get();

        




        // Return the view with the required data
        return view('appTableView', compact('userInfo', 'age', 'appointments'));
    }



    //This function is written for showing a respective patient's history to a specific doctor:

    public function fetchPatientHistory($patientId)
    {


        // Retrieve the doctor ID from the session
        $doctorUserId = session()->get('user_id'); // Ensure this is set correctly during login

        $userInfo = DB::table('users')
            ->where('user_id', $doctorUserId)
            ->select('uname', 'udob')
            ->first();

        $docInfo = DB::table('doctors')
            ->where('users_id', $doctorUserId)
            ->select('dtimg', 'dtspez')
            ->first();

        if (!$doctorUserId) {
            // Handle the case where the doctor ID is not available in the session
            return redirect()->route('login')->with('error', 'You need to be logged in to view the patient history.');
        }

        // Fetch the doctor record using the session user_id
        $doctor = DB::table('doctors')->where('users_id', $doctorUserId)->first();
        if (!$doctor) {
            // Handle the case where the doctor record is not found
            return redirect()->route('login')->with('error', 'Doctor record not found');
        }

        // Fetching only the appointments of the specified patient that were booked with the logged-in doctor
        $appointments = DB::table('appointments')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            //joining doctors table with appointment table  where doctor_id in appointments table is equal to id in doctors
            ->join('users as doctors_users', 'doctors.users_id', '=', 'doctors_users.user_id')
            //joining users table with appointment table  where users_id in doctors table is equal to user_id in users
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            //joining patients table with appointment table  where patient_id in patients table is equal to id in patients
            ->join('users as patients_users', 'patients.users_id', '=', 'patients_users.user_id')
            //joining users table with appointment table  where users_id in patients table is equal to user_id in users
            ->where('appointments.patient_id', $patientId)
            //in appointments table where patient_id's value is equal to $patientId 
            ->where('appointments.doctor_id', $doctor->id)  // Ensuring only appointments with this doctor are fetched
            ->where('appointments.ap_status', 'attended')   // Only fetching appointments which have the status of 'attended'
            ->select(
                'appointments.ap_id',
                'appointments.ap_date',
                'appointments.ap_strTime',
                'appointments.ap_endTime',
                'appointments.ap_status',
                'doctors_users.uname as doctor_name',
                'patients_users.uname as patient_name',
                'patients_users.user_id as patient_Id'
            ) ->paginate(8);

           $user_id= $doctorUserId; 
        // Return the view with the appointments
        return view('history', compact('appointments', 'userInfo', 'docInfo', 'user_id'));
    }


    //This function is written for showing a  patient's appointment history to him in his dashboard:

    public function fetchBookedAppointments()
    {
        // Retrieve the user ID from the session
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

        // Fetch the user's booked appointments with doctor and patient names
        $appointments = DB::table('appointments')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
             //joining doctors table with appointment table  where doctor_id in appointments table is equal to id in doctors
            ->join('users as doctors_users', 'doctors.users_id', '=', 'doctors_users.user_id')
             //joining users table with appointment table  where users_id in doctors table is equal to user_id in users table
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            //joining patient table with appointment table  where patient_id in appointment table is equal to id in patients
            ->join('users as patients_users', 'patients.users_id', '=', 'patients_users.user_id')
            //joining users table with appointment table  where users_id in patient table is equal to user_id in users table
            ->where('appointments.patient_id', $patient->id)
            //selecting the record in appointments where patient_id is equal to id in patients
            ->where('appointments.ap_status', 'attended')
            //selecting those records in appointments where appointments records have status attribute = attended
            ->select(
                'appointments.ap_id',
                'appointments.ap_date',
                'appointments.ap_strTime',
                'appointments.ap_endTime',
                'appointments.ap_status',
                'doctors_users.uname as doctor_name',
                'patients_users.uname as patient_name'
            )
            ->get();
            



        // Retrieve user information for the view
        $userInfo = DB::table('users')
            ->where('user_id', $user_id)
            ->select('uname', 'udob')
            ->first();

        // Calculate age
        $dob = new DateTime($userInfo->udob);
        $today = new DateTime();
        $ageInterval = $today->diff($dob);
        $age = $ageInterval->y . ' years, ' . $ageInterval->m . ' months, ' . $ageInterval->d . ' days';

        // dd($appointments);

        // Return the view with the appointments and user info
        return view('visits', compact('appointments', 'userInfo', 'age'));
    }




    //This function is responsible for fetching pending appointments to the admin's dashboard, where admin can verify a specific apponitment record after following the due process  
    public function fetchPendingAppointments()
    {
        // Ensure the admin is logged in
        if (session()->get('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }

        // Fetch appointments with 'pending' status
        $appointments = DB::table('appointments')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
             //joining doctors table with appointment table  where doctor_id in appointments table is equal to id in doctors
            ->join('users as doctors_users', 'doctors.users_id', '=', 'doctors_users.user_id')
             //joining users table with appointment table  where users_id in doctors table is equal to user_id in users table
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            //joining patients table with appointment table  where patient_id in appointments table is equal to id in patients table
            ->join('users as patients_users', 'patients.users_id', '=', 'patients_users.user_id')
            //joining users table with appointment table  where users_id in patients table is equal to user_id in users table
            ->where('appointments.ap_status', 'pending')
             //selecting those records in appointments where appointments records have status attribute = pending
            ->select(
                'appointments.ap_id',
                'appointments.ap_date',
                'appointments.ap_strTime',
                'appointments.ap_endTime',
                'appointments.ap_status',
                'doctors_users.uname as doctor_name',
                'patients_users.uname as patient_name'
            )->orderBy('appointments.ap_id', 'asc') // Ordering by latest date by using asc which is to sort in ascending order
            ->get();


        // Return the view with the appointments
        return view('admAppTableView', compact('appointments'));
    }



//function written for admin to see online appointments which have status verified (payment confirmed).

    public function fetchVerifiedOnlineAppointments()
    {
        // Ensure the admin is logged in
        if (session()->get('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }

        // Fetch appointments with 'pending' status
        $appointments = DB::table('appointments')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
             //joining doctors table with appointment table  where doctor_id in appointments table is equal to id in doctors
            ->join('users as doctors_users', 'doctors.users_id', '=', 'doctors_users.user_id')
             //joining users table with appointment table  where users_id in doctors table is equal to user_id in users table
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            //joining patients table with appointment table  where patient_id in appointments table is equal to id in patients table
            ->join('users as patients_users', 'patients.users_id', '=', 'patients_users.user_id')
            //joining users table with appointment table  where users_id in patients table is equal to user_id in users table
            ->where('appointments.ap_status', 'booked')
             //selecting those records in appointments where appointments records have status attribute = booked
            ->where('appointments.ap_type', 'online')
             //selecting those records in appointments where appointments records have status attribute = booked
            ->where('appointments.ap_mail', 'not_sent')
             //selecting those records in appointments where appointments records have status attribute = online
            ->select(
                'appointments.ap_id',
                'appointments.ap_date',
                'appointments.ap_strTime',
                'appointments.ap_endTime',
                'appointments.ap_status',
                'appointments.ap_type',
                'doctors_users.uname as doctor_name',
                'patients_users.uname as patient_name'
            )->orderBy('appointments.ap_id', 'asc') // Ordering by latest date by using asc which is to sort in ascending order
            ->get();


        // Return the view with the appointments
        return view('admOnlineAppTableView', compact('appointments'));
    }








    // function written for fetching appointments for doctor with status booked
    // Which means these appointments will be paid, doctor will do further 
    // proceedings in terms of medical process i.e. prescription writing, marking appointment as attended etc.

    public function fetchDoctorAppointments()
    {
        // Retrieving the user ID from the session
        $user_id = session()->get('user_id');

        if (!$user_id) {
            return redirect()->route('login')->with('error', 'You need to be logged in to view your appointments.');
        }

        // Fetch the doctor's information using the session user_id
        $doctor = DB::table('doctors')->where('users_id', $user_id)->first();
        if (!$doctor) {
            return redirect()->route('login')->with('error', 'Doctor record not found');
        }

        // Fetch the appointments associated with this doctor that are 'booked' for today
        $appointments = DB::table('appointments')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            //joining patients table with appointment table where patient_id in appointments table is equal to id in patients table
            ->join('users as patients_users', 'patients.users_id', '=', 'patients_users.user_id')
            //joining users table with appointment table  where users_id in patients table is equal to users_id in patients table
            ->where('appointments.doctor_id', $doctor->id)
            //checking in appointments table that doctor_id column has the value equal to the id retreived from doctors table via session vrbl 
            ->where('appointments.ap_status', 'booked')
               //selecting those records in appointments where appointments records have status attribute = booked
            ->whereDate('appointments.ap_date', now()->toDateString()) // filter dates which are current dates 
            ->select(
                'appointments.ap_id',
                'appointments.ap_date',
                'appointments.ap_strTime',
                'appointments.ap_endTime',
                'patients_users.uname as patient_name',
                'patients_users.udob as patient_dob',
                'patients_users.user_id as patient_id'
                ) ->get();
                // ->paginate(3); // Using paginate method for limiting the results according to the need 


        // Processing each appointment record to calculate patient age in years only
        foreach ($appointments as $appointment) {
            $dob = new DateTime($appointment->patient_dob);
            $today = new DateTime();
            $ageInterval = $today->diff($dob);
            $appointment->patient_age = $ageInterval->y . ' years'; // converting Age in years only
        }

        // Retrieve doctor information for the view
        $userInfo = DB::table('users')
            ->where('user_id', $user_id)
            ->select('uname', 'udob')
            ->first();

        $docInfo = DB::table('doctors')
            ->where('users_id', $user_id)
            ->select('dtimg', 'dtspez')
            ->first();

            // dd($appointments);   

        // Return the view with the appointments and doctor info
        return view('doctorToPatient', compact('appointments', 'userInfo', 'docInfo', 'user_id'));
    }




//function written for doctor's dashboard to show appointments 

    public function bwPatientDoc($appointmentId)
    {
        // Retrieve the user ID from the session
        $user_id = session()->get('user_id');

        if (!$user_id) {
            return redirect()->route('login')->with('error', 'You need to be logged in to view your appointments.');
        }

        // Fetch the doctor's information using the session user_id
        $doctor = DB::table('doctors')->where('users_id', $user_id)->first();
        if (!$doctor) {
            return redirect()->route('login')->with('error', 'Doctor record not found');
        }
        dd($doctor);


        $userInfo = DB::table('users')
            ->where('user_id', $user_id)
            ->select('uname', 'udob')
            ->first();

        $docInfo = DB::table('doctors')
            ->where('users_id', $user_id)
            ->select('dtimg', 'dtspez')
            ->first();


        // Fetch the appointments for the given appointment ID
        $appointments = DB::table('appointments')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            //joining patients table with appointment table where patient_id in appointments table is equal to id in patients table
            ->join('users as patients_users', 'patients.users_id', '=', 'patients_users.user_id')
             //joining users table with appointment table  where users_id in patients table is equal to user_id in patients table
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
             //joining doctors table with appointment table  so that doctor_id in appointments table is equal to id in doctors table
            ->join('users as doctors_users', 'doctors.users_id', '=', 'doctors_users.user_id') 
             //joining users table with appointment table  where users_id in doctors table is equal to user_id in users table
            ->where('appointments.doctor_id', $doctor->id)
            //checking the appointments table column doctor_id where value should match id in doctors table
            ->where('appointments.ap_status', 'attended')
               //selecting those records in appointments where appointments records have status attribute = attended
            ->select(
                'appointments.ap_id',
                'appointments.ap_date',
                'appointments.ap_strTime',
                'appointments.ap_endTime',
                'appointments.ap_status',
                'patients_users.uname as patient_name',
                'doctors_users.uname as doctor_name',
                'patients_users.udob as patient_dob'
            )
            ->get();



        if ($appointments->isEmpty()) {
            return view('ptDocAppts', compact('doctor', 'docInfo', 'userInfo'));
        }

        // Process patient age
        foreach ($appointments as $appointment) {
            $dob = new DateTime($appointment->patient_dob);
            $today = new DateTime();
            $ageInterval = $today->diff($dob);
            $appointment->patient_age = $ageInterval->y . ' years'; // Age in years only
        }

        // Retrieve doctor information for the view

        // Return the view with the appointment details
        return view('ptDocAppts', compact('appointments', 'doctor', 'docInfo', 'userInfo'));
    }





    public function markAsAttended($appointmentId)
    {
        // Retrieve the user ID from the session
        $user_id = session()->get('user_id');

        if (!$user_id) {
            return redirect()->route('login')->with('error', 'You need to be logged in to perform this action.');
        }

        // Checking if the appointment belongs to the logged-in doctor or not
        $appointment = DB::table('appointments')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            //joining doctors table with appointment table  where doctor_id in appointment table is equal to id in doctors table
            ->where('appointments.ap_id', $appointmentId)

            ->where('doctors.users_id', $user_id)
            //looking for users_id column in doctors where value should match to $user_id from session variable to ensure that this appointment belongs to specific doctor who is currently logged in
            ->select('appointments.*')
            //everything from appointments table is selected with given constraints
            ->first();

        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found or unauthorized access.');
        }

        //After all given constraints are met, appointment record is updated with new status as attended
        // Update the appointment status to 'attended'
        DB::table('appointments')
            ->where('ap_id', $appointmentId)
            ->update(['ap_status' => 'attended']);

        return redirect()->back()->with('success', 'Appointment marked as attended.');
    }






    public function verifyAppointment($id)
    {
        // Update the status of the appointment
        $updated = DB::table('appointments')
            ->where('ap_id', $id)
            ->update(['ap_status' => 'booked']);

        if ($updated) {
            return redirect()->route('pending-appointments')->with('success', 'Appointment status updated successfully.');
        } else {
            return redirect()->route('pending-appointments')->with('error', 'Failed to update appointment status.');
        }
    }



    public function patientDeletesAppointment($appointmentID)
    {
        // Update the status of the appointment
        $deleteAppointment = DB::table('appointments')
            ->where('ap_id', $appointmentID)
            ->delete();

        if ($deleteAppointment) {
            return redirect()->route('myBookings')->with('success', 'Reserved Slot deleted successfully!');
        } else {
            return redirect()->route('myBookings')->with('error', 'Failed to delete Slot!');
        }
    }


    public function adminDeletesAppointment($appointmentID)
    {
        // Update the status of the appointment
        $deleteAppointment = DB::table('appointments')
            ->where('ap_id', $appointmentID)
            ->delete();

        if ($deleteAppointment) {
            return redirect()->route('pending-appointments')->with('success', 'Reserved Slot deleted successfully!');
        } else {
            return redirect()->route('pending-appointments')->with('error', 'Failed to delete Slot!');
        }
    }


}
