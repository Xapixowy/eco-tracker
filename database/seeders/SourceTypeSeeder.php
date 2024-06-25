<?php

namespace Database\Seeders;

use App\Models\SourceType;
use Illuminate\Database\Seeder;

class SourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourceTypes = [
            [
                'name' => 'Vehicle',
            ],
            [
                'name' => 'Home',
            ],
        ];

        foreach ($sourceTypes as $sourceType) {
            if (!SourceType::where('name', $sourceType['name'])->exists()) {
                SourceType::create($sourceType);
            }
        }
    }
}
