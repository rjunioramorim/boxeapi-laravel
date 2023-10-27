<?php

use App\Models\Checkin;
use App\Models\Schedule;
use Carbon\Carbon;

test('deve listar os agendamentos em aberto', function () {
    $user = login();

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    Schedule::factory()->has(Checkin::factory(['hour' => '17:00', 'client_id' => $user->client->id, 'checkin_date' => now()->format('Y-m-d')]))->create();

    Schedule::factory()->has(Checkin::factory(['hour' => '17:00', 'client_id' => $user->client->id, 'checkin_date' => now()->addDays(1)->format('Y-m-d')]))->create();

    $response = $this->getJson('/api/checkins');

    $checkin = Checkin::with('schedule')->where('checkin_date', '>=', '2023-09-11')->get();

    Carbon::setTestNow();

    $response->assertStatus(200);
    $response->assertJson([
        'data' => [
            [
                'id' => $checkin[0]->id,
                'client_id' => $user->client->id,
                'hour' => $checkin[0]->hour,
                'day' => $checkin[0]->checkin_date,
                'description' => $checkin[0]->schedule->description,
                'professor' => $checkin[0]->schedule->professor,
                'confirmed_at' => $checkin[0]->confirmed_at,
            ],
            [
                'id' => $checkin[1]->id,
                'client_id' => $user->client->id,
                'hour' => $checkin[1]->hour,
                'day' => $checkin[1]->checkin_date,
                'description' => $checkin[1]->schedule->description,
                'professor' => $checkin[1]->schedule->professor,
                'confirmed_at' => $checkin[1]->confirmed_at,
            ],
        ],
    ]);

});

test('deve listar array vazio se não tiver checkin agendado para o dia atual e os próximos', function () {
    login();

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $response = $this->getJson('/api/checkins');

    Carbon::setTestNow();

    $response->assertStatus(200);
    $response->assertJson(['data' => []]);

});

test('deve listar o checkin dia já realizado se tiver', function () {
    $user = login();

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 18, 15));

    $schedules = Schedule::factory()->has(
        Checkin::factory(['hour' => '17:00', 'client_id' => $user->client->id, 'checkin_date' => now()->format('Y-m-d'), 'confirmed_at' => now()]))
        ->create(['hour' => '17:00', 'day_of_week' => 1, 'description' => 'Aula de boxe']);

    $response = $this->getJson('/api/checkins');

    Carbon::setTestNow();

    $response->assertStatus(200);
    $response->assertJson(['data' => [
        [
            'id' => $schedules->checkins[0]->id,
            'client_id' => $user->client->id,
            'hour' => $schedules->checkins[0]->hour,
            'day' => $schedules->checkins[0]->checkin_date,
            'description' => $schedules->description,
            'professor' => $schedules->professor,
            'confirmed_at' => $schedules->checkins[0]->confirmed_at,
        ],
    ]]);

});
