<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('dtspez', 30);
            $table->string('dtimg');
            $table->time('strtime');
            $table->time('endtime');
            $table->enum( 'status',['available', 'unavailable']);
            $table->unsignedInteger('dt_fee'); //  Doctor's fee field
            $table->unsignedBigInteger('users_id');     
            $table->foreign('users_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
