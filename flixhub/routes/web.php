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

use App\Http\Controllers\FavoritoController;

// Rota de listagem (Index)
Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');

// Rota para exibir a tela de criação com nota inicial (Create)
// ATENÇÃO: Essa rota DEVE vir antes da rota com parâmetro {favorito} para o Laravel não se confundir
Route::get('/favoritos/create', [FavoritoController::class, 'create'])->name('favoritos.create');

// Rota de salvar o favorito no banco (Store)
Route::post('/favoritos', [FavoritoController::class, 'store'])->name('favoritos.store');

// Rota para exibir a tela de edição do comentário (Edit)
Route::get('/favoritos/{favorito}/edit', [FavoritoController::class, 'edit'])->name('favoritos.edit');

// Rota para salvar a atualização do comentário (Update)
Route::put('/favoritos/{favorito}', [FavoritoController::class, 'update'])->name('favoritos.update');

// Rota de deletar o favorito (Destroy)
Route::delete('/favoritos/{id}', [FavoritoController::class, 'destroy'])->name('favoritos.destroy');

use App\Http\Controllers\BuscaController;

// Mapeia todas as ações do CRUD para a Minha Lista / Busca
Route::resource('busca', BuscaController::class);