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
            $table->id('transaksi_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('shipping_address_id')->nullable();
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->text('shipping_address');
            $table->text('shipping_note')->nullable();
            $table->integer('total_harga');
            $table->string('status');
            $table->string('delivery_method');
            $table->dateTime('order_date')->change();
            $table->dateTime('estimated_delivery_date')->nullable()->change();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shipping_address_id')->references('id')->on('addresses')->onDelete('set null');
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