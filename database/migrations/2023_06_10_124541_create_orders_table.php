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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('order_no');
            $table->string('phone');
            $table->string('reference');
            $table->string('description');
            $table->string('MerchantRequestID')->unique();
            $table->string('CheckoutRequestID')->unique();
            $table->string('payment_method');
            $table->string('paid_amount');
            $table->string('booking_date');
            $table->string('status');
            $table->string('MpesaReceiptNumber')->nullable();
            $table->string('ResultDesc')->nullable();
            $table->string('TransactionDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};