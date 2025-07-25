<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\PlantTypes;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'product_name' => 'Benih Tebu Manis',
                'plant_type_id' => 6, 
                'description' => 'Benih tebu manis unggul, cocok untuk lahan tropis.',
                'minimum_stock' => 10,
                'stock' => 100,
                'unit' => 'Mata',
                'price_per_unit' => 25000,
                'minimum_purchase' => 5,
                'image1' => 'default.jpg',
                'image2' => 'default2.jpg',
                'image_certificate' => 'default_cert.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Benih Kapas',
                'plant_type_id' => 2, 
                'description' => 'Benih kapas berkualitas untuk industri tekstil.',
                'minimum_stock' => 5,
                'stock' => 80,
                'unit' => 'Kg',
                'price_per_unit' => 20000,
                'minimum_purchase' => 2,
                'image1' => 'default.jpg',
                'image2' => 'default2.jpg',
                'image_certificate' => 'default_cert.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Benih Tembakau Lokal',
                'plant_type_id' => 1, 
                'description' => 'Benih tembakau lokal, cocok untuk dataran rendah.',
                'minimum_stock' => 8,
                'stock' => 60,
                'unit' => 'Kg',
                'price_per_unit' => 30000,
                'minimum_purchase' => 1,
                'image1' => 'default.jpg',
                'image2' => 'default2.jpg',
                'image_certificate' => 'default_cert.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Benih Kelapa Sawit',
                'plant_type_id' => 5, 
                'description' => 'Benih kelapa sawit unggul untuk produksi minyak.',
                'minimum_stock' => 3,
                'stock' => 40,
                'unit' => 'Kg',
                'price_per_unit' => 50000,
                'minimum_purchase' => 1,
                'image1' => 'default.jpg',
                'image2' => 'default2.jpg',
                'image_certificate' => 'default_cert.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
