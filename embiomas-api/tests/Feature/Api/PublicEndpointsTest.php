<?php

namespace Tests\Feature\Api;

use App\Models\Bioma;
use App\Models\Fauna;
use App\Models\Flora;
use App\Models\Clima;
use App\Models\Relevo;
use App\Models\Hidrografia;
use App\Models\Caracteristica_SE;
use App\Models\Area_Preservacao;
use App\Models\Tipo_CSE;
use App\Models\Tipo_Area_Preservacao;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Tipo_CSE::factory()->create();
    Tipo_Area_Preservacao::factory()->create();
});

// Teste 1: Listar todos os biomas
it('pode listar todos os biomas publicamente', function () {
    // 1. Arrange
    Bioma::factory()->count(3)->create();

    // 2. Act
    // Desloga o admin para testar como um usuário público
    Auth::logout();
    $response = $this->getJson('/api/v1/biomas');

    // 3. Assert
    $response->assertStatus(200)
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'nome', 'imagem_url']
            ]
        ]);
});

// Teste 2: Gerar um Quiz
it('pode gerar um quiz para um bioma', function () {
    // 1. Arrange
    $bioma = Bioma::factory()
        ->hasAttached(Fauna::factory()->count(1), [], 'fauna')
        ->hasAttached(Flora::factory()->count(1), [], 'flora')
        ->hasAttached(Clima::factory()->count(1), [], 'clima')
        ->has(Relevo::factory()->count(1), 'relevo')
        ->has(Hidrografia::factory()->count(1), 'hidrografia')
        ->has(Caracteristica_SE::factory()->count(1), 'caracteristica_se')
        ->has(Area_Preservacao::factory()->count(1), 'area_preservacao')
        ->create();

    // 2. Act
    Auth::logout();
    $response = $this->getJson("/api/v1/biomas/{$bioma->id_bioma}/quiz");

    // 3. Assert
    $response->assertStatus(200)
        ->assertJsonCount(7);
});

// Teste 3: Submeter um score de quiz
it('pode submeter uma pontuacao de quiz', function () {
    // 1. Arrange
    $bioma = Bioma::factory()->create();

    $quizData = [
        'bioma_id' => $bioma->id_bioma,
        'score' => 8,
        'postador' => [
            'nome' => 'Jogador de Teste',
            'email' => 'jogador@teste.com',
            'telefone' => '555399999999',
            'instituicao' => 'IFSul',
            'ocupacao' => 'Estudante'
        ]
    ];

    // 2. Act
    Auth::logout();
    $response = $this->postJson('/api/v1/quiz/submit', $quizData);

    // 3. Assert
    $response->assertStatus(201)
        ->assertJson(['message' => 'Pontuação registrada com sucesso!']);

    $this->assertDatabaseHas('info_postador', [
        'nome_postador' => 'Jogador de Teste',
        'email_postador' => 'jogador@teste.com'
    ]);
    $this->assertDatabaseHas('quiz_attempts', [
        'bioma_id' => $bioma->id_bioma,
        'score' => 8
    ]);
});
