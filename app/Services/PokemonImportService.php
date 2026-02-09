<?php

namespace App\Services;

use App\Repositories\PokemonImportRepository;
use Exception;

class PokemonImportService
{
    protected $pokemonImportRepository;

    public function __construct(PokemonImportRepository $pokemonImportRepository)
    {
        $this->pokemonImportRepository = $pokemonImportRepository;
    }

    public function importar($pokemon)
    {
        try {
            if (! $pokemon || empty($pokemon['id']) || empty($pokemon['name'])) {
                throw new Exception('Não foi possível importar: dados do Pokémon inválidos.');
            }

            $pokemonData = [
                'api_id' => $pokemon['id'],
                'name' => $pokemon['name'] ?? null,
                'height' => $pokemon['height'] ?? null,
                'weight' => $pokemon['weight'] ?? null,
                'sprite' => $pokemon['sprites']['front_default'] ?? null,
            ];

            $typeNames = [];

            foreach (($pokemon['types'] ?? []) as $t) {
                if (! empty($t['type']['name'])) {
                    $typeNames[] = $t['type']['name'];
                }
            }

            return $this->pokemonImportRepository->importar($pokemonData, $typeNames);

        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?: 'Erro ao importar Pokémon.');
        }
    }

    public function listar($perPage = 20, $userId = null, $pesquisar = null)
    {
        try {
            return $this->pokemonImportRepository->listar($perPage, $userId, $pesquisar);
        } catch (Exception $e) {
            throw new Exception('Não foi possível listar os pokémons.');
        }
    }

    public function buscarPorApiId($apiId)
    {
        try {
            if (! $apiId) {
                throw new Exception('Pokémon inválido.');
            }

            return $this->pokemonImportRepository->buscarPorApiId($apiId);

        } catch (Exception $e) {
            throw new Exception('Não foi possível buscar o Pokémon.');
        }
    }

    public function remover($apiId)
    {
        try {
            if (! $apiId) {
                throw new Exception('Pokémon inválido.');
            }

            return $this->pokemonImportRepository->remover($apiId);

        } catch (Exception $e) {
            throw new Exception('Não foi possível remover o Pokémon.');
        }
    }
}
