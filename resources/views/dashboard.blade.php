<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold tracking-tight">Dashboard</h1>
            <p class="text-sm text-gray-500">Visão geral do sistema</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            @foreach ($cards as $label => $valor)
                <div
                    class="rounded-2xl bg-white p-6 ring-1 ring-gray-200 shadow-sm
                            flex flex-col items-center justify-center text-center">

                    <div class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                        {{ $label }}
                    </div>

                    <div class="mt-2 text-3xl font-semibold text-gray-900 leading-none">
                        {{ is_numeric($valor) ? number_format($valor, 0, ',', '.') : $valor }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="rounded-xl bg-white ring-1 ring-gray-200 shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">Top 5 Pokémons Favoritados</h2>

                @forelse($topPokemons as $p)
                    <div class="flex items-center justify-between py-2 border-b last:border-0">
                        <div class="flex items-center gap-3">
                            @if ($p->sprite)
                                <img src="{{ $p->sprite }}" class="h-8 w-8">
                            @endif
                            <span class="capitalize">{{ $p->name }}</span>
                        </div>

                        <span class="text-sm text-gray-500">{{ $p->total }}</span>
                    </div>
                @empty
                    <div class="text-sm text-gray-500">Sem dados.</div>
                @endforelse
            </div>

            <div class="rounded-xl bg-white ring-1 ring-gray-200 shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">Top 5 Tipos Favoritados</h2>

                @forelse($topTipos as $t)
                    <div class="flex items-center justify-between py-2 border-b last:border-0">
                        <span class="capitalize">{{ $t->name }}</span>
                        <span class="text-sm text-gray-500">{{ $t->total }}</span>
                    </div>
                @empty
                    <div class="text-sm text-gray-500">Sem dados.</div>
                @endforelse
            </div>

            <div class="rounded-xl bg-white ring-1 ring-gray-200 shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">Usuários que mais favoritaram</h2>

                @forelse($topUsuarios as $u)
                    <div class="flex items-center justify-between py-2 border-b last:border-0">
                        <div>
                            <div class="text-sm">{{ $u->name }}</div>
                            <div class="text-xs text-gray-500">{{ $u->email }}</div>
                        </div>

                        <span class="text-sm text-gray-500">{{ $u->total }}</span>
                    </div>
                @empty
                    <div class="text-sm text-gray-500">Sem dados.</div>
                @endforelse
            </div>

            <div class="rounded-xl bg-white ring-1 ring-gray-200 shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">Últimos 5 Favoritos</h2>

                @forelse($ultimosFavoritos as $f)
                    <div class="py-2 border-b last:border-0">
                        <div class="text-sm capitalize">{{ $f->pokemon_name }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $f->user_name }} — {{ \Carbon\Carbon::parse($f->created_at)->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500">Sem dados.</div>
                @endforelse
            </div>

            <div class="rounded-xl bg-white ring-1 ring-gray-200 shadow-sm p-4 lg:col-span-2">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">Últimos Pokémons Importados</h2>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach ($ultimosImportados as $p)
                        <div class="flex flex-col items-center text-center">
                            @if ($p->sprite)
                                <img src="{{ $p->sprite }}" class="h-12 w-12">
                            @endif
                            <div class="text-xs capitalize mt-1">{{ $p->name }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
