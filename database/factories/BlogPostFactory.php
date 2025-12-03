<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Top 10 Tips for First-Time Home Buyers',
            'Understanding the Swiss Real Estate Market',
            'How to Stage Your Home for a Quick Sale',
            'Investment Properties: What You Need to Know',
            'The Ultimate Guide to Property Valuation',
            'Navigating Property Taxes in Switzerland',
            'Eco-Friendly Homes: The Future of Real Estate',
            'Rental vs. Buying: Making the Right Choice',
            'Luxury Real Estate Trends in 2024',
            'How to Find the Perfect Neighborhood',
            'Renovating Your Property: Tips and Tricks',
            'Understanding Mortgage Options in Switzerland',
            'The Benefits of Working with a Real Estate Agent',
            'Commercial Real Estate Investment Guide',
            'Smart Home Technology in Modern Properties',
        ]);

        $publishedAt = fake()->boolean(70) ? fake()->dateTimeBetween('-6 months', 'now') : null;

        return [
            'user_id' => User::where('role', 'admin')->inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 999),
            'content' => $this->generateContent(),
            'image' => 'https://picsum.photos/1200/600?random='.fake()->unique()->numberBetween(1, 1000),
            'published_at' => $publishedAt,
        ];
    }

    /**
     * Generate realistic blog content
     */
    private function generateContent(): string
    {
        $paragraphs = [];

        // Introduction
        $paragraphs[] = fake()->paragraphs(2, true);

        // Main content sections
        for ($i = 0; $i < rand(3, 5); $i++) {
            $paragraphs[] = '## '.fake()->sentence();
            $paragraphs[] = fake()->paragraphs(rand(2, 3), true);
        }

        // Conclusion
        $paragraphs[] = '## Conclusion';
        $paragraphs[] = fake()->paragraph();

        return implode("\n\n", $paragraphs);
    }

    /**
     * Indicate that the blog post is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the blog post is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }
}
