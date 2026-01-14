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
        if (! Schema::hasTable('verification_otps')) {
            return;
        }

        Schema::table('verification_otps', function (Blueprint $table) {
            if (! Schema::hasColumn('verification_otps', 'user_type')) {
                $table->string('user_type')->default('user')->after('user_id');
                $table->index(['user_id', 'user_type']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('verification_otps')) {
            return;
        }

        Schema::table('verification_otps', function (Blueprint $table) {
            if (Schema::hasColumn('verification_otps', 'user_type')) {
                $table->dropIndex(['user_id', 'user_type']);
                $table->dropColumn('user_type');
            }
        });
    }
};
