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
        Schema::create('distribution_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('distribution_type'); // general, specific
            $table->unsignedBigInteger('distribution_id')->nullable();
            $table->unsignedBigInteger('relief_request_id')->nullable();
            $table->string('location');
            $table->dateTime('scheduled_date');
            $table->string('target_area')->nullable();
            $table->text('additional_info')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->dateTime('sent_at')->nullable();
            $table->unsignedBigInteger('sent_by')->nullable(); // admin who sent it
            $table->timestamps();
            
            $table->foreign('distribution_id')->references('id')->on('distributions')->onDelete('set null');
            $table->foreign('relief_request_id')->references('id')->on('relief_requests')->onDelete('set null');
            $table->foreign('sent_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_notifications');
    }
};
