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
            $table->enum('jenis_kategori', ['Tumbuhan', 'Rempah-Rempah/Herbal', 'Buah-Buahan', 'Sayuran', 'Bunga']);
            $table->text('deskripsi');
            $table->integer('jumlah_biji');
            $table->string('berat_bersih')->nullable();
            $table->integer('harga');
            $table->string('gambar');
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
