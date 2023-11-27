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
        $hours = ['05:30', '06:30', '10:00', '17:00', '18:00', '19:00', '20:00'];

        for($i = 0; $i < 5; $i++) {
            foreach($hours as $hour) {
                Schedule::factory()->create(['day_of_week' => $i +1, 'hour' => $hour]);
            }
        }
        
        // Schedule::factory()->create(['weekday' => 1, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 1, 'hour' => '17:00', 'description' => 'Aula de Boxe Kids']);
        // Schedule::factory()->create(['weekday' => 1, 'hour' => '18:00', 'description' => 'Aula de AeroBoxe']);
        // Schedule::factory()->create(['weekday' => 1, 'hour' => '19:00', 'description' => 'Aula de Boxe']);

        // Schedule::factory()->create(['weekday' => 2, 'hour' => '05:30', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 2, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 2, 'hour' => '17:00', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 2, 'hour' => '18:00', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 2, 'hour' => '19:00', 'description' => 'Aula de Boxe']);

        // Schedule::factory()->create(['weekday' => 3, 'hour' => '05:30', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 3, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 3, 'hour' => '17:00', 'description' => 'Aula de Boxe Kids']);
        // Schedule::factory()->create(['weekday' => 3, 'hour' => '18:00', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 3, 'hour' => '19:00', 'description' => 'Aula de Boxe']);

        // Schedule::factory()->create(['weekday' => 4, 'hour' => '05:30', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 4, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 4, 'hour' => '17:00', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 4, 'hour' => '18:00', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->has(Checkin::factory(['hour' => '19:00', 'checkin_date' => now()->subDay(1)])->count(3))->create(['weekday' => 4, 'hour' => '19:00', 'description' => 'Aula de Boxe']);

        // Schedule::factory()->create(['weekday' => 5, 'hour' => '05:30', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->create(['weekday' => 5, 'hour' => '06:30', 'description' => 'Aula de Boxe']);
        // Schedule::factory()->has(Checkin::factory(['hour' => '17:00'])->count(1))->create(['weekday' => 5, 'hour' => '17:00', 'description' => 'Aula de Boxe Kids']);
        // Schedule::factory()->has(Checkin::factory(['hour' => '18:00'])->count(2))->create(['weekday' => 5, 'hour' => '18:00', 'description' => 'Aula de Boxe']);

        // Schedule::factory()->has(Checkin::factory(['hour' => '19:00'])->count(3))->create(['weekday' => 5, 'hour' => '19:00', 'description' => 'Aula de Boxe']);
    }
}
