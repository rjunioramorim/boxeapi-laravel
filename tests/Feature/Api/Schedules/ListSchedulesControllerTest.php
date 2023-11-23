<?php

use App\Enums\ScheduleType;
use App\Models\Checkin;
use App\Models\Schedule;
use Carbon\Carbon;

test('deve listar somente o evento e não as aulas', function () {
    factorySchedules();
    $today = now();

    $event = Schedule::factory()->hasCheckins(2)->create(['day_of_week' => '1', 'hour' => '15:00', 'limit' => 20, 'description' => 'Evento', 'event_date' => $today->format('Y-m-d')]);
    $response = $this->getJson('/api/schedules?day=2023-09-11');

    $response->assertJson([
        'data' => [
            [
                'id' => $event->id,
                'day' => $today->format('Y-m-d'),
                'hour' => '15:00',
                'description' => 'Evento',
                'professor' => 'Prof: India',
                'checkins' => 2,
                'open' => true,
            ],
        ],
    ]);
});

test('lista os horários de aula do dia, sem receber a data', function () {
    factorySchedules();
    $today = now();

    $response = $this->getJson('/api/schedules');

    $response->assertJson(loadReturn($today));
    $response->assertStatus(200);

    Carbon::setTestNow();
});

test('lista os horários de aula do dia, informando a data', function () {
    factorySchedules();
    $today = now();

    $response = $this->getJson('/api/schedules?day=2023-09-11');
    $data = loadReturn($today);
    $response->assertJson($data);

    $response->assertStatus(200);
    Carbon::setTestNow();
});

test('não deve lista os horários de aula do dia se a data for anterior ao dia atual', function () {
    $user = login();

    Schedule::factory()->create(['day_of_week' => 1, 'hour' => '05:30', 'description' => 'Aula de boxe']);
    Schedule::factory()->create(['day_of_week' => 2, 'hour' => '05:30', 'description' => 'Aula de boxe']);
    Schedule::factory()->create(['day_of_week' => 2, 'hour' => '06:30', 'description' => 'Aula de boxe']);

    Schedule::factory()
        ->has(Checkin::factory(['hour' => '18:00', 'client_id' => $user->client->id]))
        ->has(Checkin::factory(['hour' => '18:00']))
        ->create(['day_of_week' => 2, 'hour' => '18:00', 'description' => 'Aula de boxe']);

    Carbon::setTestNow(Carbon::create(2023, 9, 12, 12, 15));

    $response = $this->getJson('/api/schedules?day=2023-09-11');

    $response->assertJson(['data' => []]);

    Carbon::setTestNow();

    $response->assertStatus(200);
});

test('lista os horários de aula do dia com a confirmação do checkind do usuário logado', function () {
    $user = login();
    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));
    $today = now();
    Schedule::factory()->has(Checkin::factory(['hour' => '17:00']))
        ->create(['day_of_week' => 1, 'hour' => '17:00', 'description' => 'Aula de boxe']);

    Schedule::factory()
        ->has(Checkin::factory(['hour' => '18:00', 'status' => ScheduleType::CONFIRMED->value, 'client_id' => $user->client->id]))
        ->has(Checkin::factory(['hour' => '18:00']))
        ->create(['day_of_week' => 1, 'hour' => '18:00', 'description' => 'Aula de boxe']);


    $response = $this->getJson('/api/schedules?day=2023-09-11');
    $data =  [
        'data' => [
            [
                'id' => 1,
                'day' => $today->format('Y-m-d'),
                'hour' => '17:00',
                'description' => 'Aula de boxe',
                'professor' => 'Prof: India',
                'checkins' => 1,
                'open' => true,
                'status' => null,
            ],
            [
                'id' => 2,
                'day' => $today->format('Y-m-d'),
                'hour' => '18:00',
                'description' => 'Aula de boxe',
                'professor' => 'Prof: India',
                'checkins' => 2,
                'open' => true,
                'status' => ScheduleType::CONFIRMED->value,
            ],
        ],
    ];
    $response->assertJson($data);

    $response->assertStatus(200);
    Carbon::setTestNow();
});



function factorySchedules()
{
    $user = login();
    Schedule::factory()->create(['day_of_week' => 1, 'hour' => '05:30', 'description' => 'Aula de boxe']);
    Schedule::factory()->create(['day_of_week' => 1, 'hour' => '06:30', 'description' => 'Aula de boxe']);
    Schedule::factory()->has(Checkin::factory(['hour' => '17:00']))
        ->create(['day_of_week' => 1, 'hour' => '17:00', 'description' => 'Aula de boxe']);

    Schedule::factory()
        ->has(Checkin::factory(['hour' => '18:00', 'client_id' => $user->client->id]))
        ->has(Checkin::factory(['hour' => '18:00']))
        ->create(['day_of_week' => 1, 'hour' => '18:00', 'description' => 'Aula de boxe']);

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));
}



function loadReturn($today)
{
    return [
        'data' => [
            [
                'id' => 1,
                'day' => $today->format('Y-m-d'),
                'hour' => '05:30',
                'description' => 'Aula de boxe',
                'professor' => 'Prof: India',
                'checkins' => 0,
                'open' => false,
            ],
            [
                'id' => 2,
                'day' => $today->format('Y-m-d'),
                'hour' => '06:30',
                'description' => 'Aula de boxe',
                'professor' => 'Prof: India',
                'checkins' => 0,
                'open' => false,
            ],
            [
                'id' => 3,
                'day' => $today->format('Y-m-d'),
                'hour' => '17:00',
                'description' => 'Aula de boxe',
                'professor' => 'Prof: India',
                'checkins' => 1,
                'open' => true,
            ],
            [
                'id' => 4,
                'day' => $today->format('Y-m-d'),
                'hour' => '18:00',
                'description' => 'Aula de boxe',
                'professor' => 'Prof: India',
                'checkins' => 2,
                'open' => true,
            ],
        ],
    ];
}
