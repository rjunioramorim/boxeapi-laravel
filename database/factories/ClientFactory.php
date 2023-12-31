<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plan_id' => rand(1, 2),
            'user_id' => User::factory(),
            'phone' => fake()->phoneNumber(),
            'due_date' => random_int(1, 30),
            'verified_at' => null,
            'blocked_at' => null,
        ];
    }
}
