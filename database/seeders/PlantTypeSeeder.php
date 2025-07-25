<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlantTypes;

class PlantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlantTypes::insert([
            [
                'plant_type_name' => 'Tembakau',
                'comodity' => 'Tanaman Tembakau',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plant_type_name' => 'Kapas',
                'comodity' => 'Tanaman Serat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plant_type_name' => 'Wijen',
                'comodity' => 'Tanaman Minyak Industri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'plant_type_name' => 'Rosela Herbal',
            //     'comodity' => 'Tanaman ...',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            [
                'plant_type_name' => 'Kenaf',
                'comodity' => 'Tanaman Serat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plant_type_name' => 'Jarak Kepyar',
                'comodity' => 'Tanaman Minyak Industri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plant_type_name' => 'Tebu',
                'comodity' => 'Tanaman Pemanis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plant_type_name' => 'Abaka',
                'comodity' => 'Tanaman Serat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plant_type_name' => 'Rami',
                'comodity' => 'Tanaman Serat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
