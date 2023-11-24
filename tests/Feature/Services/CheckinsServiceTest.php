<?php

use App\Models\Checkin;
use App\Models\Schedule;
use App\Services\CheckinsService;
use Carbon\Carbon;

beforeEach(function () {
    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));
});

afterEach(function () {
    Carbon::setTestNow();
});

test('Deve cadastrar um checkin com sucesso', function () {
    login();
    $service = new CheckinsService();

    Schedule::factory()->create(['hour' => '18:00']);

    $data = collect([
        'schedule_id' => 1,
        'hour' => '18:00',
        'checkin_date' => '2023-09-11',
    ]);

    $service->createCheckin($data);

    expect(Checkin::all()->count())->toBe(1);
});

test('Não pode fazer o checkin de uma aula que já começou', function () {
    login();
    $service = new CheckinsService();

    Schedule::factory()->create(['hour' => '05:00']);
    Schedule::factory()->create(['hour' => '18:00']);

    $data = collect([
        'schedule_id' => 1,
        'hour' => '05:00',
        'checkin_date' => '2023-09-11',
    ]);

    $service->createCheckin($data);
})->throws('A aula já começou e não está mais disponível, tente outro horário');

test('Não pode fazer o checkin em uma aula mais de uma vez', function () {
    $user = login();
    $service = new CheckinsService();

    $schedule = Schedule::factory()->create(['hour' => '18:00']);
    Checkin::factory()->create(['schedule_id' => $schedule->id, 'client_id' => $user->client->id, 'hour' => '18:00']);

    $data = collect([
        'schedule_id' => $schedule->id,
        'hour' => '18:00',
        'checkin_date' => '2023-09-11',
    ]);

    $service->createCheckin($data);
})->throws('Você já tem uma aula agendada para esse horário');

test('Não pode fazer o checkin em uma aula com o limite cheio', function () {
    $service = new CheckinsService();

    $schedule = Schedule::factory()->create(['hour' => '18:00', 'limit' => 2]);
    $checkins = Checkin::factory(2)->create(['schedule_id' => $schedule->id, 'hour' => '18:00']);
    $user = login();

    $data = collect([
        'schedule_id' => $schedule->id,
        'hour' => '18:00',
        'checkin_date' => '2023-09-11',
    ]);

    $service->createCheckin($data);
})->throws('Essa aula já está cheia, escolha outro horário');
