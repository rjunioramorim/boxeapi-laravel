<?php

use App\Models\Schedule;
use Carbon\Carbon;
use App\Services\SchedulesService;
use Tests\Feature\Data\SchedulesFactory;

beforeEach(function () {
    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $user = login();
    SchedulesFactory::generateSchedules($user);
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
            "day" => "2023-09-11",
            "hour" => "17:00",
            "description" => null,
            "professor" => "Prof: India",
            "limit" => 12,
            "vacancies" => 12,
            "userScheduled" => false,
           ],
          [
            "id" => 1,
            "day" => "2023-09-11",
            "hour" => "18:00",
            "description" => null,
            "professor" => "Prof: India",
            "limit" => 12,
            "vacancies" => 10,
            "userScheduled" => true,
          ]
    ];
    expect($schedules)->toBeArray()
        ->toMatchArray($response);
});


test('Deve listar os horários do dia recebendo a data', function () {
    $service = new SchedulesService();
    Carbon::setTestNow(Carbon::create(2023, 9, 11, 04, 15));    
    $schedules = $service->listSchedules('2023-09-12');
    $response = [[
            "id" => 5,
            "day" => "2023-09-12",
            "hour" => "05:00",
            "description" => null,
            "professor" => "Prof: India",
            "limit" => 12,
            "vacancies" => 12,
            "userScheduled" => false,
           ],
          [
            "id" => 6,
            "day" => "2023-09-12",
            "hour" => "19:00",
            "description" => null,
            "professor" => "Prof: India",
            "limit" => 12,
            "vacancies" => 12,
            "userScheduled" => false,
          ]
        ];
    expect($schedules)->toBeArray()->toMatchArray($response);
});


test('Deve retornar os  data informada for anterior ao dia atual', function () {
    $service = new SchedulesService();

    
    $schedules = $service->listSchedules('2023-09-10');

    $response = [];

    expect($schedules)->toBeArray()->toMatchArray($response);
});