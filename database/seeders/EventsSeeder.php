<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = Schedule::all();
        Event::factory(2)->create(['schedule_id' => $schedules->random()->id]);
        Event::factory(2)->create(['schedule_id' => $schedules->random()->id]);
        Event::factory(2)->create(['schedule_id' => $schedules->random()->id]);
        Event::factory(2)->create(['schedule_id' => $schedules->random()->id]);
        Event::factory(2)->create(['schedule_id' => $schedules->random()->id]);
    }
}
