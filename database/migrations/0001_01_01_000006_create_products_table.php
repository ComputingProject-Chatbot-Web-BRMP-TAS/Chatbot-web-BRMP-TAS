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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->foreignId('plant_type_id')->constrained('plant_types', 'plant_type_id')->onDelete('cascade');
            $table->string('product_name');
            $table->text('description');
            $table->decimal('stock');
            $table->decimal('minimum_stock');
            $table->string('unit');
            $table->integer('price_per_unit');
            $table->decimal('minimum_purchase')->default(0);
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image_certificate')->nullable();
            $table->string('certificate_number')->nullable();
            $table->enum('certificate_class', ['Penjenis', 'Dasar', 'Pokok', 'Sebar'])->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
