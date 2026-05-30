<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\SerieController; // Garanta que essa linha existe!

/*
|--------------------------------------------------------------------------
| Rotas do Sistema
|--------------------------------------------------------------------------
*/

// Rota Inicial (Redireciona direto para os filmes para facilitar)
Route::get('/', function () {
    return redirect('/filmes');
});

// Rotas de Filmes
Route::get('/filmes', [FilmeController::class, 'index']);
Route::get('/filmes/create', [FilmeController::class, 'create']);
Route::post('/filmes', [FilmeController::class, 'store']);
Route::get('/filmes/{id}/edit', [FilmeController::class, 'edit']);
Route::put('/filmes/{id}', [FilmeController::class, 'update']);
Route::get('/filmes/{id}', [FilmeController::class, 'show']);
Route::delete('/filmes/{id}', [FilmeController::class, 'destroy']);

// Rotas de Séries (Exatamente no mesmo padrão, sem conflitos)
Route::get('/series', [SerieController::class, 'index']);
Route::get('/series/create', [SerieController::class, 'create']);
Route::post('/series', [SerieController::class, 'store']);
Route::get('/series/{id}/edit', [SerieController::class, 'edit']);
Route::put('/series/{id}', [SerieController::class, 'update']);
Route::get('/series/{id}', [SerieController::class, 'show']);
Route::delete('/series/{id}', [SerieController::class, 'destroy']);