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

    $schedules = $service->listSchedules(now()->format('Y-m-d'));
    expect($schedules)->toHaveCount(2);
    expect($schedules[0]->checkins)->toBeEmpty();
    expect($schedules[1]->checkins)->toHaveCount(2);
});


test('Deve listar os horários do dia recebendo a data', function () {
    $service = new SchedulesService();
    Carbon::setTestNow(Carbon::create(2023, 9, 11, 04, 15));
    $schedules = $service->listSchedules('2023-09-12');

    // dd($schedules->toArray());
    expect($schedules)->toHaveCount(2);
    expect($schedules[0]->checkins)->toBeEmpty();
    expect($schedules[1]->checkins)->toHaveCount(0);
});


test('Deve retornar array vazio se data informada for anterior ao dia atual', function () {
    $service = new SchedulesService();

    $schedules = $service->listSchedules('2023-09-10');

    $response = [];

    expect($schedules)->toBeArray()->toMatchArray($response);
});
