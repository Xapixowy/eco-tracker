<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(FuelTypeSeeder::class);
        $this->call(SourceTypeSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(HomeSeeder::class);
        $this->call(EmissionRecordSeeder::class);
    }
}
