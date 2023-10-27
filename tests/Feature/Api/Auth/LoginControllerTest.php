<?php

use App\Models\User;

test('O usuário ativo com dados corretos pode se logar', function () {
    $user = User::factory()->create(['email' => 'user@user.com']);

    $response = $this->post('/api/auth/session', ['email' => $user->email, 'password' => 'password']);

    $response->assertStatus(200);
    expect($response->content())->toContain('accessToken');
});

test('O usuário ativo com dados inválidos não pode se logar', function () {
    $user = User::factory()->create(['email' => 'user@user.com']);

    $response = $this->postJson('/api/auth/session', ['email' => $user->email, 'password' => 'invalid_password']);

    $response->assertStatus(422);
    expect(fn () => throw new Exception('E-mail ou senha inválidos'))->toThrow('E-mail ou senha inválidos');
});
