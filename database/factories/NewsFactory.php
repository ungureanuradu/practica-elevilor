<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'        => fake()->sentence(),
            'excerpt'      => fake()->paragraph(),
            'body'         => fake()->paragraphs(4, true),
            'user_id'      => \App\Models\User::factory(),
            'published_at' => now()->subDays(rand(0, 10)),
        ];
    }
    
}
