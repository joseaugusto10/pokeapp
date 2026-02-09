<?php

namespace App\Services;

use App\Repositories\PokemonFavoriteRepository;
use Exception;

class PokemonFavoriteService
{
    protected $pokemonFavoriteRepository;

    public function __construct(PokemonFavoriteRepository $pokemonFavoriteRepository)
    {
        $this->pokemonFavoriteRepository = $pokemonFavoriteRepository;
    }

    public function favoritar($pokemonId, $userId)
    {
        try {
            if (! $pokemonId || ! $userId) {
                throw new Exception('Dados inválidos para favoritar.');
            }

            return $this->pokemonFavoriteRepository->favoritar($pokemonId, $userId);

        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?: 'Erro ao favoritar Pokémon.');
        }
    }

    public function listar($userId, $perPage = 10, $pesquisar = null)
    {
        try {
            if (! $userId) {
                throw new Exception('Usuário inválido.');
            }

            if ($perPage <= 0) {
                $perPage = 10;
            }

            return $this->pokemonFavoriteRepository->listar($userId, $perPage, $pesquisar);

        } catch (Exception $e) {
            throw new Exception('Não foi possível listar favoritos.');
        }
    }

    public function remover($pokemonId, $userId)
    {
        try {
            if (! $pokemonId || ! $userId) {
                throw new Exception('Dados inválidos para remover favorito.');
            }

            return $this->pokemonFavoriteRepository->remover($pokemonId, $userId);

        } catch (Exception $e) {
            throw new Exception('Não foi possível remover favorito.');
        }
    }

    public function jaFavorito($pokemonId, $userId)
    {
        try {
            if (! $pokemonId || ! $userId) {
                return false;
            }

            return $this->pokemonFavoriteRepository->existe($pokemonId, $userId);

        } catch (Exception $e) {
            return false;
        }
    }
}
