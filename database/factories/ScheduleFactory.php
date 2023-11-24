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
            'day_of_week' => random_int(0, 6),
            'hour' => '17:00',
            'active' => true,
            'professor' => 'Prof: India',
            'description' => 'Aula de boxe',
            // 'event_date' => null,
        ];
    }
}
