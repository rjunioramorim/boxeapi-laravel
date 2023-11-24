<?php

use App\Enums\ScheduleType;
use App\Models\Checkin;
use App\Models\Schedule;
use Carbon\Carbon;

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
    login();

    Schedule::factory()->create(['day_of_week' => 1, 'hour' => '05:30']);
    Schedule::factory()->create(['day_of_week' => 2, 'hour' => '05:30']);
    Schedule::factory()->create(['day_of_week' => 2, 'hour' => '06:30']);

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
    Schedule::factory()->create(['hour' => '05:30', 'day_of_week' => 1]);
    $scheduleOne = Schedule::factory()->create(['hour' => '18:00', 'day_of_week' => 1]);
    $schedule = Schedule::factory()->create(['hour' => '17:00', 'day_of_week' => 1]);

    $checkin = Checkin::factory()->create(['client_id' => $user->client->id, 'schedule_id' => $schedule->id]);
    Checkin::factory()->create(['schedule_id' => $schedule->id]);

    $response = $this->getJson('/api/schedules?day=2023-09-11');
    $data =  [
        'data' => [
            [
                'id' => $schedule->id,
                'day' => $today->format('Y-m-d'),
                'hour' => '17:00',
                'professor' => 'Prof: India',
                'description' => 'Aula de boxe',
                "limit" => 12,
                "vacancies" => 10,
                "userScheduled" => true
            ],
            [
                'id' => $scheduleOne->id,
                'day' => $today->format('Y-m-d'),
                'hour' => '18:00',
                'professor' => 'Prof: India',
                'description' => 'Aula de boxe',
                "limit" => 12,
                "vacancies" => 12,
                "userScheduled" => false
            ],
        ],
    ];
    $response->assertJson($data);

    $response->assertStatus(200);
    Carbon::setTestNow();
});



function factorySchedules()
{
    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));
    $user = login();

    Schedule::factory()->create(['day_of_week' => 1, 'hour' => '05:30']);
    Schedule::factory()->create(['day_of_week' => 1, 'hour' => '18:00']);

    $schedule = Schedule::factory()->create(['day_of_week' => 1, 'hour' => '17:00']);
    $checkin = Checkin::factory()->create(['client_id' => $user->client->id, 'schedule_id' => $schedule->id]);
    Checkin::factory()->create(['schedule_id' => $schedule->id]);
}



function loadReturn($today)
{
    return [
        'data' => [
            [
                'id' => 3,
                'day' => $today->format('Y-m-d'),
                'hour' => '17:00',
                'professor' => 'Prof: India',
                'description' => 'Aula de boxe',
                "limit" => 12,
                "vacancies" => 10,
                "userScheduled" => true
            ],
            [
                'id' => 2,
                'day' => $today->format('Y-m-d'),
                'hour' => '18:00',
                'professor' => 'Prof: India',
                'description' => 'Aula de boxe',
                "limit" => 12,
                "vacancies" => 12,
                "userScheduled" => false
            ]
        ],
    ];
}
