<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true),
            'description' => fake()->sentence,
            'event_date' => fake()->date(),
            'hour' => fake()->time('H:i'),
            'image_url' => fake()->imageUrl(),
            'limit' => random_int(1, 20),
            'price' => fake()->randomFloat(2, 10, 100),
        ];
    }
}
