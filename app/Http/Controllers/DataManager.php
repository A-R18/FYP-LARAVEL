<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usrdata;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DataManager extends Controller
{
    //function written for showing the doctors 
    public function doczshow()
    {
        return view("drDisplay");
    }


    //function written for DDisplaying doctors to a logged in patient
    public function drzData()
    {
        // Fetch all doctors along with their user information
        $doctors = DB::table('doctors')
            //along with doctors the users table is being joined with it on the basis of users_id stored in doctors
            ->join('users', 'doctors.users_id', '=', 'users.user_id')
            //where clause has been added to ensure the users with role doctor are retreived only.
            ->where('users.role', 'doctor')
            // final step is selecting the columns in which all columns from doctors are selected while only user_name is selected from users.
            ->select('doctors.*', 'users.uname')
            ->get(); //added to include entire collection of results.

        // Getting the patient ID from the session
        $patientId = session()->get('user_id');

        // A query written for finding the patient in hte patient table.
        $patient = DB::table('patients')
            ->where('users_id', $patientId)
            ->first(); //Added to fetch the first matching record as an object

        // Check if patient is found
        if (!$patient) {
            // Handling the case where the patient is not found, redirecting back with an error
            return redirect()->back()->with('error', 'Patient not found.');
        }
        // dd($patient ->id);

        // Passing the patient's id to the view along with other data
        return view('drDisplay', ['patientId' => $patient->id, 'doctors' => $doctors]);
    }


    //Function written for displaying doctors in the system
    public function drzDataDsp()
    {
        //Query written for fetching all doctors along with their user information
        $doctors = DB::table('doctors')
            //along with doctors the users table is being joined with it on the basis of users_id stored in doctors
            ->join('users', 'doctors.users_id', '=', 'users.user_id')
            //where clause has been added to ensure the users with role doctor are retreived only.
            ->where('users.role', 'doctor')
            // final step is selecting the columns in which all columns from doctors are selected while only user_name is selected from users.
            ->select('doctors.*', 'users.uname')
            //added to include entire collection of results.
            ->get();

        // Get the patient ID from the session

        // dd($patient ->id);

        // Pass the patient's id to the view along with other data
        return view('drDisplay', ['doctors' => $doctors]);
    }



}
