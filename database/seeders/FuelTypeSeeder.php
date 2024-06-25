<?php

namespace Database\Seeders;

use App\Models\FuelType;
use Illuminate\Database\Seeder;

class FuelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuelTypes = [
            [
                'name' => 'Diesel',
                'consumption_unit' => 'Litre',
                'price_per_unit' => 6.5,
            ],
            [
                'name' => 'Gasoline',
                'consumption_unit' => 'Litre',
                'price_per_unit' => 6.53,
            ],
            [
                'name' => 'Electricity',
                'consumption_unit' => 'kWh',
                'price_per_unit' => 0.32,
            ],
            [
                'name' => 'Natural Gas',
                'consumption_unit' => 'm3',
                'price_per_unit' => 1.26,
            ]
        ];

        foreach ($fuelTypes as $fuelType) {
            if (!FuelType::where('name', $fuelType['name'])->exists()) {
                FuelType::create($fuelType);
            }
        }
    }
}
