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
        $plantTypes = [
            [
                'plant_type_name' => 'Tembakau',
                'comodity' => 'Tanaman Tembakau',
            ],
            [
                'plant_type_name' => 'Kapas',
                'comodity' => 'Tanaman Serat',
            ],
            [
                'plant_type_name' => 'Wijen',
                'comodity' => 'Tanaman Minyak Industri',
            ],
            [
                'plant_type_name' => 'Kenaf',
                'comodity' => 'Tanaman Serat',
            ],
            [
                'plant_type_name' => 'Jarak Kepyar',
                'comodity' => 'Tanaman Minyak Industri',
            ],
            [
                'plant_type_name' => 'Tebu',
                'comodity' => 'Tanaman Pemanis',
            ],
            [
                'plant_type_name' => 'Abaka',
                'comodity' => 'Tanaman Serat',
            ],
            [
                'plant_type_name' => 'Rami',
                'comodity' => 'Tanaman Serat',
            ],
        ];

        foreach ($plantTypes as $plantType) {
            PlantTypes::firstOrCreate(
                ['plant_type_name' => $plantType['plant_type_name']],
                [
                    'comodity' => $plantType['comodity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
