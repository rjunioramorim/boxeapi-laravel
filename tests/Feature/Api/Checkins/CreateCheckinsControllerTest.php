<?php

use App\Models\Checkin;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;

use function Pest\Laravel\actingAs;

test('usuário logado e ativo pode realizar checkin dentro do limite de vagas e com a aula disponível', function () {
    login();

    $schedule = Schedule::factory()->create(['day_of_week' => 1, 'hour' => '17:00', 'description' => 'Aula de boxe']);

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $response = $this->postJson('/api/checkins', [
        'schedule_id' => $schedule->id,
        'hour' => '17:00',
        'checkin_date' => '2023-09-11',
    ]);

    Carbon::setTestNow();
    $this->assertDatabaseHas('checkins', ['schedule_id' => $schedule->id, 'hour' => '17:00', 'checkin_date' => '2023-09-11']);
    $response->assertStatus(201);
});

// test('usuário bloqueado não pode realizar checkin dentro do limite de vagas e com a aula disponível', function () {
//     $user = User::factory()->hasClient()->create(['active' => false]);
//     actingAs($user);

//     $schedule = Schedule::factory()->create(['day_of_week' => 1, 'hour' => '17:00', 'description' => 'Aula de boxe']);

//     Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

//     $response = $this->postJson('/api/checkins', [
//         'schedule_id' => $schedule->id,
//         'hour' => '17:00',
//         'checkin_date' => '2023-09-11',
//     ]);

//     $response->assertJson(['message' => 'Não foi possível realizar o agendamento. Entre em contato com a administração.']);

//     Carbon::setTestNow();
//     $this->assertDatabaseMissing('checkins', ['schedule_id' => $schedule->id, 'hour' => '17:00', 'checkin_date' => '2023-09-11']);
//     $response->assertStatus(422);
// });


test('usuário não pode realizar checkin se a aula já tiver sido realizada', function () {
    login();

    $schedule = Schedule::factory()->create(['day_of_week' => 1, 'hour' => '06:30', 'description' => 'Aula de boxe']);

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $response = $this->postJson('/api/checkins', [
        'schedule_id' => $schedule->id,
        'hour' => '06:30',
        'checkin_date' => '2023-09-11',
    ]);

    Carbon::setTestNow();
    $response->assertStatus(422);
    $response->assertJson(['message' => 'A aula já começou e não está mais disponível, tente outro horário']);
});

test('usuário não pode realizar checkin se a aula já tiver com limite completo', function () {
    login();

    $schedule = Schedule::factory()->has(Checkin::factory(['hour' => '17:00'])->count(2))->create(['day_of_week' => 1, 'hour' => '17:00', 'limit' => 2]);

    Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

    $response = $this->postJson('/api/checkins', [
        'schedule_id' => $schedule->id,
        'hour' => '17:00',
        'checkin_date' => '2023-09-11',
    ]);

    Carbon::setTestNow();
    $response->assertStatus(422);
    $response->assertJson(['message' => 'Não pode fazer o checkin em uma aula com o limite cheio']);
});

// test('usuário não pode realizar checkin na mesma aula', function () {
//     $user = login();
//     $clientId = $user->client->id;

//     $schedule = Schedule::factory()->has(Checkin::factory(['hour' => '17:00', 'client_id' => $clientId, 'checkin_date' => '2023-09-11']))->create(['day_of_week' => 1, 'hour' => '17:00', 'limit' => 12]);
    
//     Carbon::setTestNow(Carbon::create(2023, 9, 11, 10, 15));

//     $response = $this->postJson('/api/checkins', [
//         'schedule_id' => $schedule->id,
//         'hour' => '17:00',
//         'checkin_date' => '2023-09-11',
//     ]);

//     Carbon::setTestNow();
//     $response->assertStatus(422);
//     $response->assertJson(['message' => 'Aula já agendada, tente outro horário']);
// });
