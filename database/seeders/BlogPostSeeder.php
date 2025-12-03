<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 15 published blog posts
        BlogPost::factory(15)->published()->create();

        // Create 5 draft blog posts
        BlogPost::factory(5)->draft()->create();
    }
}
