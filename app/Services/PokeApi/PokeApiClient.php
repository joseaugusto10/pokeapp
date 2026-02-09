<?php

namespace App\Services\PokeApi;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PokeApiClient
{
    private string $baseUrl = 'https://pokeapi.co/api/v2';

    public function listarPokemon(int $limite = 20, int $offset = 0): ?array
    {
        $limite = max(1, min($limite, 50));
        $offset = max(0, $offset);

        $cacheKey = "pokeapi:listagem:limite={$limite}:offset={$offset}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($limite, $offset) {
            try {
                $response = Http::timeout(8)
                    ->acceptJson()
                    ->get("{$this->baseUrl}/pokemon", [
                        'limit' => $limite,
                        'offset' => $offset,
                    ]);

                if ($response->failed()) {
                    Log::warning('PokeAPI - falha na listagem', [
                        'status' => $response->status(),
                        'limite' => $limite,
                        'offset' => $offset,
                    ]);
                    return null;
                }

                return $response->json();
            } catch (ConnectionException $e) {
                Log::error('PokeAPI - erro de conexão na listagem', [
                    'limite' => $limite,
                    'offset' => $offset,
                    'message' => $e->getMessage(),
                ]);
                return null;
            }
        });
    }

    public function buscarPokemon(string $nomeOuId): ?array
    {
        $nomeOuId = strtolower(trim($nomeOuId));
        if ($nomeOuId === '') {
            return null;
        }

        $cacheKey = "pokeapi:pokemon:{$nomeOuId}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($nomeOuId) {
            try {
                $response = Http::timeout(8)
                    ->acceptJson()
                    ->get("{$this->baseUrl}/pokemon/{$nomeOuId}");

                if ($response->failed()) {
                    Log::warning('PokeAPI - falha ao buscar pokemon', [
                        'nomeOuId' => $nomeOuId,
                        'status' => $response->status(),
                    ]);
                    return null;
                }

                return $response->json();
            } catch (ConnectionException $e) {
                Log::error('PokeAPI - erro de conexão ao buscar pokemon', [
                    'nomeOuId' => $nomeOuId,
                    'message' => $e->getMessage(),
                ]);
                return null;
            }
        });
    }
}
