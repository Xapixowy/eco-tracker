<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'name' => 'Volkswagen Passat B5',
                'fuel_type_id' => 1,
                'user_id' => 1,
            ],
            [
                'name' => 'Honda Accord VII',
                'fuel_type_id' => 2,
                'user_id' => 1,
            ],
            [
                'name' => 'Tesla Model X',
                'fuel_type_id' => 3,
                'user_id' => 1,
            ],
            [
                'name' => 'Toyota Yaris III',
                'fuel_type_id' => 4,
                'user_id' => 1,
            ]
        ];

        foreach ($vehicles as $vehicle) {
            if (!Vehicle::where('name', $vehicle['name'])->exists()) {
                Vehicle::create($vehicle);
            }
        }
    }
}
