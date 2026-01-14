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
            $table->string('reference_number')->nullable()->after('payment_method');
            $table->string('payment_reference')->nullable()->after('reference_number');
            $table->timestamp('paid_at')->nullable()->after('payment_reference');
            $table->json('payment_details')->nullable()->after('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn([
                'reference_number',
                'payment_reference',
                'paid_at',
                'payment_details'
            ]);
        });
    }
};
