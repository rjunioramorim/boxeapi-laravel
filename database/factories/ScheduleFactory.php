<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => 'Aula de boxe',
            'professor' => 'Prof: India',
            'day_of_week' => random_int(0, 6),
            'hour' => '17:00',
            'limit' => 12,
            'active' => true,
            // 'event_date' => null,
        ];
    }
}
