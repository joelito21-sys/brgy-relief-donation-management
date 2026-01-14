<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Make sure the areas table exists
        if (!Schema::hasTable('areas')) {
            throw new \RuntimeException('The areas table must exist before creating the alerts table.');
        }

        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['info', 'warning', 'danger', 'success', 'primary'])->default('info');
            $table->enum('status', ['draft', 'active', 'inactive', 'expired'])->default('draft');
            
            // Area relationship
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')
                  ->references('id')
                  ->on('areas')
                  ->onDelete('set null');
            
            // Created by user
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
            $table->dropForeign(['created_by']);
        });
        
        Schema::dropIfExists('alerts');
    }
};
