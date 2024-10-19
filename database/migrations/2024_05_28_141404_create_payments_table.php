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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('py_id');
            $table->string('uname', 30);
            $table->string('slot_id', 10);
            $table->string('acc_no', 15);
            $table->string('amount', 6);
            $table->unsignedBigInteger('users_id'); // Foreign key to users table
            $table->enum('pym_status', ['unchecked', 'checked'])->default('unchecked');


            // $table->unsignedBigInteger('users_id');
            // $table->foreign('users_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('restrict');

             // Foreign Key Constraint
             $table->foreign('users_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();

             // Unique index to enforce one payment per appointment
             $table->unique(['users_id', 'slot_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
