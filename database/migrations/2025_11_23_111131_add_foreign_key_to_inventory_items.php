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
        // First, make sure the categories table exists
        if (Schema::hasTable('inventory_categories') && Schema::hasTable('inventory_items')) {
            Schema::table('inventory_items', function (Blueprint $table) {
                // Check if the column already exists before adding it
                if (!Schema::hasColumn('inventory_items', 'category_id')) {
                    $table->unsignedBigInteger('category_id')->nullable()->after('unit_measure');
                }
                
                // Add the foreign key constraint
                $table->foreign('category_id')
                    ->references('id')
                    ->on('inventory_categories')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
};
