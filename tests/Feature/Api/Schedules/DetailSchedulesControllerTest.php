<?php

use App\Models\Checkin;
use App\Models\Schedule;
use Carbon\Carbon;

test('deve listar todos os checkins do dia e horário', function () {
    $user = login();
    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $schedule = Schedule::factory()
        ->has(Checkin::factory(['hour' => '18:00', 'client_id' => $user->client->id]))
        ->has(Checkin::factory(['hour' => '18:00']))
        ->create(['day_of_week' => 1, 'hour' => '18:00', 'description' => 'Aula de boxe', 'limit' => 12]);

    $response = $this->getJson("/api/schedules/{$schedule->id}?day=2023-09-11");

    $response->assertStatus(200);
    $response->assertJson([
        'data' => [
            'id' => $schedule->id,
            'day' => "2023-09-11",
            'hour' => $schedule->hour,
            'checkins' => 2,
            'limit' => $schedule->limit,
            'clients' => [
                [
                    'id' => 1,
                    'avatar_url' => url($schedule->checkins[0]->client->user->avatar_url),
                    'name' => $schedule->checkins[0]->client->user->name,
                    'checked' => true,
                ],
                [
                    'id' => $schedule->checkins[1]->client->id,
                    'avatar_url' => url($schedule->checkins[1]->client->user->avatar_url),
                    'name' => $schedule->checkins[1]->client->user->name,
                    'checked' => false,
                ],
            ]
        ]
    ]);
    Carbon::setTestNow();
});
