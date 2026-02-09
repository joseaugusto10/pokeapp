<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="p-5">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-5">
                    <div class="text-sm text-gray-600">
                        Total: <strong class="text-gray-900">{{ number_format($quantidadeTotal, 0, ',', '.') }}</strong>
                        <span class="mx-1">/</span>
                        Quantidade <strong class="text-gray-900">{{ $limite }}</strong> por página
                    </div>

                    @php
                        $pesquisa = trim((string) request()->query('pesquisa', ''));
                    @endphp

                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:gap-3">
                        <form class="flex w-full md:w-auto gap-2" method="GET"
                            action="{{ route('pokemon.pesquisar') }}">
                            <input
                                class="w-full md:w-72 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm
                                        outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                type="text" name="pesquisa" placeholder="Buscar por nome ou ID (ex: pikachu ou 25)"
                                value="{{ $pesquisa }}" maxlength="40">

                            <button
                                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white
                                        hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                                type="submit">
                                Buscar
                            </button>
                        </form>

                        <form method="GET" action="{{ route('pokemon.listar') }}" class="flex items-center gap-2">
                            <label class="text-xs text-gray-500">Limite:</label>

                            <select name="limit"
                                class="rounded-lg border border-gray-300 bg-white px-3 pr-10 py-2 text-sm
                                        outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                                @foreach ([10, 20, 30, 50, 100] as $opt)
                                    <option value="{{ $opt }}" @selected((int) $limite === $opt)>{{ $opt }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="hidden" name="offset" value="{{ (int) $offset }}">

                            <button
                                class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-800
                                        hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                type="submit">
                                Aplicar
                            </button>
                        </form>

                    </div>
                </div>


                @if (empty($itens))
                    <div class="flex flex-col items-center justify-center py-16">
                        <div class="text-sm text-gray-500">Nenhum Pokémon para mostrar.</div>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($itens as $item)
                            @php
                                $nome = $item['name'] ?? '';
                            @endphp

                            <a href="{{ route('pokemon.detalhar', ['nome' => $nome]) }}" class="group block">
                                <div
                                    class="h-full rounded-2xl bg-white p-4 ring-1 ring-gray-200 shadow-sm transition
                                        hover:shadow-md hover:ring-indigo-200">
                                    <div class="flex items-center justify-between">
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                            Pokémon
                                        </span>
                                        <span class="text-xs text-gray-500 group-hover:text-indigo-600">
                                            Detalhes
                                        </span>
                                    </div>

                                    <h2 class="mt-3 text-lg font-semibold text-gray-900 capitalize">
                                        {{ $nome }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Clique para ver tipos, stats e sprite.
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @php
                        $limite = (int) $limite;
                        $offset = (int) $offset;
                        $total = (int) $quantidadeTotal;

                        $prevOffset = max(0, $offset - $limite);
                        $nextOffset = $offset + $limite;

                        $hasPrev = $offset > 0;
                        $hasNext = $nextOffset < $total;
                    @endphp

                    <div class="mt-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div class="text-xs text-gray-500">
                            Página: <strong
                                class="text-gray-900">{{ (int) floor($offset / max($limite, 1)) + 1 }}</strong>
                            @if ($total > 0)
                                <span class="mx-1">/</span>
                                Última: <strong
                                    class="text-gray-900">{{ (int) ceil($total / max($limite, 1)) }}</strong>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <a class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium
                                   border border-gray-300 bg-white text-gray-800 hover:bg-gray-50
                                   focus:outline-none focus:ring-2 focus:ring-indigo-200
                                   @if (!$hasPrev) pointer-events-none opacity-50 @endif"
                                href="{{ $hasPrev ? route('pokemon.listar', ['limit' => $limite, 'offset' => $prevOffset]) : '#' }}">
                                Anterior
                            </a>

                            <a class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium
                                   border border-gray-300 bg-white text-gray-800 hover:bg-gray-50
                                   focus:outline-none focus:ring-2 focus:ring-indigo-200
                                   @if (!$hasNext) pointer-events-none opacity-50 @endif"
                                href="{{ $hasNext ? route('pokemon.listar', ['limit' => $limite, 'offset' => $nextOffset]) : '#' }}">
                                Próxima
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
</x-app-layout>
