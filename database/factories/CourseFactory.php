<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);
        
        return [
            'title' => $title,
            'description' => fake()->paragraphs(3, true),
            'excerpt' => fake()->sentence(10),
            'slug' => Str::slug($title),
            'level' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'status' => fake()->randomElement(['draft', 'published']),
            'duration_hours' => fake()->numberBetween(2, 40),
            'max_students' => fake()->optional()->numberBetween(10, 100),
            'price' => fake()->randomFloat(2, 0, 500),
            'is_free' => fake()->boolean(70), // 70% chance of being free
            'tags' => fake()->randomElements(['PHP', 'Laravel', 'Vue.js', 'JavaScript', 'CSS', 'HTML', 'Database', 'API', 'React', 'Node.js', 'Python', 'Java'], fake()->numberBetween(2, 5)),
            'requirements' => [
                'Cunoștințe de bază în programare',
                'Experiență cu HTML și CSS',
                'Motivație pentru învățare'
            ],
            'learning_outcomes' => [
                'Vei învăța să construiești aplicații web moderne',
                'Vei înțelege conceptele fundamentale ale framework-ului',
                'Vei putea dezvolta proiecte practice'
            ],
            'instructor_id' => null, // Will be set in seeder
            'published_at' => fake()->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that the course is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    /**
     * Indicate that the course is free.
     */
    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_free' => true,
            'price' => 0,
        ]);
    }

    /**
     * Indicate that the course is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_free' => false,
            'price' => fake()->randomFloat(2, 50, 500),
        ]);
    }

    /**
     * Indicate that the course is for beginners.
     */
    public function beginner(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'beginner',
        ]);
    }

    /**
     * Indicate that the course is for intermediate users.
     */
    public function intermediate(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'intermediate',
        ]);
    }

    /**
     * Indicate that the course is for advanced users.
     */
    public function advanced(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'advanced',
        ]);
    }
}
