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
            // Add the donor_id column as nullable first (in case there are existing records)
            $table->foreignId('donor_id')->nullable()->after('id');
        });

        // Add foreign key constraint in a separate statement to avoid issues
        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('donor_id')
                  ->references('id')
                  ->on('donors')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['donor_id']);
            // Then drop the column
            $table->dropColumn('donor_id');
        });
    }
};
