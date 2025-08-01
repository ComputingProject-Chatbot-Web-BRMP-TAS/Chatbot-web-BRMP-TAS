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
        Schema::create('product_histories', function (Blueprint $table) {
            $table->id('history_id');
            $table->foreignId('product_id')->nullable()->constrained('products', 'product_id')->nullonDelete();
        
            // Data snapshot
            $table->string('plant_type_name');
            $table->string('product_name');
            $table->text('description');
            $table->decimal('stock');
            $table->decimal('minimum_stock');
            $table->string('unit');
            $table->integer('price_per_unit');
            $table->decimal('minimum_purchase');
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image_certificate')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('certificate_class')->nullable(); 
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamp('recorded_at'); // waktu perubahan disimpan
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_histories');
    }
};
