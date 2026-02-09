<?php

namespace App\Http\Controllers;

use App\Http\Requests\PokeApi\PokemonSearchRequest;
use App\Services\PokeApi\PokeApiClient;
use App\Services\PokemonFavoriteService;
use App\Services\PokemonImportService;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    protected $pokeApiClient;

    protected $pokemonImportService;

    protected $pokemonFavoriteService;

    public function __construct(PokeApiClient $pokeApiClient,
        PokemonImportService $pokemonImportService,
        PokemonFavoriteService $pokemonFavoriteService)
    {
        $this->pokeApiClient = $pokeApiClient;
        $this->pokemonImportService = $pokemonImportService;
        $this->pokemonFavoriteService = $pokemonFavoriteService;
    }

    public function listar(Request $request)
    {
        $limite = (int) $request->query('limit', 20);
        $offset = (int) $request->query('offset', 0);

        $dados = $this->pokeApiClient->listarPokemon($limite, $offset);

        if (! $dados) {
            return view('pokemon.index', [
                'itens' => [],
                'quantidadeTotal' => 0,
                'limite' => $limite,
                'offset' => $offset,
                'erro' => 'Não foi possível carregar a listagem agora. Tente novamente em instantes.',
            ]);
        }

        return view('pokemon.index', [
            'itens' => $dados['results'] ?? [],
            'quantidadeTotal' => $dados['count'] ?? 0,
            'limite' => $limite,
            'offset' => $offset,
            'erro' => null,
        ]);
    }

    public function pesquisar(PokemonSearchRequest $pokemonSearchRequest)
    {
        $pesquisa = strtolower(trim((string) $pokemonSearchRequest->input('pesquisa')));

        if ($pesquisa === '') {
            return redirect()->route('pokemon.listar');
        }

        $pokemon = $this->pokeApiClient->buscarPokemon($pesquisa);

        if (! $pokemon) {
            return view('pokemon.search', [
                'pesquisa' => $pesquisa,
                'pokemon' => null,
                'erro' => 'Pokémon não encontrado ou a API está indisponível.',
            ]);
        }

        return view('pokemon.search', [
            'pesquisa' => $pesquisa,
            'pokemon' => $pokemon,
            'erro' => null,
        ]);
    }

    public function detalhar(string $nome)
    {
        $pokemon = $this->pokeApiClient->buscarPokemon($nome);

        if (! $pokemon) {
            return view('pokemon.show', [
                'pokemon' => null,
                'erro' => 'Não foi possível carregar os detalhes do Pokémon agora.',
                'jaImportado' => false,
                'pokemonDb' => null,
                'jaFavorito' => false,
            ]);
        }

        $apiId = (int) ($pokemon['id'] ?? 0);

        $pokemonDb = null;
        $jaImportado = false;
        $jaFavorito = false;

        if ($apiId > 0) {
            $pokemonDb = $this->pokemonImportService->buscarPorApiId($apiId);
            $jaImportado = $pokemonDb !== null;

            if ($jaImportado) {
                $jaFavorito = $this->pokemonFavoriteService->jaFavorito($pokemonDb->id, auth()->id());
            }
        }

        return view('pokemon.show', [
            'pokemon' => $pokemon,
            'jaImportado' => $jaImportado,
            'pokemonDb' => $pokemonDb,
            'jaFavorito' => $jaFavorito,
            'erro' => null,
        ]);
    }
}
