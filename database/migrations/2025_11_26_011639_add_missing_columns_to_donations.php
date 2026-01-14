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
        // Only add columns that don't exist
        Schema::table('donations', function (Blueprint $table) {
            // Check and add status column if it doesn't exist
            if (!Schema::hasColumn('donations', 'status')) {
                $table->string('status')->default('pending')->after('payment_details');
            }
            
            // Check and add receipt_path column if it doesn't exist
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
        Schema::table('donations', function (Blueprint $table) {
            //
        });
    }
};
