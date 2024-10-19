<?php

namespace App\Http\Controllers;

use App\Models\Usrdata;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ForgotPassword extends Controller
{
    //function written for showing the view forgetpass
    public function showForget()
    {
        return view("forgetPass");
    }

    //function written for taking validated email, should be email, which exists in users table,
    public function ForgetPassword(Request $req)
    {
//Email coming from the form is being validated.
        $req->validate([
            'uemail' => 'required|email|exists:users',
        ]);
        // a variable is delclared which stores a string of 64 random characters

        $token = Str::random(length: 64);
        //dd($token);
//A query is written for inserting email obtained from form, token randomly created, and timeStamp of now.
        DB::table('password_reset_tokens')->insert([
            'email' => $req->uemail,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // dd($req->uemail);
//Mail is being sent to the validated email, with subject Password Reset Email, along with token
//The use ($req) allows the $req variable to be accessed within the closure for email configuration.
        Mail::send('mailStructure', ['token' => $token], function ($message) use ($req) {
            $message->to($req->uemail);
            $message->subject('Password Reset Email');
        });

        return redirect()->to(route('frgtPswd'))->with('success', 'Email has been sent on your Email address');
    }

//This is the function which takes token as argument and returns a view resetPass with this token variable accessible in that view
    public function resetPassword($token)

    {
        return view('resetPass', compact('token'));
    }


//After the resetPass appears this function comes into play, this view allows to enter the existing email and the new password which a user wants to enter, then they are validated
    public function resetPasswordpost(Request $req)
    {
        $eml=$req->uemail;
        $pass=$req->upass;
        // dd($req->uemail);
        $req->validate([
            'uemail' => 'required|email|exists:users',
            'upass' => 'required|string|regex:/^[a-zA-Z0-9]{8,15}$/'
        ]);

        //This query matches the token and the email (first most record),
        $updatePassword = DB::table('password_reset_tokens')
        ->where(['email' => $eml, 'token' => $req->token])->first();
        // dd($updatePassword);  
        //If the query isn't true (record doesn't match) then
        if (!$updatePassword) {
          
            return redirect()->to(route('resetPswd'))->with('error', 'Invalid');
        }
        //if such record is found then:
            //a query gets executed in which users table is accessed on the basis of email match, & password is updated there with md5 hashing
        Usrdata::where('uemail', $req->uemail)->update(['upassword' =>md5($pass) ]);
        
        //A delete query is executed in which the table password_reset_tokens (if has any record containing respective email gets deleted). 
        DB::table('password_reset_tokens')->where(['email' => $req->uemail])->delete();

        return redirect()->to(route('login'))->with('success', 'Password reset success');
    }
}
