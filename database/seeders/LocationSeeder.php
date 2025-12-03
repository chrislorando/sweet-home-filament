<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'city' => 'Zürich',
                'region' => 'Zürich',
                'country' => 'Switzerland',
                'postal_code' => '8001',
            ],
            [
                'city' => 'Geneva',
                'region' => 'Geneva',
                'country' => 'Switzerland',
                'postal_code' => '1201',
            ],
            [
                'city' => 'Basel',
                'region' => 'Basel-Stadt',
                'country' => 'Switzerland',
                'postal_code' => '4001',
            ],
            [
                'city' => 'Bern',
                'region' => 'Bern',
                'country' => 'Switzerland',
                'postal_code' => '3011',
            ],
            [
                'city' => 'Lausanne',
                'region' => 'Vaud',
                'country' => 'Switzerland',
                'postal_code' => '1003',
            ],
            [
                'city' => 'Lucerne',
                'region' => 'Lucerne',
                'country' => 'Switzerland',
                'postal_code' => '6003',
            ],
            [
                'city' => 'St. Gallen',
                'region' => 'St. Gallen',
                'country' => 'Switzerland',
                'postal_code' => '9000',
            ],
            [
                'city' => 'Lugano',
                'region' => 'Ticino',
                'country' => 'Switzerland',
                'postal_code' => '6900',
            ],
            [
                'city' => 'Winterthur',
                'region' => 'Zürich',
                'country' => 'Switzerland',
                'postal_code' => '8400',
            ],
            [
                'city' => 'Zug',
                'region' => 'Zug',
                'country' => 'Switzerland',
                'postal_code' => '6300',
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
