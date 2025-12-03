<?php

use App\Http\Controllers\Web\BiomaController;
use App\Http\Controllers\Web\FloraController;
use App\Http\Controllers\Web\FaunaController;
use App\Http\Controllers\Web\ClimaController;
use App\Http\Controllers\Web\RelevoController;
use App\Http\Controllers\Web\HidrografiaController;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Caracteristica_SEController;
use App\Http\Controllers\Web\Tipo_CSEController;
use App\Http\Controllers\Web\Area_PreservacaoController;
use App\Http\Controllers\Web\Info_PostadorController;
use App\Http\Controllers\Web\HistoricoController;
use App\Http\Controllers\Web\SugestoesController;
use App\Http\Controllers\Web\Tipo_Area_PreservacaoController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');;
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.main.main_page');
    })->name('dashboard');

    //USERS
    Route::get('/usuarios/criar', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');

    //RESOURCES
    Route::resource('biomas', BiomaController::class);
    Route::resource('fauna', FaunaController::class);
    Route::resource('flora', FloraController::class);
    Route::resource('clima', ClimaController::class);
    Route::resource('caracteristica_se', Caracteristica_SEController::class);
    Route::resource('tipos_cse', Tipo_CSEController::class);
    Route::resource('area_preservacao', Area_PreservacaoController::class);
    Route::resource('tipo_ap', Tipo_Area_PreservacaoController::class);
    Route::resource('relevo', RelevoController::class);
    Route::resource('hidrografia', HidrografiaController::class)->parameters([
        'hidrografia' => 'hidrografia'
    ]);

    //MANAGE ITENS DO BIOMA
    //FAUNA
    Route::get('biomas/{bioma}/fauna', [BiomaController::class, 'manageFauna'])->name('biomas.manageFauna');
    Route::put('biomas/{bioma}/fauna', [BiomaController::class, 'syncFauna'])->name('biomas.syncFauna');
    //FLORA
    Route::get('biomas/{bioma}/flora', [BiomaController::class, 'manageFlora'])->name('biomas.manageFlora');
    Route::put('biomas/{bioma}/flora', [BiomaController::class, 'syncFlora'])->name('biomas.syncFlora');
    //CLIMA
    Route::get('biomas/{bioma}/clima', [BiomaController::class, 'manageClima'])->name('biomas.manageClima');
    Route::put('biomas/{bioma}/clima', [BiomaController::class, 'syncClima'])->name('biomas.syncClima');
    //CARACTERISTICAS
    Route::get('biomas/{bioma}/caracteristica_se', [BiomaController::class, 'manageCaracteristicas'])->name('biomas.manageCaracteristicas');
    Route::post('tipos-cse/store-ajax', [Tipo_CSEController::class, 'storeAjax'])->name('tipos-cse.storeAjax');
    //AREA DE PRESERVACAO
    Route::get('biomas/{bioma}/area_preservacao', [BiomaController::class, 'manageArea_Preservacao'])->name('biomas.manageArea_Preservacao');
    Route::get('areas-preservacao/{area_preservacao}/mapa', [Area_PreservacaoController::class, 'editMap'])->name('areas-preservacao.editMap');
    Route::put('areas-preservacao/{area_preservacao}/mapa', [Area_PreservacaoController::class, 'updateMap'])->name('areas-preservacao.updateMap');
    Route::post('tipo-ap/store-ajax', [Tipo_Area_PreservacaoController::class, 'storeAjax'])->name('tipo-ap.storeAjax');
    //RELEVO
    Route::get('biomas/{bioma}/relevo', [BiomaController::class, 'manageRelevo'])->name('biomas.manageRelevo');
    //HIDROGRAFIA
    Route::get('biomas/{bioma}/hidrografia', [BiomaController::class, 'manageHidrografia'])->name('biomas.manageHidrografia');
    //MAPA DO BIOMA
    Route::get('biomas/{bioma}/mapa', [BiomaController::class, 'editMap'])->name('biomas.editMap');
    Route::put('biomas/{bioma}/mapa', [BiomaController::class, 'updateMap'])->name('biomas.updateMap');
    //POSTS
    Route::get('biomas/{bioma}/post', [BiomaController::class, 'managePost'])->name('biomas.managePost');
    Route::get('gerenciar-posts/', [PostController::class, 'indexBiomas'])->name('post.indexBiomas');
    Route::get('post/{post}', [PostController::class, 'show'])->name('post.show');
    Route::put('post/{post}/approve', [PostController::class, 'approve'])->name('post.approve');
    Route::put('post/{post}/reject', [PostController::class, 'reject'])->name('post.reject');
    Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    //SUGESTOES
    Route::get('biomas/sugestoes', [BiomaController::class, 'manageSugestoes'])->name('biomas.manageSugestoes');
    Route::get('/sugestoes', [SugestoesController::class, 'index'])->name('sugestoes.index');
    Route::get('/sugestoes/{sugestao}', [SugestoesController::class, 'show'])->name('sugestoes.show');
    Route::delete('/sugestoes/{sugestao}', [SugestoesController::class, 'destroy'])->name('sugestoes.destroy');
    //HISTORICO
    Route::get('/historico', [HistoricoController::class, 'index'])->name('historico.index');
});
