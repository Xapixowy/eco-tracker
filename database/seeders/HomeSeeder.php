<?php

namespace Database\Seeders;

use App\Models\Home;
use Illuminate\Database\Seeder;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homes = [
            [
                'user_id' => 1,
                'address_id' => 1,
            ],
        ];

        foreach ($homes as $home) {
            if (!Home::where('address_id', $home['address_id'])->exists()) {
                Home::create($home);
            }
        }
    }
}
