<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Ptdata;
use App\Models\Usrdata;
use App\Models\Staff;
use App\Models\DataManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Registration extends Controller
{
    public function ptshow()
    {
        return view("PatientReg");
    }
    public function ptDash()
    {
        return view("ptDashBrd");
    }
    public function adshow()
    {
        return view("adForm");
    }


    public function docFrmshow()
    {
        return view("dctForm");
    }



    public function showlogin()
    {
        return view("login");
    }

    public function showForget()
    {
        return view("forgetPass");
    }





    //this function is written for storing the users of this system into the database, four tables are being dealt by this function the generic data is being saved in users table, the specific data of patients, doctors, & admin is being stored into their respective tables, Moreover, users are role based, and their data is being strictly validated too (according to respective needs). 


    public function Store(Request $str)
    {
        //generic validation for users table, which contains user_name , user_dob, user_contact, user_password & user_email 
        $mainValidation = [
            //user name is required it only allows letters (including Unicode characters) and spaces
            'uname' => 'required|regex:/^[\pL\s]+$/u|max:30',
            //user dob which is required, should be data &  it should be less than or equal to today's date.
            'udob' => 'required|date|before_or_equal:today',
            //user contact, it's required, it should be a number, it should contain 11 digits, it should always start with 03 and other 9 digits should be random numeric digits.
            'ucontact' => 'required|numeric|digits:11|regex:/^03\d{9}$/',
            //user password is required, it can be a string of choice with min 8 digits and 15 digits at max, it can contain aA-zZ & 0-9
            'upass' => 'required|string|regex:/^[a-zA-Z0-9]{8,15}$/',
            //user_email it is required, it should be of type email, it can be 30 characters at max 
            'uemail' => 'required|email|max:40'
        ];

        //now the other part of validation begins which validates the portion of specified data with respective roles:
        if ($str->role == 'patient') {
            $patientValidation = [
                //the address of a patient is required, it can be upto 80 characters.
                'ptaddr' => 'required|max:80'
            ];
            $str->validate(array_merge($mainValidation, $patientValidation));
            //the data is being passed to the validate method by combining rules from both arrays to be applied to the data being validated

        } elseif ($str->role == 'admin') {
            $adminValidation = [
                //The admin desgnation field can be upto 20 characters at maximum
                'stdesg' => 'required|max:20'
            ];
            $str->validate(array_merge($mainValidation, $adminValidation));
            //the data is being passed to the validate method by combining rules from both arrays to be applied to the data being validated

        } elseif ($str->role == 'doctor') {
            $doctorValidation = [
                //The doctor specialization field is required, can be 30 characters at max.
                'dtspez' => 'required|max:30',
                //The doctor startTime field is required, time will be stored in this field.
                'strtime' => 'required',
                //The doctor endTime field is required, time will be stored in this field..
                'endtime' => 'required',
                //The doctor specialization field is required, can be 30 characters at max.
                'dtimg' => 'required|max:2048',
                //The doctor specialization field is required, can be 30 characters at max.
                'status' => 'required'
            ];

            $str->validate(array_merge($mainValidation, $doctorValidation));
            //the data is being passed to the validate method by combining rules from both arrays to be applied to the data being validated

        }

        // Here user data is being saved after being validated by the vadlidate function written above with specific constraints and rules.
        //new instance of UsrData is being created
        $user = new Usrdata();
        //user name is stored 
        $user->uname = $str['uname'];
        //user DOB is being stored
        $user->udob = $str['udob'];
        //user contact is being stored
        $user->ucontact = $str['ucontact'];
        //user gender is being stored
        $user->gender = $str['ugender'];
        //user email is being stored.
        $user->uemail = $str['uemail'];
        //user password is being stored in database where the encryption (md5) is be applied for worst case: if database gets hacked, hacker must not be able to see the data inside DB.
        $user->upassword = md5($str['upass']);
        //user role is being stored
        $user->role = $str['role'];
        //user's all data finally gets stored in users table
        $user->save();
        $userId = $user->id; // Here whichever the user is being saved the primary key is being correctly retrieved 

        // Saving additional data based on the role
        if ($str->role == 'patient') {
            //new instance of Ptdata is being created if entering the case where role is 'patient'
            $ptdata = new Ptdata();
              //patient's user_id is being taken from the variable where the id was taken from users table
            $ptdata->users_id = $userId; // Using $userId here
            //patent's address is being stored 
            $ptdata->ptaddr = $str->ptaddr;
            //patiet's all data finally gets stored to the DB in patients table
            $ptdata->save();
        } elseif ($str->role == 'admin') {
            // new instance of Staff is being created
            $admdata = new Staff();
            //staff's user_id is being taken from the variable where the id was taken from users table
            $admdata->users_id = $userId;
            //staff's designation is beig stored.
            $admdata->stdesg = $str['stdesg'];
            //staff's all data is being saved to the DB in admins table
            $admdata->save();
        } elseif ($str->role == 'doctor') {
            // new instance of Doctor is being created
            $docdata = new Doctor();
            // doctor's user_id is being taken from the variable where the id was taken from users table
            $docdata->users_id = $userId;
            //doctor's specialization is being stored
            $docdata->dtspez = $str['dtspez'];
            //doctor's status of availability is being stored 
            $docdata->status = $str['status'];
            //doctor's end time is being stored
            $docdata->endtime = $str['endtime'];
            //doctor's start time is being stored
            $docdata->strtime = $str['strtime'];
            //doctor's fee is being stored
            $docdata->dt_fee = $str['dt_fee'];
            //Image has the filename which should be saved only in the database
            $docdata->dtimg = $str->file('dtimg')->getClientOriginalName();
            //The file will be uploaded to the dedicated folder located in public/uploads
            $str->file('dtimg')->move('uploads/', $docdata->dtimg);
             //doctor's all data is being saved to the DB in admins table
            $docdata->save();
        }

        return redirect()->route('login')->with('success', 'Success! Please login');
    }






    // Retrieve user from the database
    public function loginUser(Request $req)
    {
      


        // Retrieveing user fields from the database and comparing them with the fields entered in the login form by user. 
        $user = Usrdata::where('uemail', $req->uemail)
            ->where('upassword', md5($req->upassword))
            ->first();
        //if comparison was successful and records matched on both sides, then 
        if ($user) {
            // Clearing existing session data and generating a new session ID (extra precautious approach)
            session()->flush();
            session()->regenerate();

            // Storing user-specific data in the session
            //user_id is being stored in session

            session()->put('user_id', $user->user_id);

            //user_role is being stored in session
            session()->put('role', $user->role);

            //if the role of user is patient then:
            if ($user->role == 'patient') {
                //a query is being run in which based on user_id the name and date of birth is being retreived.
                $userInfo = DB::table('users')
                    ->where('user_id', $user->user_id)
                    ->select('uname', 'udob')
                    ->first();

                // Calculating the age from the dob attribute.
                //$dob variale is storing the date entered by user (actual dob)
                $dob = new DateTime($userInfo->udob);
                //$today is storing the dateTime empty which is by default the current date and time
                $today = new DateTime();
                //$ageInterval is storing the difference of date entered by user and current date which means total age of respective user
                $ageInterval = $today->diff($dob);
                //$age is storing the string years, months & days obtained from $ageInterval
                $age = $ageInterval->y . ' years, ' . $ageInterval->m . ' months, ' . $ageInterval->d . ' days';

                // Redirecting to patient dashboard with userInfo & age variables
                return view('ptDashBrd', ['user' => $user, 'userInfo' => $userInfo, 'age' => $age]);
            } elseif ($user->role == 'admin') {
                // Redirecting to admin actions page
                return redirect(route('adminact'));
            } elseif ($user->role == 'doctor') {
 //a query is being run  based on user_id, the name is being retreived.

                $userInfo = DB::table('users')
                    ->where('user_id', $user->user_id)
                    ->select('uname')
                    ->first();

//another query is being run based on user_id, the dtimg & dtspez is being retreived.
                $docInfo = DB::table('doctors')
                    ->where('users_id', $user->user_id)
                    ->select('dtimg', 'dtspez')
                    ->first();

                // Redirect to doctor dashboard with docInfo and related variables
                return view('dtDashBrd', ['userInfo' => $userInfo, 'user' => $user, 'docInfo' => $docInfo, 'user_id' => $user->user_id]);
            }
        } else {
            // Invalid credentials, redirecting back to login
            return redirect('login')->with('error', 'Invalid Credentials');
        }
    }




    public function logOut(Request $req)
    {
        // Clearing all session data
        session()->flush();

        // Redirecting to login page with success message
        return redirect(route('login'))->with('success', 'Logged out');
    }

//a function written for showing the updation form to the doctor where he change is availability status.

    function showDoctorUpdateForm($doctorID)
    {
//as doctor will be logged in, so his user id is being retrieved from session variables.
        $user_id = session()->get('user_id');

 //a query is being run  based on user_id, the name is being retrieved is being retreived.
        $userInfo = DB::table('users')
            ->where('user_id', $user_id)
            ->select('uname')
            ->first();
//another query is being run  based on user_id, the doctor's image & doctor's specialization are being retrieved.
        $docInfo = DB::table('doctors')
            ->where('users_id', $user_id)
            ->select('dtimg', 'dtspez')
            ->first();
//another query is being run  based on $doctorID, the doctor's current status & doctor's name are being retrieved.
        $doctor = DB::table('users')
            ->where('user_id', $doctorID)
            ->join('doctors', 'doctors.users_id', '=', 'users.user_id')
            ->select('users.uname', 'doctors.status')
            ->first();
        return view('doctorAvailabilityStatus', compact('doctor', 'userInfo', 'docInfo', 'user_id'));
    }

//a function written for the updation the doctor's availability status.
    function updateDoctorStatus(Request $req)
    {
//as doctor will be logged in, so his user id is being retrieved from session variables.
        $user_id = session()->get('user_id');
 //a query is being run  based on user_id, the name is being retrieved is being retreived.
        $userInfo = DB::table('users')
            ->where('user_id', $user_id)
            ->select('uname')
            ->first();

 //another query is being run  based on user_id, the doctor's image & doctor's specialization are being retrieved.           
        $docInfo = DB::table('doctors')
            ->where('users_id', $user_id)
            ->select('dtimg', 'dtspez')
            ->first();

        $users_id = $req->id;
        // dd($users_id);

    // a query written to update the current status of docotr     
        $updateStatus = DB::table('doctors')
            ->where('users_id', $req->id) //the id is being passed from hidden attribute in the form.
            ->update(['status' => $req->status]);

//if the query was executed properly, then the following case will be executed: 
        if ($updateStatus)

            return redirect()->route('doctorAppointments', [
                'docInfo' => $docInfo,
                'userInfo' => $userInfo,
                'user_id' => $user_id
            ])->with('success', 'Your Status has been updated successfully');

        else
//if the query wasn't executed properly, then the following case will be executed: 
            return redirect()->route('doctorAppointments', [
                'docInfo' => $docInfo,
                'userInfo' => $userInfo,
                'user_id' => $user_id
            ])->with('error', 'Status unchanged');
    }
}
