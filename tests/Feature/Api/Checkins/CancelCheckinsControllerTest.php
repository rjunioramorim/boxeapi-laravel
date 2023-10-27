<?php

use App\Models\Checkin;
use App\Models\Schedule;
use Carbon\Carbon;

test('usuário logado pode cancelar agendamento antes do inicio da aula', function () {
    $user = login();

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $schedule = Schedule::factory()->has(Checkin::factory(['hour' => '17:00', 'client_id' => $user->client->id, 'checkin_date' => now()->format('Y-m-d')]))->create();
    $checkin = $schedule->checkins[0];

    $response = $this->putJson('/api/checkins/'.$checkin->id);

    $checkinUpdate = Checkin::where('id', $checkin->id)->first();

    $this->assertNotNull($checkinUpdate->canceled_at);

    Carbon::setTestNow();
    $response->assertStatus(200);
});


test('usuário logado pode cancelar agendamento antes do inicio da aula em outra data', function () {
    $user = login();

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $schedule = Schedule::factory()->has(Checkin::factory(['hour' => '05:30', 'client_id' => $user->client->id, 'checkin_date' => '2023-09-12']))->create();
    $checkin = $schedule->checkins[0];

    
    $response = $this->putJson('/api/checkins/'.$checkin->id);
    
    $checkinUpdate = Checkin::where('id', $checkin->id)->first();

    $checkinUpdate->refresh();

    $this->assertNotNull($checkinUpdate->canceled_at);

    Carbon::setTestNow();
    $response->assertStatus(200);
});

test('usuário não pode cancelar agendamento se aula já tiver começado', function () {
    $user = login();

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $schedule = Schedule::factory()->has(Checkin::factory(['hour' => '17:00', 'client_id' => $user->client->id, 'checkin_date' => now()->format('Y-m-d')]))->create();

    $checkin = $schedule->checkins[0];

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 17, 15));
    $response = $this->putJson('/api/checkins/'.$checkin->id);

    Carbon::setTestNow();

    $response->assertStatus(422);
    $response->assertJson(['message' => 'Não é possível cancelar esse agendamento, aula já iniciada.']);

});

test('usuário não pode cancelar agendamento se aula já tiver sido confirmado', function () {
    $user = login();

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 9, 55));

    $schedule = Schedule::factory()->has(Checkin::factory(['hour' => '17:00', 'client_id' => $user->client->id, 'checkin_date' => now()->format('Y-m-d'), 'confirmed_at' => now()->addHours(7)]))->create();

    $checkin = $schedule->checkins[0];

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 16, 55));
    $response = $this->putJson('/api/checkins/'.$checkin->id);

    Carbon::setTestNow();

    $response->assertStatus(422);
    $response->assertJson(['message' => 'Não é possível cancelar esse agendamento, aula já confirmada.']);

});


