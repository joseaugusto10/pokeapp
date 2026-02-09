<?php

namespace App\Http\Controllers;

use App\Http\Requests\PokemonImportRequest;
use App\Services\PokemonImportService;
use Exception;
use Illuminate\Http\Request;

class PokemonImportController extends Controller
{
    protected $pokemonImportService;

    public function __construct(PokemonImportService $pokemonImportService)
    {
        $this->pokemonImportService = $pokemonImportService;
    }

    public function listar(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $pesquisar = $request->query('pesquisar');

        $lista = $this->pokemonImportService->listar($perPage, auth()->id(), $pesquisar);

        return view('pokemon.importados', [
            'lista' => $lista,
        ]);
    }

    public function importar(PokemonImportRequest $request)
    {
        try {
            $pokemon = [
                'id' => $request->api_id,
                'name' => $request->name,
                'height' => $request->height,
                'weight' => $request->weight,
                'sprites' => [
                    'front_default' => $request->sprite,
                ],
                'types' => collect($request->types ?? [])
                    ->map(fn ($t) => ['type' => ['name' => $t]])
                    ->toArray(),
            ];

            $this->pokemonImportService->importar($pokemon);

            return back()->with('success', 'Pokémon importado com sucesso!');
        } catch (Exception $e) {
            return back()->with('erro', $e->getMessage());
        }
    }

    public function remover($apiId)
    {
        try {
            $ok = $this->pokemonImportService->remover($apiId);

            if (! $ok) {
                return back()->with('erro', 'Pokémon não encontrado no banco.');
            }

            return back()->with('success', 'Pokémon removido com sucesso!');
        } catch (Exception $e) {
            return back()->with('erro', 'Não foi possível remover agora.');
        }
    }
}
