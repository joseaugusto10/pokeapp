<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function metricas()
    {

        $totalUsuarios = DB::table('users')->count();
        $totalPokemons = DB::table('pokemons')->count();
        $totalFavoritos = DB::table('pokemon_user_favorite')->count();
        $usuariosComFavoritos = DB::table('pokemon_user_favorite')->distinct('user_id')->count('user_id');

        $topPokemons = DB::table('pokemon_user_favorite as f')
            ->join('pokemons as p', 'p.id', '=', 'f.pokemon_id')
            ->select('p.id', 'p.api_id', 'p.name', 'p.sprite', DB::raw('COUNT(*) as total'))
            ->groupBy('p.id', 'p.api_id', 'p.name', 'p.sprite')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topTipos = DB::table('pokemon_user_favorite as f')
            ->join('pokemon_type as pt', 'pt.pokemon_id', '=', 'f.pokemon_id')
            ->join('types as t', 't.id', '=', 'pt.type_id')
            ->select('t.id', 't.name', DB::raw('COUNT(*) as total'))
            ->groupBy('t.id', 't.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topUsuarios = DB::table('pokemon_user_favorite as f')
            ->join('users as u', 'u.id', '=', 'f.user_id')
            ->select('u.id', 'u.name', 'u.email', DB::raw('COUNT(*) as total'))
            ->groupBy('u.id', 'u.name', 'u.email')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $ultimosFavoritos = DB::table('pokemon_user_favorite as f')
            ->join('users as u', 'u.id', '=', 'f.user_id')
            ->join('pokemons as p', 'p.id', '=', 'f.pokemon_id')
            ->select(
                'f.created_at',
                'u.name as user_name',
                'u.email as user_email',
                'p.name as pokemon_name',
                'p.api_id',
                'p.sprite'
            )
            ->orderByDesc('f.created_at')
            ->limit(5)
            ->get();

        $ultimosImportados = DB::table('pokemons')
            ->select('id', 'api_id', 'name', 'sprite', 'created_at')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();


        return [
            'cards' => [
                'Total usuários' => $totalUsuarios,
                'Pokémons importados' => $totalPokemons,
                'Total de favoritos' => $totalFavoritos,
                'Usuários com favoritos' => $usuariosComFavoritos
            ],

            'topPokemons' => $topPokemons,
            'topTipos' => $topTipos,
            'topUsuarios' => $topUsuarios,
            'ultimosFavoritos' => $ultimosFavoritos,
            'ultimosImportados' => $ultimosImportados,
        ];
    }
}
