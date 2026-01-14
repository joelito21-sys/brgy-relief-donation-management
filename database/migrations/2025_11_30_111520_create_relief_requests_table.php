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
        Schema::create('relief_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('resident_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->string('request_number')->unique();
            $table->text('reason');
            $table->integer('family_members')->default(1);
            $table->string('status')->default('pending'); // pending, approved, rejected, ready_for_pickup, claimed, delivered
            $table->text('rejection_reason')->nullable();
            $table->string('delivery_method')->default('pickup'); // pickup, delivery
            $table->dateTime('scheduled_pickup_date')->nullable();
            $table->string('pickup_location')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('claim_code')->unique();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('ready_for_pickup_at')->nullable();
            $table->dateTime('claimed_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'created_at']);
            $table->index('user_id');
            $table->index('resident_id');
            $table->index('request_number');
            $table->index('claim_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relief_requests');
    }
};
