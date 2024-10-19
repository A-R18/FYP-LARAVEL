<!-- This view file shows the prescription of the doctor in of his patient after navigating to the patient's appontment history -->

@extends('dtDashBrd') <!-- Extending the patient dashboard layout -->

@section('doctorToPatientContent') <!-- Section to inject content into the .mn div -->

<div class="prcp">
    <div class="hdr">
        <!-- Slot Id -->
        <div class="hrch">Slot ID
        </div>
        <!-- Patient Name -->
        <div class="hrch"> Patient Name
        </div>
        <!-- Doctor Name -->
        <div class="hrch">Doctor Name
        </div>
        <!-- Appointment Date -->
        <div class="hrch">Date
        </div>
        <!-- Appointment Time -->
        <div class="hrch"> Time:
        </div>
    </div>
    <div class="hdr">
        <!-- Slot Id -->
        <div class="hrch">
            <span>{{ $prescription->ap_id }}</span>
        </div>
        <!-- Patient Name -->
        <div class="hrch"> 
            <span>{{ $prescription->patient_name }}</span>
        </div>
        <!-- Doctor Name -->
        <div class="hrch">
            <span>{{ $prescription->doctor_name }}</span>
        </div>
        <!-- Appointment Date -->
        <div class="hrch">
            <span>{{ \Carbon\Carbon::parse($prescription->ap_date)->format('d/m/Y') }}</span>
        </div>
        <!-- Appointment Time -->
        <div class="hrch">
            <span>{{ \Carbon\Carbon::parse($prescription->ap_strTime)->format('h:i A') }}</span>
        </div>
    </div>

    <!-- Prescription Title -->
    <div class="title">
        <p><strong>PRESCRIPTION</strong></p>
    </div>
    <!-- Prescription Description -->
    <div class="prescription">
        <!-- Creates a div container with the class 'prescription' to style and group the prescription content -->
    
        
    
        @php
            // Splitting the content by lines
            // Using the explode function to break the prescription description text into an array of lines based on newline characters
            // This allows us to handle each line of the prescription individually in the loop below
            $lines = explode("\n", $prescription->pr_desc);
        @endphp
    
        @foreach ($lines as $line)
            <!-- Begin a loop to iterate over each line in the $lines array -->
            <!-- Each line is processed one by one, with the current line stored in the $line variable -->
    
                <!-- If the line does not start with '##' or '**', it is treated as a regular paragraph -->
                <!-- The line is wrapped in a paragraph (<p>) tag without any modification -->
                <p class="prln">{{ $line }}</p>
            
    
        @endforeach
      
    </div>
    
</div>


@endsection
