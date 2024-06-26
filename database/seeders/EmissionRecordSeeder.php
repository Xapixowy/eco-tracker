<?php

namespace Database\Seeders;

use App\Models\EmissionRecord;
use App\Models\Home;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class EmissionRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emissionRecords = [
            [
                'sourcable_type' => Vehicle::class,
                'sourcable_id' => 1,
                'fuel_type_id' => 1,
                'fuel_consumption' => 10,
                'co2_emmision' => 26.8,
                'start_at' => '2024-06-01 12:00:00',
                'end_at' => '2024-06-02 12:00:00',
            ],
            [
                'sourcable_type' => Vehicle::class,
                'sourcable_id' => 2,
                'fuel_type_id' => 2,
                'fuel_consumption' => 10,
                'co2_emmision' => 23,
                'start_at' => '2024-06-03 12:00:00',
                'end_at' => '2024-06-04 12:00:00',
            ],
            [
                'sourcable_type' => Vehicle::class,
                'sourcable_id' => 3,
                'fuel_type_id' => 3,
                'fuel_consumption' => 10,
                'co2_emmision' => 8.24,
                'start_at' => '2024-06-05 12:00:00',
                'end_at' => '2024-06-06 12:00:00',
            ],
            [
                'sourcable_type' => Vehicle::class,
                'sourcable_id' => 4,
                'fuel_type_id' => 4,
                'fuel_consumption' => 10,
                'co2_emmision' => 18.8,
                'start_at' => '2024-06-07 12:00:00',
                'end_at' => '2024-06-08 12:00:00',
            ],
            [
                'sourcable_type' => Home::class,
                'sourcable_id' => 1,
                'fuel_type_id' => 3,
                'fuel_consumption' => 100,
                'co2_emmision' => 82.4,
                'start_at' => '2024-06-01 12:00:00',
                'end_at' => '2024-06-02 12:00:00',
            ],
            [
                'sourcable_type' => Home::class,
                'sourcable_id' => 1,
                'fuel_type_id' => 4,
                'fuel_consumption' => 100,
                'co2_emmision' => 188,
                'start_at' => '2024-06-03 12:00:00',
                'end_at' => '2024-06-04 12:00:00',
            ],
        ];

        foreach ($emissionRecords as $emissionRecord) {
            EmissionRecord::create($emissionRecord);
        }
    }
}
