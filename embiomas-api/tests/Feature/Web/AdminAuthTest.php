<?php

namespace Tests\Feature\Web;

use App\Models\User;

it('redireciona usuarios nao autenticados do dashboard para o login', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

it('permite que usuarios autenticados acessem o dashboard', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/dashboard');
    $response->assertStatus(200);
});
