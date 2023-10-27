<?php

test('deve retornar os dados do usuário/client logado', function () {
    $user = login();

    $response = $this->getJson('/api/auth/me');

    $response->assertStatus(200);

    $response->assertJson([
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->client->phone,
            'plan_name' => $user->client->plan->name,
            'plan_qtd_days' => $user->client->plan->qtd_days,
            'total_checkins' => $user->client->checkins->count(),
            'active' => $user->client->verified_at,
        ],
    ]);
});

test('deve retornar unauthorized se cliente não tiver logado', function () {

    $response = $this->getJson('/api/auth/me');

    $response->assertStatus(401);
});
