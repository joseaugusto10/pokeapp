<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\PokemonFavoriteController;
use App\Http\Controllers\PokemonImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->can('ver-dashboard')
    ->name('dashboard');

Route::get('/usuarios', [UserController::class, 'index'])
        ->name('usuarios.index')
        ->middleware('can:gerenciar-usuarios');

    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])
        ->name('usuarios.edit')
        ->middleware('can:gerenciar-usuarios');

    Route::put('/usuarios/{id}', [UserController::class, 'update'])
        ->name('usuarios.update')
        ->middleware('can:gerenciar-usuarios');

    Route::put('/usuarios/{id}/role', [UserController::class, 'definirRole'])
        ->name('usuarios.role')
        ->middleware('can:gerenciar-usuarios');

    Route::delete('/usuarios/{id}/permissao', [UserController::class, 'removerPermissao'])
        ->name('usuarios.permissao.remover')
        ->middleware('can:gerenciar-usuarios');

    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])
        ->name('usuarios.destroy')
        ->middleware('can:gerenciar-usuarios');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pokemons', [PokemonController::class, 'listar'])
        ->name('pokemon.listar')
        ->middleware('can:listar-pokemon');

    Route::get('/pokemons/pesquisar', [PokemonController::class, 'pesquisar'])
        ->name('pokemon.pesquisar')
        ->middleware('can:pesquisar-pokemon');

    Route::get('/pokemons/{nome}', [PokemonController::class, 'detalhar'])
        ->name('pokemon.detalhar')
        ->middleware('can:listar-pokemon');

    Route::get('/pokemon/importados', [PokemonImportController::class, 'listar'])
        ->name('pokemon.importados')
        ->middleware('can:listar-pokemon');

    Route::post('/pokemon/importar', [PokemonImportController::class, 'importar'])
        ->name('pokemon.importar')
        ->middleware('can:importar-pokemon');

    Route::delete('/pokemon/importados/{apiId}', [PokemonImportController::class, 'remover'])
        ->name('pokemon.importados.remover')
        ->middleware('can:excluir-pokemon');

    Route::get('/pokemon/favoritos', [PokemonFavoriteController::class, 'listar'])
        ->name('pokemon.favoritos')
        ->middleware('can:listar-favoritos');

    Route::post('/pokemon/favoritos', [PokemonFavoriteController::class, 'favoritar'])
        ->name('pokemon.favoritos.favoritar')
        ->middleware('can:favoritar-pokemon');

    Route::delete('/pokemon/favoritos/{pokemonId}', [PokemonFavoriteController::class, 'remover'])
        ->name('pokemon.favoritos.remover')
        ->middleware('can:remover-pokemon-favorito');

});

require __DIR__.'/auth.php';
