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
        Schema::table('donors', function (Blueprint $table) {
            // Make phone nullable if it's not already
            $table->string('phone')->nullable()->change();
            
            // Drop unnecessary columns if they exist
            if (Schema::hasColumn('donors', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('donors', 'blood_group')) {
                $table->dropColumn('blood_group');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: This is a simplified rollback. In a production environment, 
        // you might want to restore the original structure with data
        Schema::table('donors', function (Blueprint $table) {
            // Add back the columns if needed
            if (!Schema::hasColumn('donors', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('donors', 'blood_group')) {
                $table->string('blood_group')->nullable();
            }
        });
    }
};
