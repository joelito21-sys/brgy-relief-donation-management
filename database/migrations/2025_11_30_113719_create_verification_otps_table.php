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
        Schema::create('verification_otps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_type'); // user, resident, donor, admin
            $table->string('otp'); // hashed OTP
            $table->timestamp('expires_at');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'user_type']);
            $table->index('expires_at');
            
            // Unique constraint to prevent multiple active OTPs per user
            $table->unique(['user_id', 'user_type'], 'unique_user_otp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_otps');
    }
};
