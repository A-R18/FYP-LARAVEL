<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ZoomCredential;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ZoomAppointmentMail;

class ZoomOperation extends Controller
{
    //function written for storing data in zoom controller.
    public function insertZoomCredentials(Request $req)
    {
        //two attributes being stored in zoom table are being validated.
        $req->validate([
            //this attribute is required, it can be stored as a string, it should be 11 at max.
            'meetingID' => 'required|string|max:11',
            //this attribute is required, it can be stored as a string, it should be 12 at max.
            'meetingPasscode' => 'required|string|max:12',
        ]);

        //if constraint applied in order to check a record already exists in zoom table, if that's the case, error is displayed with a message.
        if (ZoomCredential::exists()) {
            return redirect()->back()->with(['error' => 'Only one Zoom Credentials record can exist. Delete or Update that one.']);
        }
//otherwise the data is assigned to db attributes
//new instance is created of Zoom model 
        $ZoomCredential = new ZoomCredential();
        //meetingID entered in the form is assigned to db attribute
        $ZoomCredential->meetingID = $req['meetingID'];
        //meetingPasscode entered in the form is assigned to db attribute
        $ZoomCredential->meetingPasscode = $req['meetingPasscode'];
        //data which is validated and assigned to db variables is now saved in database.
        $ZoomCredential->save();

        return redirect()->route('ZoomForm')->with('success', 'Zoom credentials inserted successfully!');
    }

//function written for showing the zoom credentials form zoom table to a view in  admin's dashboard.
    public function showZoomCredentials()
    {
        //Query written fetching the record present in zoom_credentials table
        $zoomCredentials = DB::table('zoom_credentials')
        ->get();
        return view('zoomCredentialsTable', compact('zoomCredentials'));
    }

    //function written for deleting existing zoom credential from the table (for Admin) This function takes zoom_record_id as argument

    public function deleteZoomCredentials($zoomRecordID)
    {

        // dd($zoomRecordID);
        // Delete the record and check if deletion was successful
        $deleted = DB::table('zoom_credentials')
            ->where('id', $zoomRecordID)
            ->delete();

        // Redirect back to the table view with success or error message
        if ($deleted) {
            return redirect()->route('showZoomTable')->with('success', 'Credentials deleted successfully');
        } else {
            return redirect()->route('showZoomTable')->with('error', 'Failed to delete credentials');
        }
    }

    //function written for updating the existing zoom record in zoom table. 
    public function updateZoomCredentials(Request $req)
    {
        //enforcing the existing validation here again to ensure validated data is stored in database.
        $req->validate([

            //this attribute is required, it can be stored as a string, it should be 11 at max.
            'meetingID' => 'required|string|max:11',
            //this attribute is required, it can be stored as a string, it should be 12 at max.
            'meetingPasscode' => 'required|string|max:12',
        ]);

//id is sent by post in form as hidden attribute which is being used to find that specific record.
        $zoomCredentials = ZoomCredential::find($req->id);
        // dd($zoomCredentials);
        //meetingID is being saved like it was saved previously in original version.
        $zoomCredentials->meetingID = $req['meetingID'];
        //meetingPasscode is being saved like it was saved previously in original version.
        $zoomCredentials->meetingPasscode = $req['meetingPasscode'];
        //data which is validated and assigned to db variables is now saved in database.
        $zoomCredentials->save();

        return redirect()->route('showZoomTable')->with('success', 'Zoom credentials updated successfully!');
    }

//function written to show the view containing form where data is updated, it takes zoomRecordID as argument  
    public function showUpdateZoomForm($zoomRecordID)
    {

        // dd($zoomRecordID);
        //zoom id is being used to find specific record in via this query in zoom table.
        $zoomCredentials = ZoomCredential::find($zoomRecordID);

        //  dd($zoomCredentials);   

        // Redirect back to the table view with success or error message
        if ($zoomCredentials) {
            return view('updateZoomCredentials', compact('zoomCredentials'))->with('success', 'Update the data here!');
            // 
        }
    }
//Function written for retrieving zoom table attributes which are necessary to have a zoom meeting, these attributes are further sent to a view file which is being mailed to a specific person. this function takes appointmentID as an argument and it has also the functionality to send mail to respective patient who has an online appointment. 
    public function putZoomCredentialsInMail($appointmentID)
    {
        // Query written to retrieve patient and appointment data
        $patient = DB::table('appointments')
        //where clause is added in which comparison is been made between ap_id of appointment and $appointmentID to match a record.
            ->where('ap_id', $appointmentID)
            //inner join is applied on patients table where patient_id attribute of appointments table matches id attribute of patients.
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            //inner join is applied on users table where users_id attribute of patients table matches user_id attribute of users table.

            ->join('users', 'patients.users_id', '=', 'users.user_id')
            //attributes to be selected from query 
            ->select(
                'appointments.ap_strTime',
                'appointments.ap_endTime',
                'users.uname',
                'users.uemail'
            )
            ->first();//added to match the first most & single record containing these credentials

        //query written to fetch a single zoom record from zoom_credentials table.        
        $zoomCred = DB::table('zoom_credentials')
            ->first();

        // Checking if retrieved data exists
        if (!$patient || !$zoomCred) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        // Sending the email to specific patient 
        Mail::to($patient->uemail)->send(new ZoomAppointmentMail($zoomCred, $patient));

        return redirect()->back()->with('success', 'Email sent successfully!');
    }


    //function written for admin to change the mail status of an appointment record from not_sent to sent. this function is taking $appointmentID as argument
    public function tickMailStatus($appointmentID){
    
        // Ensuring that  the admin is logged in
        if (session()->get('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }

        // Query written for fetching record from appointments on basis of appointmentID variable
        DB::table('appointments')
        ->where('ap_id', $appointmentID)
        //updating the ap_mail attribute to the value 'sent'
        ->update(['ap_mail'=>'sent']);
        return redirect()->back()->with('success', 'Mail status changed to sent.');
}

}