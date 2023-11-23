<?php

namespace Tests\Feature\Data;

use App\Enums\ScheduleType;
use App\Models\Checkin;
use App\Models\Schedule;

class SchedulesFactory 
{
  public static function generateSchedules($user) {
    Schedule::factory()->has(Checkin::factory([
        'hour' => '18:00',
        'status' => ScheduleType::SCHEDULED->value,
        'client_id' => $user->client->id
      ]))->has(Checkin::factory([
         'hour' => '18:00', 'status' => ScheduleType::SCHEDULED->value,
      ]))->has(Checkin::factory([
          'hour' => '18:00', 'status' => ScheduleType::CANCELED->value,
      ]))->create(['hour' => '18:00', 'day_of_week' => 1]);
    Schedule::factory(['hour' => '06:00', 'day_of_week' => 1])->create();
    Schedule::factory(['hour' => '17:00', 'day_of_week' => 1])->create();
    Schedule::factory(['hour' => '19:00', 'day_of_week' => 1, 'active' => false])->create();
    Schedule::factory(['hour' => '05:00', 'day_of_week' => 2,])->create();
    Schedule::factory(['hour' => '19:00', 'day_of_week' => 2,])->create();
  }
}
            