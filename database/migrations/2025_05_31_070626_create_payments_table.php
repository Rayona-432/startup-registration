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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->string('razorpay_payment_id')->unique();
        $table->string('razorpay_order_id');
        $table->string('status');
        $table->integer('amount');
        $table->string('currency');
        $table->string('email')->nullable();
        $table->string('contact')->nullable();
        $table->foreignId('startup_id')->nullable()->constrained()->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
