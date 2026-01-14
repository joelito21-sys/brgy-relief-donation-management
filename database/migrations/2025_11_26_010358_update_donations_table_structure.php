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
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'reference_number')) {
                $table->string('reference_number')->nullable()->after('payment_method');
            }
            
            if (!Schema::hasColumn('donations', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('reference_number');
            }
            
            if (!Schema::hasColumn('donations', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_reference');
            }
            
            if (!Schema::hasColumn('donations', 'payment_details')) {
                $table->json('payment_details')->nullable()->after('paid_at');
            }
            
            if (!Schema::hasColumn('donations', 'status')) {
                $table->string('status')->default('pending')->after('payment_details');
            }
            
            if (!Schema::hasColumn('donations', 'receipt_path')) {
                $table->string('receipt_path')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to drop columns in case they're being used
        // This is a safety measure to prevent data loss
    }
};
