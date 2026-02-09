<x-app-layout>
    <body class="min-h-screen bg-gray-50 text-gray-900">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">Detalhes do Pokémon</h1>
                    <p class="text-sm text-gray-500">Informações completas (PokeAPI)</p>
                </div>

                <div class="flex flex-wrap gap-2">

                    @can('importar-pokemon')
                        @if (!empty($pokemon) && empty($jaImportado))
                            <form method="POST" action="{{ route('pokemon.importar') }}">
                                @csrf

                                <input type="hidden" name="api_id" value="{{ $pokemon['id'] ?? '' }}">
                                <input type="hidden" name="name" value="{{ $pokemon['name'] ?? '' }}">
                                <input type="hidden" name="height" value="{{ $pokemon['height'] ?? '' }}">
                                <input type="hidden" name="weight" value="{{ $pokemon['weight'] ?? '' }}">
                                <input type="hidden" name="sprite"
                                    value="{{ $pokemon['sprites']['front_default'] ?? '' }}">

                                @foreach ($pokemon['types'] ?? [] as $t)
                                    <input type="hidden" name="types[]" value="{{ $t['type']['name'] ?? '' }}">
                                @endforeach

                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white
                       hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                    Importar
                                </button>
                            </form>
                        @endif
                    @endcan

                    @can('excluir-pokemon')
                        @if (!empty($pokemon) && !empty($jaImportado))
                            <form method="POST"
                                action="{{ route('pokemon.importados.remover', ['apiId' => $pokemon['id']]) }}"
                                class="form-remover" data-confirm-title="Remover dos importados?"
                                data-confirm-text="Esse Pokémon vai sair da sua lista de importados.">

                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white
                                        hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200">
                                    Remover importação
                                </button>
                            </form>
                        @endif
                    @endcan
                    @can('favoritar-pokemon')
                        @if (!empty($pokemon) && !empty($jaImportado) && empty($jaFavorito))
                            <form method="POST" action="{{ route('pokemon.favoritos.favoritar') }}">
                                @csrf
                                <input type="hidden" name="pokemon_id" value="{{ $pokemonDb->id ?? '' }}">

                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white
                                        hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    Favoritar
                                </button>
                            </form>
                        @endif
                    @endcan

                    @can('remover-pokemon-favorito')
                        @if (!empty($pokemon) && !empty($jaImportado) && !empty($jaFavorito))
                            <form method="POST"
                                action="{{ route('pokemon.favoritos.remover', ['pokemonId' => $pokemonDb->id]) }}"
                                class="form-remover" data-confirm-title="Remover dos favoritos?"
                                data-confirm-text="Esse Pokémon vai sair da sua lista de favoritos.">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white
                                        hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-200">
                                    Desfavoritar
                                </button>
                            </form>
                        @endif
                    @endcan

                    @can('favoritar-pokemon')
                        @if (!empty($pokemon) && empty($jaImportado))
                            <button type="button" disabled
                                class="inline-flex items-center justify-center rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 cursor-not-allowed">
                                Favoritar (importe antes)
                            </button>
                        @endif
                    @endcan


                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-800
                                 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        Voltar
                    </a>

                </div>
            </div>

            @if ($erro)
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <strong class="font-semibold">Ops!</strong> {{ $erro }}
                </div>
            @endif

            @if (!$pokemon)
                <div class="rounded-2xl bg-white p-8 text-center shadow-sm ring-1 ring-gray-200">
                    <div class="text-sm text-gray-600">Não foi possível carregar os dados.</div>
                </div>
            @else
                @php
                    $nome = $pokemon['name'] ?? '';
                    $spriteFront = $pokemon['sprites']['front_default'] ?? null;
                    $spriteBack = $pokemon['sprites']['back_default'] ?? null;
                @endphp

                <div class="mb-6 rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3 md:items-center">

                            <div class="flex flex-col items-center justify-center">
                                @if ($spriteFront)
                                    <img src="{{ $spriteFront }}" alt="Sprite {{ $nome }}"
                                        class="max-h-56 w-auto drop-shadow" loading="lazy">
                                @else
                                    <div class="text-sm text-gray-500">Sem sprite disponível.</div>
                                @endif

                                @if ($spriteBack)
                                    <div class="mt-3">
                                        <img src="{{ $spriteBack }}" alt="Sprite (back) {{ $nome }}"
                                            class="max-h-36 w-auto opacity-90 drop-shadow" loading="lazy">
                                    </div>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h2 class="text-xl font-semibold capitalize">{{ $nome }}</h2>
                                        <div class="mt-1 text-sm text-gray-600">
                                            Altura: <strong
                                                class="text-gray-900">{{ $pokemon['height'] ?? '-' }}</strong>
                                            <span class="mx-1">•</span>
                                            Peso: <strong
                                                class="text-gray-900">{{ $pokemon['weight'] ?? '-' }}</strong>
                                            <span class="mx-1">•</span>
                                            Base Exp: <strong
                                                class="text-gray-900">{{ $pokemon['base_experience'] ?? '-' }}</strong>
                                        </div>
                                    </div>

                                    <span
                                        class="inline-flex items-center rounded-full bg-indigo-600 px-3 py-1 text-xs font-semibold text-white">
                                        #{{ $pokemon['id'] ?? '-' }}
                                    </span>
                                </div>

                                <div class="my-6 h-px w-full bg-gray-200"></div>

                                <div class="text-sm font-semibold text-gray-900">Tipos</div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($pokemon['types'] ?? [] as $t)
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-900 px-3 py-1 text-xs font-medium text-white capitalize">
                                            {{ $t['type']['name'] ?? 'tipo' }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="mt-6 text-sm font-semibold text-gray-900">Habilidades</div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($pokemon['abilities'] ?? [] as $a)
                                        <span
                                            class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-800 capitalize ring-1 ring-gray-200">
                                            <span>{{ $a['ability']['name'] ?? 'habilidade' }}</span>

                                            @if (!empty($a['is_hidden']))
                                                <span
                                                    class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-semibold text-amber-900 ring-1 ring-amber-200">
                                                    hidden
                                                </span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                        <div class="p-6">
                            <h3 class="text-sm font-semibold text-gray-900">Nível</h3>

                            <div class="mt-4 space-y-3">
                                @foreach ($pokemon['stats'] ?? [] as $s)
                                    @php
                                        $statName = $s['stat']['name'] ?? 'stat';
                                        $base = (int) ($s['base_stat'] ?? 0);
                                        $percent = min(100, (int) round(($base / 200) * 100));
                                    @endphp

                                    <div>
                                        <div class="mb-1 flex items-center justify-between text-xs text-gray-600">
                                            <span class="capitalize">{{ $statName }}</span>
                                            <span class="font-semibold text-gray-900">{{ $base }}</span>
                                        </div>

                                        <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                                            <div class="h-2 rounded-full bg-indigo-600"
                                                style="width: {{ $percent }}%" role="progressbar"
                                                aria-label="{{ $statName }}" aria-valuenow="{{ $percent }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                        <div class="p-6">
                            <h3 class="text-sm font-semibold text-gray-900">Movimentos (primeiros 12)</h3>

                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach (array_slice($pokemon['moves'] ?? [], 0, 12) as $m)
                                    <span
                                        class="inline-flex items-center rounded-full bg-white px-3 py-1 text-xs font-medium text-gray-800 capitalize ring-1 ring-gray-200">
                                        {{ $m['move']['name'] ?? 'move' }}
                                    </span>
                                @endforeach
                            </div>

                            @if (count($pokemon['moves'] ?? []) > 12)
                                <div class="mt-3 text-xs text-gray-500">
                                    +{{ count($pokemon['moves'] ?? []) - 12 }} movimentos…
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            @endif

        </div>
</x-app-layout>
