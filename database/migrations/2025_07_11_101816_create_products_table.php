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
            $table->id('produk_id');
            $table->string('nama');
            $table->enum('jenis_kategori', ['Tanaman Pemanis', 'Tanaman Serat', 'Tanaman Tembakau', 'Tanaman Minyak Industri']);
            $table->text('deskripsi');
            $table->decimal('stok');
            $table->decimal('stok_minimal');
            $table->string('satuan');
            $table->integer('harga_per_satuan');
            $table->string('gambar1');
            $table->string('gambar2');
            $table->string('gambar_certificate');

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
