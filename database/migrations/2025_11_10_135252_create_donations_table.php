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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // cash, food, clothing, medicine
            
            // Common fields for all donation types
            $table->string('status')->default('pending'); // pending, received, in_distribution, completed, cancelled
            $table->text('message')->nullable();
            $table->string('donor_name');
            $table->string('donor_email');
            $table->string('donor_phone');
            $table->text('donor_address');
            $table->string('delivery_method'); // pickup, pickup_arranged
            $table->date('pickup_date')->nullable();
            $table->string('pickup_time')->nullable(); // morning, afternoon
            $table->text('pickup_address')->nullable();
            
            // Cash donation fields
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('payment_method')->nullable(); // gcash, paymaya, bank_transfer
            $table->string('receipt_path')->nullable();
            $table->string('donation_frequency')->nullable(); // one_time, monthly, quarterly
            
            // Food donation fields
            $table->string('food_type')->nullable(); // non_perishable, perishable
            $table->string('food_name')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable(); // kg, g, pieces, packs, boxes
            $table->date('expiry_date')->nullable();
            $table->text('food_description')->nullable();
            
            // Clothing donation fields
            $table->json('clothing_types')->nullable(); // shirts, pants, jackets, etc.
            $table->string('other_clothing_type')->nullable();
            $table->string('gender')->nullable(); // unisex, men, women, children
            $table->string('size')->nullable(); // xs, s, m, l, xl, xxl, xxxl, child
            $table->string('condition')->nullable(); // new, excellent, good, fair
            $table->json('photo_paths')->nullable();
            
            // Medicine donation fields
            $table->string('medicine_type')->nullable(); // prescription, otc
            $table->string('medicine_name')->nullable();
            $table->string('dosage')->nullable();
            $table->string('form')->nullable(); // tablet, capsule, syrup, etc.
            $table->string('other_form')->nullable();
            $table->string('prescription_path')->nullable();
            
            // Timestamps
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
