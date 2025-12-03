<?php

namespace Database\Seeders;

use App\Models\Characteristic;
use Illuminate\Database\Seeder;

class CharacteristicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $characteristics = [
            'Balcony/Terrace/Patio',
            'Cable TV',
            'Cellar',
            'Child friendly',
            'Fibre-optic connection',
            'Fireplace',
            'Garage',
            'Hobby room',
            'Parking space',
            'Personal lift',
            'Storage room',
            'View',
            'Wheelchair access',
        ];

        foreach ($characteristics as $name) {
            Characteristic::create([
                'name' => $name,
                'type' => 'boolean', // Default type as required by schema
                'options' => null,
            ]);
        }
    }
}
