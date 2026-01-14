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
            // Check and add reference_number if it doesn't exist
            if (!Schema::hasColumn('donations', 'reference_number')) {
                $table->string('reference_number')->nullable()->after('payment_method');
                echo "Added reference_number column\n";
            } else {
                echo "reference_number column already exists\n";
            }
            
            // Check and add payment_reference if it doesn't exist
            if (!Schema::hasColumn('donations', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('reference_number');
                echo "Added payment_reference column\n";
            } else {
                echo "payment_reference column already exists\n";
            }
            
            // Check and add paid_at if it doesn't exist
            if (!Schema::hasColumn('donations', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_reference');
                echo "Added paid_at column\n";
            } else {
                echo "paid_at column already exists\n";
            }
            
            // Check and add payment_details if it doesn't exist
            if (!Schema::hasColumn('donations', 'payment_details')) {
                $table->json('payment_details')->nullable()->after('paid_at');
                echo "Added payment_details column\n";
            } else {
                echo "payment_details column already exists\n";
            }
            
            // Check and add status if it doesn't exist
            if (!Schema::hasColumn('donations', 'status')) {
                $table->string('status')->default('pending')->after('payment_details');
                echo "Added status column\n";
            } else {
                echo "status column already exists\n";
            }
            
            // Check and add receipt_path if it doesn't exist
            if (!Schema::hasColumn('donations', 'receipt_path')) {
                $table->string('receipt_path')->nullable()->after('status');
                echo "Added receipt_path column\n";
            } else {
                echo "receipt_path column already exists\n";
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We're not dropping any columns in the down method to prevent data loss
        // This is a safety measure to ensure we don't accidentally remove columns that might be in use
    }
};
