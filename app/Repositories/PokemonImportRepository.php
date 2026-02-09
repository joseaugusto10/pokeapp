<?php

namespace App\Repositories;

use App\Models\Pokemon;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

class PokemonImportRepository
{
    protected $pokemon;

    public function __construct(Pokemon $pokemon)
    {
        $this->pokemon = $pokemon;
    }

    public function importar($pokemonData, $typeNames = [])
    {
        return DB::transaction(function () use ($pokemonData, $typeNames) {

            $pokemon = $this->pokemon->updateOrCreate(
                ['api_id' => ($pokemonData['api_id'] ?? 0)],
                [
                    'name' => (string) ($pokemonData['name'] ?? ''),
                    'height' => $pokemonData['height'] ?? null,
                    'weight' => $pokemonData['weight'] ?? null,
                    'sprite' => $pokemonData['sprite'] ?? null,
                ]
            );

            $idsTipos = [];

            foreach (($typeNames ?? []) as $nomeTipo) {
                $nomeTipo = trim($nomeTipo);
                if (! $nomeTipo) {
                    continue;
                }

                $tipo = Type::firstOrCreate(['name' => $nomeTipo]);
                $idsTipos[] = $tipo->id;
            }

            if (! empty($idsTipos)) {
                $pokemon->types()->sync($idsTipos);
            }

            return $pokemon;
        });
    }

    public function listar($perPage = 10, $userId = null, $pesquisar = null)
    {
        $query = $this->pokemon
            ->with([
                'types:id,name',
                'favoritos' => function ($q) use ($userId) {
                    if ($userId) {
                        $q->where('user_id', $userId);
                    } else {
                        $q->whereRaw('1=0');
                    }
                },
            ]);

        $pesquisar = trim((string) $pesquisar);

        if ($pesquisar !== '') {
            $query->where(function ($w) use ($pesquisar) {
                $w->where('name', 'like', '%'.$pesquisar.'%');

                if (ctype_digit($pesquisar)) {
                    $w->orWhere('api_id', $pesquisar);
                }
            });
        }

        return $query
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function buscarPorApiId($apiId)
    {
        return $this->pokemon
            ->with('types:id,name')
            ->where('api_id', $apiId)
            ->first();
    }

    public function remover($apiId)
    {
        $pokemon = $this->pokemon->where('api_id', $apiId)->first();

        if (! $pokemon) {
            return false;
        }

        return $pokemon->delete();
    }
}
