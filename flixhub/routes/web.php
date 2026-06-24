<?php

use App\Http\Controllers\BuscaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SerieController;
use Illuminate\Support\Facades\Route;

// Rota Inicial Pública (Se quiser que mande direto para a tela do Breeze ou Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Rota do Dashboard padrão do Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- TODAS AS SUAS ROTAS ANTIGAS PROTEGIDAS PELO LOGIN ---
Route::middleware('auth')->group(function () {
    
    // Perfil do Usuário (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Suas Rotas de Filmes
    Route::get('/filmes', [FilmeController::class, 'index'])->name('filmes.index');
    Route::get('/filmes/create', [FilmeController::class, 'create'])->name('filmes.create');
    Route::post('/filmes', [FilmeController::class, 'store'])->name('filmes.store');
    Route::get('/filmes/{id}/edit', [FilmeController::class, 'edit'])->name('filmes.edit');
    Route::put('/filmes/{id}', [FilmeController::class, 'update'])->name('filmes.update');
    Route::get('/filmes/{id}', [FilmeController::class, 'show'])->name('filmes.show');
    Route::delete('/filmes/{id}', [FilmeController::class, 'destroy'])->name('filmes.destroy');

    // Suas Rotas de Séries
    Route::get('/series', [SerieController::class, 'index'])->name('series.index');
    Route::get('/series/create', [SerieController::class, 'create'])->name('series.create');
    Route::post('/series', [SerieController::class, 'store'])->name('series.store');
    Route::get('/series/{id}/edit', [SerieController::class, 'edit'])->name('series.edit');
    Route::put('/series/{id}', [SerieController::class, 'update'])->name('series.update');
    Route::get('/series/{id}', [SerieController::class, 'show'])->name('series.show');
    Route::delete('/series/{id}', [SerieController::class, 'destroy'])->name('series.destroy');

    // Suas Rotas de Favoritos
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
    Route::get('/favoritos/create', [FavoritoController::class, 'create'])->name('favoritos.create');
    Route::post('/favoritos', [FavoritoController::class, 'store'])->name('favoritos.store');
    Route::get('/favoritos/{favorito}/edit', [FavoritoController::class, 'edit'])->name('favoritos.edit');
    Route::put('/favoritos/{favorito}', [FavoritoController::class, 'update'])->name('favoritos.update');
    Route::delete('/favoritos/{id}', [FavoritoController::class, 'destroy'])->name('favoritos.destroy');

    // Sua Rota de Busca (Consertada e fechada corretamente)
    Route::resource('busca', BuscaController::class);

    Route::resource('playlists', PlaylistController::class);
});

// Puxa as rotas de login/cadastro por fora
require __DIR__.'/auth.php';

Route::get('/php-info', function() {
    return phpinfo();
});