<?php

namespace Database\Seeders;

use App\Models\Characteristic;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 30 properties
        Property::factory(30)->create()->each(function ($property) {
            // Attach random characteristics (3-8 per property)
            $characteristics = Characteristic::inRandomOrder()
                ->limit(rand(3, 8))
                ->pluck('id');

            $property->characteristics()->attach($characteristics);

            // Create 3-6 images per property
            for ($i = 0; $i < rand(3, 6); $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => 'https://picsum.photos/800/600?random='.uniqid(),
                ]);
            }
        });

        // Create some draft properties
        Property::factory(5)->draft()->create()->each(function ($property) {
            $characteristics = Characteristic::inRandomOrder()
                ->limit(rand(2, 5))
                ->pluck('id');

            $property->characteristics()->attach($characteristics);

            for ($i = 0; $i < rand(2, 4); $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => 'https://picsum.photos/800/600?random='.uniqid(),
                ]);
            }
        });

        // Create some pending properties
        Property::factory(8)->pending()->create()->each(function ($property) {
            $characteristics = Characteristic::inRandomOrder()
                ->limit(rand(3, 7))
                ->pluck('id');

            $property->characteristics()->attach($characteristics);

            for ($i = 0; $i < rand(3, 5); $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => 'https://picsum.photos/800/600?random='.uniqid(),
                ]);
            }
        });

        // Create some rejected properties
        Property::factory(3)->rejected()->create()->each(function ($property) {
            $characteristics = Characteristic::inRandomOrder()
                ->limit(rand(2, 4))
                ->pluck('id');

            $property->characteristics()->attach($characteristics);

            for ($i = 0; $i < rand(2, 3); $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => 'https://picsum.photos/800/600?random='.uniqid(),
                ]);
            }
        });
    }
}
