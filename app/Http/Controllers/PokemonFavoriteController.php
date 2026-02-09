<?php

namespace App\Http\Controllers;

use App\Services\PokemonFavoriteService;
use Exception;
use Illuminate\Http\Request;

class PokemonFavoriteController extends Controller
{
    protected $pokemonFavoriteService;

    public function __construct(PokemonFavoriteService $pokemonFavoriteService)
    {
        $this->pokemonFavoriteService = $pokemonFavoriteService;
    }

    public function listar(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 20);
            $userId = auth()->id();
            $pesquisar = $request->query('pesquisar');

            $lista = $this->pokemonFavoriteService->listar($userId, $perPage, $pesquisar);

            return view('pokemon.favoritos', [
                'lista' => $lista,
            ]);
        } catch (Exception $e) {
            return back()->with('erro', $e->getMessage());
        }
    }

    public function favoritar(Request $request)
    {
        try {
            $pokemonId = $request->input('pokemon_id');
            $userId = auth()->id();

            $this->pokemonFavoriteService->favoritar($pokemonId, $userId);

            return back()->with('success', 'Pokémon favoritado com sucesso!');
        } catch (Exception $e) {
            return back()->with('erro', $e->getMessage());
        }
    }

    public function remover(Request $request, $pokemonId)
    {
        try {

            $userId = auth()->id();
            $ok = $this->pokemonFavoriteService->remover($pokemonId, $userId);

            if (! $ok) {
                return back()->with('erro', 'Favorito não encontrado para remover.');
            }

            return back()->with('success', 'Favorito removido com sucesso!');
        } catch (Exception $e) {
            return back()->with('erro', 'Não foi possível remover agora.');
        }
    }
}
