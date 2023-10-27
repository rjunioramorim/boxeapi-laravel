<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->colorName().fake()->randomDigitNotZero(),
            'price' => fake()->randomFloat(2, 10, 100),
            'active' => true,
            'qtd_days' => random_int(1, 5),
        ];
    }
}
