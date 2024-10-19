<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Pymnt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Payment extends Controller
{

    //function written to show payment form with readonly and fillable attributes too, this function takes ap_id as argument, on the basis of that appointment record, fetches patient and doctor attributes required while filling the payment form.  
    public function pyshow($appointmentID)
    {


        // Getting the user ID from the session
        $user_id = session()->get('user_id');


        // Retrieving user information
        $userInfo = DB::table('users')
            //In users table matching the user_id with the attribute $user_id.
            ->where('user_id', $user_id)
            //upon the match selecting uname and udob from the first most match.
            ->select('uname', 'udob')
            //written for fetching the first record.
            ->first();

        // Checking if userInfo is found, else redirecting to login with an error
        if (!$userInfo) {
            return redirect()->route('login')->with('error', 'User not found');
        }

        // Calculating the age
        $dob = new DateTime($userInfo->udob); //The DateTime constructor takes the date as a parameter, and returns the object contaiing the date. This variable will store the dob of the existing user.
        $today = new DateTime(); //current date is stored in this variable
        $ageInterval = $today->diff($dob); //in this variable the differnce between current date and user's dob is calculated which is exactly the current age of a patient.
        $age = $ageInterval->y . ' years, ' . $ageInterval->m . ' months, ' . $ageInterval->d . ' days'; //age variable holds the age converted into years, months and days.

        //A query written to retrieve appointment_id, current user's name and current doctor's fee 
        $patient = DB::table('appointments')
            //where clause is used to initiate query on the basis of ap_id match in appointments.
            ->where('ap_id', $appointmentID)
            //joining patients table's record where patient id in appointments table matches users_id in patients 
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            //joining doctors table's record where doctor id in appointments table matches users_id in doctors
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            //joining users table's record where users id in patient table matches user_id in users
            ->join('users', 'patients.users_id', '=', 'users.user_id')
            //finally selecting appointment id, name of patient and fee of respective doctor from the query.
            ->select('appointments.ap_id', 'users.uname', 'doctors.dt_fee')
            ->first();




        return view('pym', compact('patient', 'dob', 'userInfo', 'age'));
    }

    //function written for storing the payment made by the patients 
    public function paydta(Request $req)
    {
        //the data in the form is comprised of four visible attributes of which two are readonly, and other two are needed to be filled manually. 
        $validatedData = $req->validate([
            //The name of the payer's account (account title) is needed to be filled with max characters upto 30. 
            'uname' => 'required|regex:/^[\pL\s]+$/u|max:30',
            //The account no. is required which should be numeric and should be minimum of 10 & max of 15 digits.
            'accNo' => 'required|numeric|digits_between:10,15',

        ]);


        // Checking if the payment already exists to prevent duplicates
$existingPayment = Pymnt::where('users_id', session()->get('user_id'))
->where('slot_id', (int) $req['sid'])
->first();

if ($existingPayment) {
// If a payment already exists, redirect with an error message
return redirect()->back()->with('error', 'Payment already submitted for this appointment!');
}

        // here new instance of Pymnt model is being created.
        $dta = new Pymnt();
        // data (uname) comming in req is being assigned to corresponding database column of payments table.
        $dta->uname = $req['uname'];
        // data (slot_id) comming in req is being assigned to corresponding database column of payments table.
        $dta->slot_id = (int) $req['sid'];
        // data (acc_no) comming in req is being assigned to corresponding database column of payments table.
        // Ensure slot_id is stored as an integer
        $dta->acc_no = $validatedData['accNo'];
        // data (amount) comming in req is being assigned to corresponding database column of payments table.
        $dta->amount = $req['amount'];
        // data (uname) comming from session variable as hidden attribute is being assigned to corresponding database column of payments table.
        $dta->users_id = session()->get('user_id'); // Setting the user_id from the session
        //data is being saved in the database after all the process happening above.
        $dta->save();

        if($dta->save()){


            return redirect()->back()->with('success', 'Payment details submitted successfully!');
        }
else{
    return redirect()->back()->with('error', 'Payment Submitted already!');
}

    }




    //function written for showing payments to the patient that he made

    public function myPaymentz()
    {
        // Retrieving the patient ID from the session
        $patient_id = session()->get('user_id');
        //Query written for Retrieving user information from the 'users' table on tha basis of session id stored in patient_id variable.
        //Query written for retrieving name and dob of patient from users table 
        $userInfo = DB::table('users')
            ->where('user_id', $patient_id)
            ->select('uname', 'udob')
            ->first();

        // Check if userInfo is found; redirect to login if not
        if (!$userInfo) {
            return redirect()->route('login')->with('error', 'User not found');
        }

        // Calculate the age based on the date of birth
        $dob = new DateTime($userInfo->udob);
        $today = new DateTime();
        $ageInterval = $today->diff($dob);
        $age = $ageInterval->y . ' years, ' . $ageInterval->m . ' months, ' . $ageInterval->d . ' days';

        // Retrieve payments associated with the user's uname
        $payments = DB::table('payments')
            ->where('users_id', $patient_id)
            ->paginate(8);
        // dd($payments);

        // Pass user info and payments data to the view
        return view('patientPayments', [
            'patientId' => $patient_id,
            'payments' => $payments,
            'userInfo' => $userInfo,
            'age' => $age
        ]);
    }



    // For admin to view unchecked payments



    public function uncheckedPayments()
    {
        // Query written on payments table for getting all unchecked payments with pagination (for Admin)
        $uncheckedPayments = DB::table('payments')
            //where clause is added to specify those records which have the status unchecked.
            ->where('pym_status', 'unchecked')
            //selecting specified attributes from payment table.
            ->select('py_id', 'uname', 'slot_id', 'acc_no', 'amount', 'pym_status', 'created_at')
            ->paginate(8); // To paginate the tables in terms of the records per page this statement is added.

        // Passing the paginated payments data to the view
        return view('uncheckedPayments', ['payments' => $uncheckedPayments]);
    }



    //Function written for updating the payments table records where the status of payments is unchecked and it gets changed into checked when done by admin. This function is taking payment id as argument on basis of which further proceeding of updation is being done.
    public function checkPayment($id)
    {
        //Query written for updating the payment status to 'checked' 
        $update = DB::table('payments')
            //where clause added to compare the id received by the function as argument and id in the payments table.
            ->where('py_id', $id)
            //status getting changed to checked from unchecked after a due process followed by admin. 
            ->update(['pym_status' => 'checked']);

        if ($update) {
            return redirect()->route('unchecked-Payments')->with('success', 'Payment status updated successfully.');
        } else {
            return redirect()->route('unchecked-Payments')->with('error', 'Failed to update payment status.');
        }
    }
}
