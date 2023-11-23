<?php

use App\Enums\ScheduleType;
use App\Models\Checkin;
use App\Models\Schedule;
use App\Models\User;
use App\Services\SchedulesService;
use Carbon\Carbon;

beforeEach(function () {
    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $user = login();
    Schedule::factory()
        ->has(Checkin::factory(
            [
                'hour' => '18:00',
                'status' => ScheduleType::SCHEDULED->value,
                'client_id' => $user->client->id
            ]
        ))
        ->has(Checkin::factory(
            [
                'hour' => '18:00',
                'status' => ScheduleType::SCHEDULED->value,
            ]
        ))
        ->has(Checkin::factory(
            [
                'hour' => '18:00',
                'status' => ScheduleType::CANCELED->value,
            ]
        ))->create(['hour' => '18:00', 'day_of_week' => 1]);



    Schedule::factory(['hour' => '06:00', 'day_of_week' => 1])->create();
    Schedule::factory(['hour' => '17:00', 'day_of_week' => 1])->create();
    Schedule::factory(['hour' => '19:00', 'day_of_week' => 1, 'active' => false])->create();
});

afterEach(function () {
    Carbon::setTestNow();
});

test('Deve listar os horários do dia sem receber a data', function () {
    $service = new SchedulesService();

    $schedules = $service->listSchedules();

    $response = [
        [
            "id" => 3,
            "day" => '2023-09-11',
            "hour" => "17:00",
            "description" => null,
            "professor" => "Prof: India",
            "limit" => 12,
            "vacancies" => 12,
            "userScheduled" => false,
            "userStatus" => null
        ],
        [
            "id" => 1,
            "day" => '2023-09-11',
            "hour" => "18:00",
            "description" => null,
            "professor" => "Prof: India",
            "limit" => 12,
            "vacancies" => 10,
            "userScheduled" => true,
            "userStatus" => 'scheduled'
        ]

    ];
    expect($schedules)->toBeIn($response);
});
