<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('alerts')) {
            // Get the table prefix
            $prefix = DB::getTablePrefix();
            
            // Check and drop foreign keys if they exist
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME 
                FROM information_schema.TABLE_CONSTRAINTS 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'alerts' 
                AND CONSTRAINT_TYPE = 'FOREIGN KEY'"
            );
            
            foreach ($foreignKeys as $key) {
                $constraintName = $key->CONSTRAINT_NAME;
                DB::statement("ALTER TABLE `alerts` DROP FOREIGN KEY `$constraintName`");
            }
            
            // Then drop the table
            Schema::dropIfExists('alerts');
        }
    }

    public function down()
    {
        // This is a cleanup migration, so we don't need to implement down()
    }
};
