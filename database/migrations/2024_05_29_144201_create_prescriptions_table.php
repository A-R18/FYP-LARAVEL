<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id('pr_id');
            $table->text('pr_desc');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id'); 
            $table->timestamps();
    
            // Foreign key constraints for prescription table
            $table->foreign('doctor_id')->references('users_id')->on('doctors')->onDelete('cascade');
            $table->foreign('patient_id')->references('users_id')->on('patients')->onDelete('cascade');
            $table->foreign('appointment_id')->references('ap_id')->on('appointments')->onDelete('cascade');
    
            // Unique index to enforce one prescription per doctor per appointment
            $table->unique(['doctor_id', 'patient_id', 'appointment_id']);
        });
    }


    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
