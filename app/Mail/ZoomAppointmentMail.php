<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZoomAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

   public $zoomCred;
   public $patient;
 // Constructor method to initialize Zoom credentials and patient details
   public function __construct($zoomCred, $patient)
    {
        $this->zoomCred = $zoomCred;
        $this->patient = $patient;
    }

   

    /**
     * Get the message content definition.
     */
    //a function written named as build which returns the specific view along with the subject of the mail which will be sent into the patient.
    public function build()
    {
        return $this->view('onlineAppointmentMail')
        ->subject('Your Zoom Appointment Details');
        
    }

    
}
