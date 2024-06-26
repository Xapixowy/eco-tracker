<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            [
                'street' => 'Ul. Jana Pawła II',
                'building' => '1',
                'apartment' => '1',
                'zip_code' => '02-600',
                'city' => 'Warsaw',
                'voivodeship' => 'Masovian',
            ],
        ];

        foreach ($addresses as $address) {
            if (!Address::where('street', $address['street'])->where('building', $address['building'])->where('apartment', $address['apartment'])->where('zip_code', $address['zip_code'])->where('city', $address['city'])->where('voivodeship', $address['voivodeship'])->exists()) {
                Address::create($address);
            }
        }
    }
}
