<?php

use App\Models\Checkin;
use App\Models\Schedule;
use App\Services\SchedulesService;
use Carbon\Carbon;

afterEach(function () {
    Carbon::setTestNow();
});

test('Deve listar os dados do agendamento e os checkins relacionados a ele', function () {
    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));
    $user = login();

    $schedule =  Schedule::factory()
        ->has(Checkin::factory(['hour' => '18:00', 'client_id' => $user->client->id]))
        ->has(Checkin::factory(['hour' => '18:00']))
        ->create(['hour' => '18:00', 'day_of_week' => 1]);

    $service = new SchedulesService();

    $schedule = $service->getSchedule($schedule, '2023-09-11');

    expect($schedule->id)->toBe(1);
    expect($schedule->checkins)->toHaveCount(2);
});
