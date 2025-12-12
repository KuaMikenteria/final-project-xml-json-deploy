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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            // Personal Information
            $table->string('name');
            $table->string('email');
            $table->string('phone_number'); // Philippine format: 09XXXXXXXXX
            $table->string('municipality_city');
            $table->string('country');
            // Booking Information
            $table->string('resort');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('number_of_guests');
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
