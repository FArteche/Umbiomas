<?php

namespace Tests\Unit\Http\Requests\Api\V1;

use App\Http\Requests\Api\V1\SubmitQuizScoreRequest;

test('regras de validação do SubmitQuizScoreRequest estão corretas', function () {

    $request = new SubmitQuizScoreRequest();

    $rules = $request->rules();

    expect($rules)->toHaveKeys([
        'bioma_id',
        'score',
        'postador',
        'postador.nome',
        'postador.email',
    ]);

    expect($rules['bioma_id'])->toBe('required|exists:biomas,id_bioma');
    expect($rules['score'])->toBe('required|integer|min:0|max:10');
    expect($rules['postador.email'])->toBe('required|email|max:100');
});

test('autorização do SubmitQuizScoreRequest é sempre verdadeira', function () {
    $request = new SubmitQuizScoreRequest();

    $authorization = $request->authorize();

    expect($authorization)->toBeTrue();
});
