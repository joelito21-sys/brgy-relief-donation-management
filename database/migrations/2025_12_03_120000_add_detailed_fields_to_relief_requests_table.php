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
        Schema::table('relief_requests', function (Blueprint $table) {
            $table->string('full_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email_address')->nullable();
            $table->string('id_number')->nullable();
            $table->text('complete_address')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->integer('household_size')->nullable();
            $table->string('urgency_level')->nullable();
            $table->json('assistance_types')->nullable();
            $table->text('description')->nullable();
            $table->integer('children_count')->nullable()->default(0);
            $table->integer('elderly_count')->nullable()->default(0);
            $table->integer('pwd_count')->nullable()->default(0);
            $table->integer('pregnant_count')->nullable()->default(0);
            $table->text('additional_message')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->timestamp('submitted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relief_requests', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'contact_number',
                'email_address',
                'id_number',
                'complete_address',
                'city_municipality',
                'province',
                'postal_code',
                'household_size',
                'urgency_level',
                'assistance_types',
                'description',
                'children_count',
                'elderly_count',
                'pwd_count',
                'pregnant_count',
                'additional_message',
                'emergency_contact_name',
                'emergency_contact_phone',
                'submitted_at',
            ]);
        });
    }
};
