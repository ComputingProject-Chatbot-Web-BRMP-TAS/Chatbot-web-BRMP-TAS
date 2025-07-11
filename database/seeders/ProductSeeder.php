<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'nama' => 'Benih Cabai Rawit',
                'jenis_kategori' => 'Rempah-Rempah/Herbal',
                'deskripsi' => 'Isi 50 butir, cocok untuk pekarangan rumah.',
                'jumlah_biji' => 50,
                'harga' => 15000,
                'gambar' => 'cabai_rawit.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Benih Tomat',
                'jenis_kategori' => 'Sayuran',
                'deskripsi' => 'Benih tomat unggul, cocok untuk dataran rendah.',
                'jumlah_biji' => 30,
                'harga' => 12000,
                'gambar' => 'tomat.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Benih Melon',
                'jenis_kategori' => 'Buah-Buahan',
                'deskripsi' => 'Benih melon manis, isi 20 butir.',
                'jumlah_biji' => 20,
                'harga' => 20000,
                'gambar' => 'melon.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Benih Mawar Merah',
                'jenis_kategori' => 'Bunga',
                'deskripsi' => 'Benih mawar merah, cocok untuk taman.',
                'jumlah_biji' => 10,
                'harga' => 25000,
                'gambar' => 'mawar_merah.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Benih Pohon Mangga',
                'jenis_kategori' => 'Tumbuhan',
                'deskripsi' => 'Benih pohon mangga, tumbuh cepat.',
                'jumlah_biji' => 5,
                'harga' => 30000,
                'gambar' => 'mangga.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
