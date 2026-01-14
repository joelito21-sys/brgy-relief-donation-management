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
        Schema::create('relief_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('relief_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('relief_item_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['relief_request_id', 'relief_item_id']);
            $table->index('relief_request_id');
            $table->index('relief_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relief_request_items');
    }
};
