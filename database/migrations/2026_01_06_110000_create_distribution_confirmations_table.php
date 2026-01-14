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
        Schema::create('distribution_confirmations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('distribution_notification_id');
            $table->unsignedBigInteger('resident_id');
            $table->string('qr_code', 64)->unique();
            $table->timestamp('confirmed_at')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('distribution_notification_id');
            $table->index('resident_id');
            $table->index('confirmed_by');
            
            // Each resident can only have one confirmation per notification
            $table->unique(['distribution_notification_id', 'resident_id'], 'dist_conf_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_confirmations');
    }
};
