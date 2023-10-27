<?php

namespace Database\Seeders;

use App\Models\Checkin;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::factory()->create(['day_of_week' => 1, 'hour' => '05:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 1, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 1, 'hour' => '17:00', 'description' => 'Aula de Boxe Kids']);
        Schedule::factory()->create(['day_of_week' => 1, 'hour' => '18:00', 'description' => 'Aula de AeroBoxe']);
        Schedule::factory()->create(['day_of_week' => 1, 'hour' => '19:00', 'description' => 'Aula de Boxe']);

        Schedule::factory()->create(['day_of_week' => 2, 'hour' => '05:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 2, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 2, 'hour' => '17:00', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 2, 'hour' => '18:00', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 2, 'hour' => '19:00', 'description' => 'Aula de Boxe']);

        Schedule::factory()->create(['day_of_week' => 3, 'hour' => '05:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 3, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 3, 'hour' => '17:00', 'description' => 'Aula de Boxe Kids']);
        Schedule::factory()->create(['day_of_week' => 3, 'hour' => '18:00', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 3, 'hour' => '19:00', 'description' => 'Aula de Boxe']);

        Schedule::factory()->create(['day_of_week' => 4, 'hour' => '05:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 4, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 4, 'hour' => '17:00', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 4, 'hour' => '18:00', 'description' => 'Aula de Boxe']);
        Schedule::factory()->has(Checkin::factory(['hour' => '19:00', 'checkin_date' => now()->subDay(1)])->count(3))->create(['day_of_week' => 4, 'hour' => '19:00', 'description' => 'Aula de Boxe']);

        Schedule::factory()->create(['day_of_week' => 5, 'hour' => '05:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->create(['day_of_week' => 5, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        Schedule::factory()->has(Checkin::factory(['hour' => '17:00'])->count(1))->create(['day_of_week' => 5, 'hour' => '17:00', 'description' => 'Aula de Boxe Kids']);
        Schedule::factory()->has(Checkin::factory(['hour' => '18:00'])->count(2))->create(['day_of_week' => 5, 'hour' => '18:00', 'description' => 'Aula de Boxe']);

        Schedule::factory()->has(Checkin::factory(['hour' => '19:00'])->count(3))->create(['day_of_week' => 5, 'hour' => '19:00', 'description' => 'Aula de Boxe']);
    }
}
