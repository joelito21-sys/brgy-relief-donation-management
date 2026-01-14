<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();

            // Basic identity
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');

            // Contact & address
            $table->string('phone');
            $table->string('address');
            $table->string('barangay');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code')->nullable();

            // ID information
            $table->string('id_number')->unique();
            $table->string('id_type');

            // Emergency contact
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
