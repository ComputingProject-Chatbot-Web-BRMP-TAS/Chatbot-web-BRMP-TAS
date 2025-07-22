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
            // Tanaman Pemanis
            [
                'nama' => 'Benih Tebu Manis',
                'jenis_kategori' => 'Tanaman Pemanis',
                'deskripsi' => 'Benih tebu manis unggul, cocok untuk lahan tropis.',
                'stok_minimal' => 10,
                'stok' => 100,
                'satuan' => 'pak',
                'harga_per_satuan' => 25000,
                'gambar1' => 'tebu1.jpg',
                'gambar2' => 'tebu2.jpg',
                'gambar_certificate' => 'tebu_cert.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tanaman Serat
            [
                'nama' => 'Benih Kapas',
                'jenis_kategori' => 'Tanaman Serat',
                'deskripsi' => 'Benih kapas berkualitas untuk industri tekstil.',
                'stok_minimal' => 5,
                'stok' => 80,
                'satuan' => 'pak',
                'harga_per_satuan' => 20000,
                'gambar1' => 'kapas1.jpg',
                'gambar2' => 'kapas2.jpg',
                'gambar_certificate' => 'kapas_cert.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tanaman Tembakau
            [
                'nama' => 'Benih Tembakau Lokal',
                'jenis_kategori' => 'Tanaman Tembakau',
                'deskripsi' => 'Benih tembakau lokal, cocok untuk dataran rendah.',
                'stok_minimal' => 8,
                'stok' => 60,
                'satuan' => 'pak',
                'harga_per_satuan' => 30000,
                'gambar1' => 'tembakau1.jpg',
                'gambar2' => 'tembakau2.jpg',
                'gambar_certificate' => 'tembakau_cert.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tanaman Minyak Industri
            [
                'nama' => 'Benih Kelapa Sawit',
                'jenis_kategori' => 'Tanaman Minyak Industri',
                'deskripsi' => 'Benih kelapa sawit unggul untuk produksi minyak.',
                'stok_minimal' => 3,
                'stok' => 40,
                'satuan' => 'pak',
                'harga_per_satuan' => 50000,
                'gambar1' => 'sawit1.jpg',
                'gambar2' => 'sawit2.jpg',
                'gambar_certificate' => 'sawit_cert.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
