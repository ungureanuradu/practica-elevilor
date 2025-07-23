<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('now', '+30 days');
    
        return [
            'title'       => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'start_at'    => $start,
            'end_at'      => (clone $start)->modify('+2 hours'),
            'location'    => fake()->city(),
            'user_id'     => \App\Models\User::factory(),
        ];
    }
    
}
