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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('shipping_address_id')->constrained('addresses', 'address_id')->onDelete('cascade');
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->text('shipping_address');
            $table->text('shipping_note')->nullable();
            $table->text('purchase_purpose')->nullable();
            $table->string('province_id')->nullable();
            $table->string('regency_id')->nullable();
            $table->integer('total_price');
            $table->string('order_status');
            $table->string('delivery_method');
            $table->dateTime('order_date');
            $table->dateTime('estimated_delivery_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}; 