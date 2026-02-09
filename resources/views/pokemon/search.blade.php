<x-app-layout>
    <body class="min-h-screen bg-gray-50 text-gray-900">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">Resultado da busca</h1>
                    <p class="text-sm text-gray-500">
                        Pesquisa: <strong class="text-gray-900">{{ $pesquisa }}</strong>
                    </p>
                </div>

                <a href="{{ route('pokemon.listar') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-800
                   hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    Voltar
                </a>
            </div>

            @if ($erro)
                <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                    <strong class="font-semibold">Atenção:</strong> {{ $erro }}
                </div>
            @endif

            @if (!$pokemon)
                <div class="rounded-2xl bg-white p-8 text-center shadow-sm ring-1 ring-gray-200">
                    <div class="text-sm text-gray-600">
                        Nada encontrado para <strong class="text-gray-900">{{ $pesquisa }}</strong>.
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('pokemon.listar') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white
                           hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            Ir para listagem
                        </a>
                    </div>
                </div>
            @else
                @php
                    $nome = $pokemon['name'] ?? '';
                    $sprite = $pokemon['sprites']['front_default'] ?? null;
                @endphp

                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="p-6">

                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold capitalize">{{ $nome }}</h2>

                                <div class="mt-1 text-sm text-gray-600">
                                    ID: <strong class="text-gray-900">{{ $pokemon['id'] ?? '-' }}</strong>
                                    <span class="mx-1">•</span>
                                    Altura: <strong class="text-gray-900">{{ $pokemon['height'] ?? '-' }}</strong>
                                    <span class="mx-1">•</span>
                                    Peso: <strong class="text-gray-900">{{ $pokemon['weight'] ?? '-' }}</strong>
                                </div>
                            </div>

                            <a href="{{ route('pokemon.detalhar', ['nome' => $nome]) }}"
                                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white
                               hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                Ver detalhes completos
                            </a>
                        </div>

                        <div class="my-6 h-px w-full bg-gray-200"></div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3 md:items-center">
                            <div class="flex items-center justify-center">
                                @if ($sprite)
                                    <img src="{{ $sprite }}" alt="Sprite {{ $nome }}"
                                        class="max-h-44 w-auto drop-shadow" loading="lazy">
                                @else
                                    <div class="text-sm text-gray-500">Sem sprite disponível.</div>
                                @endif
                            </div>

                            <div class="md:col-span-2">
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
                                            class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-800 capitalize ring-1 ring-gray-200">
                                            {{ $a['ability']['name'] ?? 'habilidade' }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endif

        </div>
</x-app-layout>
