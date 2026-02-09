<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Pokémons importados</h1>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pokemon.listar') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-800
                          hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    Ver PokeAPI
                </a>
            </div>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="p-5">

                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-5">
                    <div class="text-sm text-gray-600">
                        Total: <strong
                            class="text-gray-900">{{ number_format((int) ($lista->total() ?? 0), 0, ',', '.') }}</strong>
                        <span class="mx-1">/</span>
                        Quantidade <strong class="text-gray-900">{{ (int) ($lista->perPage() ?? 0) }}</strong> por
                        página
                    </div>

                    @php
                        $perPageAtual = request()->query('per_page', $lista->perPage() ?? 20);
                        $pesquisar = trim((string) request()->query('pesquisar', ''));
                    @endphp

                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:gap-3">

                        <form method="GET" action="{{ route('pokemon.importados') }}"
                            class="flex flex-col gap-2 md:flex-row md:items-center md:gap-2">

                            <input type="text" name="pesquisar" value="{{ $pesquisar }}"
                                placeholder="Pesquisar por nome ou ID (ex: pikachu ou 25)"
                                class="w-full md:w-72 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm
                                        outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                maxlength="40">

                            <input type="hidden" name="per_page" value="{{ (int) $perPageAtual }}">

                            <button
                                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white
                                        hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                type="submit">
                                Buscar
                            </button>

                            @if ($pesquisar !== '')
                                <a href="{{ route('pokemon.importados', ['per_page' => $perPageAtual]) }}"
                                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50">
                                    Limpar
                                </a>
                            @endif
                        </form>

                        <form method="GET" action="{{ route('pokemon.importados') }}" class="flex items-center gap-2">
                            <label class="text-xs text-gray-500">Por página:</label>

                            <select name="per_page"
                                class="rounded-lg border border-gray-300 bg-white px-3 pr-10 py-2 text-sm
                                        outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                                @foreach ([10, 20, 30, 50, 100] as $opt)
                                    <option value="{{ $opt }}" @selected($perPageAtual === $opt)>{{ $opt }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="hidden" name="pesquisar" value="{{ $pesquisar }}">

                            <button
                                class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-800
                                        hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                type="submit">
                                Aplicar
                            </button>
                        </form>

                    </div>
                </div>

                @if (!$lista || $lista->count() === 0)
                    <div class="flex flex-col items-center justify-center py-16">
                        <div class="text-sm text-gray-500">Nenhum Pokémon importado ainda.</div>
                        <a href="{{ route('pokemon.listar') }}"
                            class="mt-4 inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white
                                  hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                            Importar agora
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($lista as $p)
                            @php
                                $apiId = $p->api_id ?? ($p->apiId ?? null);
                                $nome = $p->name ?? '';
                                $sprite = $p->sprite ?? null;
                            @endphp
                            @php
                                $pokemonIdBanco = $p->id ?? null;
                                $jaFavorito = !empty($p->favoritos) && $p->favoritos->isNotEmpty();
                            @endphp

                            <div
                                class="h-full rounded-2xl bg-white p-4 ring-1 ring-gray-200 shadow-sm transition hover:shadow-md hover:ring-indigo-200">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200">
                                        Importado
                                    </span>

                                    @if ($apiId)
                                        <span class="text-xs text-gray-500">
                                            id: {{ $apiId }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 flex flex-col items-center gap-3">
                                    @if ($sprite)
                                        <img src="{{ $sprite }}" alt="Sprite {{ $nome }}"
                                            class="h-24 w-24 drop-shadow" loading="lazy">
                                    @else
                                        <div
                                            class="h-24 w-24 rounded-xl bg-gray-100 ring-1 ring-gray-200 flex items-center justify-center text-xs text-gray-500">
                                            sem sprite
                                        </div>
                                    @endif

                                    <h2 class="text-lg font-semibold text-gray-900 capitalize text-center">
                                        {{ $nome }}
                                    </h2>
                                </div>

                                <div class="mt-4 space-y-2">
                                    <div class="grid grid-cols-2 gap-2">
                                        @if (!empty($nome))
                                            <a href="{{ route('pokemon.detalhar', ['nome' => $nome]) }}"
                                                class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-800
                      hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                                Detalhes
                                            </a>
                                        @else
                                            <span
                                                class="inline-flex w-full items-center justify-center rounded-lg bg-gray-100 px-3 py-2 text-sm text-gray-500">
                                                Detalhes
                                            </span>
                                        @endif

                                        @can('favoritar-pokemon')
                                            @if ($pokemonIdBanco && empty($jaFavorito))
                                                <form method="POST" action="{{ route('pokemon.favoritos.favoritar') }}"
                                                    class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="pokemon_id" value="{{ $pokemonIdBanco }}">

                                                    <button type="submit"
                                                        class="inline-flex w-full items-center justify-center rounded-lg bg-amber-500 px-3 py-2 text-sm font-semibold text-white
                                                            hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                                        Favoritar
                                                    </button>
                                                </form>
                                            @elseif ($pokemonIdBanco && !empty($jaFavorito))
                                                @can('remover-pokemon-favorito')
                                                    <form method="POST"
                                                        action="{{ route('pokemon.favoritos.remover', ['pokemonId' => $pokemonIdBanco]) }}"
                                                        class="form-remover w-full" data-confirm-title="Remover dos favoritos?"
                                                        data-confirm-text="Esse Pokémon vai sair da sua lista de favoritos.">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-3 py-2 text-sm font-semibold text-white
                                                                    hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-200">
                                                            Desfavoritar
                                                        </button>
                                                    </form>
                                                @endcan
                                            @else
                                                <span
                                                    class="inline-flex w-full items-center justify-center rounded-lg bg-gray-100 px-3 py-2 text-sm text-gray-500">
                                                    Favoritar
                                                </span>
                                            @endif
                                        @endcan
                                    </div>

                                    @can('excluir-pokemon')
                                        @if ($apiId)
                                            <form method="POST"
                                                action="{{ route('pokemon.importados.remover', ['apiId' => $apiId]) }}"
                                                class="form-remover w-full" data-confirm-title="Remover dos importados?"
                                                data-confirm-text="Esse Pokémon vai sair da sua lista de importados.">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white
                                                        hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200">
                                                    Remover importação
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div class="text-xs text-gray-500">
                            Página: <strong class="text-gray-900">{{ $lista->currentPage() }}</strong>
                            <span class="mx-1">/</span>
                            Última: <strong class="text-gray-900">{{ $lista->lastPage() }}</strong>
                        </div>

                        @php
                            $perPageAtual = (int) request()->query('per_page', $lista->perPage() ?? 20);

                            $hasPrev = $lista->currentPage() > 1;
                            $hasNext = $lista->hasMorePages();

                            $prevUrl = $hasPrev
                                ? $lista->appends(['per_page' => $perPageAtual])->previousPageUrl()
                                : '#';
                            $nextUrl = $hasNext ? $lista->appends(['per_page' => $perPageAtual])->nextPageUrl() : '#';
                        @endphp

                        <div class="mt-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                            <div class="flex gap-2">
                                <a class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium
                                    border border-gray-300 bg-white text-gray-800 hover:bg-gray-50
                                    focus:outline-none focus:ring-2 focus:ring-indigo-200
                                    @if (!$hasPrev) pointer-events-none opacity-50 @endif"
                                    href="{{ $prevUrl }}">
                                    Anterior
                                </a>

                                <a class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium
                                    border border-gray-300 bg-white text-gray-800 hover:bg-gray-50
                                    focus:outline-none focus:ring-2 focus:ring-indigo-200
                                    @if (!$hasNext) pointer-events-none opacity-50 @endif"
                                    href="{{ $nextUrl }}">
                                    Próxima
                                </a>
                            </div>
                        </div>

                    </div>
                @endif

            </div>
        </div>

    </div>
</x-app-layout>
