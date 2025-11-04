<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BiomaController;
use App\Http\Controllers\Api\V1\PublicContentController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\SugestaoController;
use App\Http\Controllers\Api\V1\QuizController;

Route::prefix('v1')->group(function () {
    // Rotas de Biomas
    Route::get('biomas', [BiomaController::class, 'index']);
    Route::get('biomas/{bioma}', [BiomaController::class, 'show']);

    // Rotas de Conteúdo de um Bioma
    Route::get('biomas/{bioma}/fauna', [PublicContentController::class, 'fauna']);
    Route::get('biomas/{bioma}/flora', [PublicContentController::class, 'flora']);
    Route::get('biomas/{bioma}/relevo', [PublicContentController::class, 'relevo']);
    Route::get('biomas/{bioma}/clima', [PublicContentController::class, 'clima']);
    Route::get('biomas/{bioma}/hidrografia', [PublicContentController::class, 'hidrografia']);
    Route::get('biomas/{bioma}/caracteristicas-se', [PublicContentController::class, 'caracteristicasSe']);
    Route::get('biomas/{bioma}/areas-preservacao', [PublicContentController::class, 'areasPreservacao']);
    Route::get('biomas/{bioma}/posts', [PublicContentController::class, 'posts']);

    // Rotas de Detalhes de Itens Individuais
    Route::get('areas-preservacao/{area_preservacao}', [PublicContentController::class, 'showAreaPreservacao']);
    Route::get('caracteristicas-se/{caracteristica_se}', [PublicContentController::class, 'showCaracteristicaSE']);
    Route::get('clima/{clima}', [PublicContentController::class, 'showClima']);
    Route::get('fauna/{fauna}', [PublicContentController::class, 'showFauna']);
    Route::get('flora/{flora}', [PublicContentController::class, 'showFlora']);
    Route::get('hidrografia/{hidrografia}', [PublicContentController::class, 'showHidrografia']);
    Route::get('relevo/{relevo}', [PublicContentController::class, 'showRelevo']);
    Route::get('posts/{post}', [PublicContentController::class, 'showPost']);

    // Rotas de Criação
    Route::post('posts', [PostController::class, 'store']);
    Route::post('sugestoes', [SugestaoController::class, 'store']);

    //Rotas do quiz
    Route::get('biomas/{bioma}/quiz', [QuizController::class, 'generateQuiz']);
    Route::post('quiz/submit', [QuizController::class, 'submitScore']);
    Route::get('biomas/{bioma}/ranking', [QuizController::class, 'getRanking']);
});
