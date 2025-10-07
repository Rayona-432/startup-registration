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
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->string('startup_name'); 
            $table->string('founder_name');
            $table->string('email')->unique(); 
            $table->string('phone', 20);
            $table->string('website')->nullable(); 
            $table->string('sector'); $table->string('pitch_deck_path')->nullable(); 
            $table->enum('payment_status', ['pending','paid','failed'])->default('pending'); 
            $table->string('razorpay_order_id')->nullable(); 
            $table->string('razorpay_payment_id')->nullable(); 
            $table->string('razorpay_signature')->nullable();
            $table->integer('amount_paid')->nullable(); // amount in paise
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startups');
    }
};
