<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::define('gerenciar-usuarios', fn($user) => $user->hasRole('admin'));
        Gate::define('excluir-pokemon', fn($user) => $user->hasRole('admin'));
        Gate::define('ver-dashboard', fn($user) => $user->hasRole('admin'));


        Gate::define('importar-pokemon', fn($user) => $user->hasAnyRole(['admin', 'editor']));
        Gate::define('listar-favoritos', fn($user) => $user->hasAnyRole(['admin', 'editor']));
        Gate::define('favoritar-pokemon', fn($user) => $user->hasAnyRole(['admin', 'editor']));
        Gate::define('remover-pokemon-favorito', fn($user) => $user->hasAnyRole(['admin', 'editor']));

        Gate::define('listar-pokemon', fn($user) => $user->hasAnyRole(['admin', 'editor', 'viewer']));
        Gate::define('pesquisar-pokemon', fn($user) => $user->hasAnyRole(['admin', 'editor', 'viewer']));
    }
}
