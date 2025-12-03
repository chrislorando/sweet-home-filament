<?php

namespace Database\Factories;

use App\Models\ContactSubmission;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactSubmission>
 */
class ContactSubmissionFactory extends Factory
{
    protected $model = ContactSubmission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::inRandomOrder()->first()?->id ?? Property::factory(),
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'address' => fake()->streetAddress(),
            'postcode' => fake()->postcode(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'message' => fake()->randomElement([
                'I am interested in this property. Could you please provide more information?',
                'I would like to schedule a viewing for this property.',
                'What is the availability for a visit? I am very interested.',
                'Could you send me more details about the property specifications?',
                'I am looking to purchase/rent soon. Is this property still available?',
                'Can we arrange a viewing this week? I am very interested in this listing.',
                'I have some questions about the property. Could you contact me?',
                'Is there any flexibility on the price? I am a serious buyer.',
                'I would like to know more about the neighborhood and amenities.',
                'Could you provide information about the mortgage options?',
            ]),
        ];
    }
}
