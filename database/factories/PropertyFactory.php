<?php

namespace Database\Factories;

use App\Enums\Availability;
use App\Enums\Condition;
use App\Enums\PropertyStatus;
use App\Models\Category;
use App\Models\Location;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Luxury Villa with Pool',
            'Modern Apartment in City Center',
            'Cozy Family House',
            'Penthouse with Mountain View',
            'Charming Cottage',
            'Spacious Duplex',
            'Studio Apartment',
            'Historic Townhouse',
            'Contemporary Loft',
            'Lakeside Chalet',
        ]).' - '.fake()->city();

        $location = Location::inRandomOrder()->first();
        $lat = fake()->latitude(45, 48);
        $lon = fake()->longitude(6, 10);

        return [
            'user_id' => User::where('role', 'provider')->inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1000, 9999),
            'address' => fake()->streetAddress().', '.$location->city,
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomElement([
                fake()->numberBetween(250000, 500000),
                fake()->numberBetween(500000, 1000000),
                fake()->numberBetween(1000000, 2000000),
                fake()->numberBetween(2000000, 5000000),
            ]),
            'rooms' => fake()->randomElement([1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 6]),
            'location_id' => $location->id,
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'status' => fake()->randomElement([
                PropertyStatus::Approved,
                PropertyStatus::Approved,
                PropertyStatus::Approved,
                PropertyStatus::Pending,
            ]),
            'condition' => fake()->randomElement(Condition::cases()),
            'property_type' => fake()->randomElement([
                'Apartment',
                'House',
                'Villa',
                'Duplex',
                'Penthouse',
                'Studio',
                'Loft',
                'Cottage',
                'Chalet',
            ]),
            'availability' => fake()->randomElement(Availability::cases()),
            'floor' => fake()->optional(0.7)->numberBetween(0, 15),
            'living_area' => fake()->numberBetween(40, 300),
            'plot_size' => fake()->optional(0.5)->numberBetween(100, 1500),
            'construction_year' => fake()->optional(0.8)->numberBetween(1950, 2024),
            'last_renovation' => fake()->optional(0.4)->numberBetween(2000, 2024),
            'immocode' => fake()->optional(0.6)->bothify('IMM-####-???'),
            'property_number' => fake()->optional(0.6)->bothify('PROP-#####'),
            'latitude' => $lat,
            'longitude' => $lon,
            'maps' => [
                'lat' => $lat,
                'lng' => $lon,
            ],
        ];
    }

    /**
     * Indicate that the property is in draft status.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Draft,
        ]);
    }

    /**
     * Indicate that the property is pending approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Pending,
        ]);
    }

    /**
     * Indicate that the property is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Approved,
        ]);
    }

    /**
     * Indicate that the property is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Rejected,
            'rejection_notes' => fake()->sentence(),
        ]);
    }
}
