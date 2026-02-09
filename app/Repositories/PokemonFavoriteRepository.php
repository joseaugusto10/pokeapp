<?php

namespace App\Repositories;

use App\Models\Pokemon;
use Illuminate\Support\Facades\DB;

class PokemonFavoriteRepository
{
    protected $pokemon;

    public function __construct(Pokemon $pokemon)
    {
        $this->pokemon = $pokemon;
    }

    public function favoritar($pokemonId, $userId)
    {
        return DB::transaction(function () use ($pokemonId, $userId) {

            $pokemon = $this->pokemon->find($pokemonId);

            if (! $pokemon) {
                throw new \Exception('Pokémon não encontrado.');
            }

            if ($pokemon->favoritos()->where('user_id', $userId)->exists()) {
                return $pokemon;
            }

            $pokemon->favoritos()->attach($userId);

            return $pokemon;
        });
    }

    public function listar($userId, $perPage = 10, $pesquisar = null)
    {
        $query = Pokemon::query()
            ->whereHas('favoritos', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });

        $pesquisar = trim((string) $pesquisar);

        if ($pesquisar !== '') {
            $query->where(function ($w) use ($pesquisar) {
                $w->where('name', 'like', '%'.$pesquisar.'%');

                if (ctype_digit($pesquisar)) {
                    $w->orWhere('api_id', (int) $pesquisar);
                }
            });
        }

        return $query->orderBy('name')->paginate($perPage);
    }

    public function remover($pokemonId, $userId)
    {
        $pokemon = $this->pokemon->find($pokemonId);

        if (! $pokemon) {
            return false;
        }

        $pokemon->favoritos()->detach($userId);

        return true;
    }

    public function existe($pokemonId, $userId)
    {
        $pokemon = $this->pokemon->find($pokemonId);

        if (! $pokemon) {
            return false;
        }

        return $pokemon->favoritos()
            ->where('user_id', $userId)
            ->exists();
    }
}
