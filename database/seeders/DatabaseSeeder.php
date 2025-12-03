<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            LocationSeeder::class,
            CategorySeeder::class,
            CharacteristicSeeder::class,
        ]);

        // Create provider users
        User::factory(5)->create([
            'role' => 'provider',
        ]);

        // Seed properties and blog posts
        $this->call([
            PropertySeeder::class,
            BlogPostSeeder::class,
            ContactSubmissionSeeder::class,
        ]);
    }
}
