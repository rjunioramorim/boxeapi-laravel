<?php

namespace Database\Factories;

use App\Enums\ScheduleType;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Checkin>
 */
class CheckinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'schedule_id' => '',
            'type' => 'schedule',
            'checkin_date' => now()->format('Y-m-d'),
            'hour' => '07:00',
            'status' => ScheduleType::SCHEDULED->value,
        ];
    }
}
