<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Gerenciar usuários</h1>
                <p class="text-sm text-gray-500">Lista de usuários e permissões</p>
            </div>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="p-5">

                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-5">

                    <div class="text-sm text-gray-600">
                        Total: <strong
                            class="text-gray-900">{{ number_format((int) ($lista->total() ?? 0), 0, ',', '.') }}</strong>
                        <span class="mx-1">/</span>
                        Quantidade <strong class="text-gray-900">{{ $lista->perPage() ?? 0 }}</strong> por página
                    </div>

                    <form method="GET" action="{{ route('usuarios.index') }}"
                        class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-2 w-full md:w-auto">
                        <input
                            class="w-full sm:w-80 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm
                                   outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                            type="text" name="pesquisa" placeholder="Buscar por nome ou e-mail"
                            value="{{ $pesquisa ?? '' }}" maxlength="80">
                        <button type="submit"
                            class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white
                                hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                            Buscar
                        </button>

                        @php
                            $perPageAtual = request()->query('per_page', $lista->perPage() ?? 20);
                        @endphp

                        <div class="flex items-center gap-2">
                            <label class="text-xs text-gray-500 whitespace-nowrap">Por página:</label>

                            <select name="per_page"
                                class="rounded-lg border border-gray-300 bg-white px-3 pr-10 py-2 text-sm
                                       outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                                @foreach ([10, 20, 30, 50, 100] as $opt)
                                    <option value="{{ $opt }}" @selected($perPageAtual === $opt)>{{ $opt }}
                                    </option>
                                @endforeach
                            </select>

                            <button
                                class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-800
                                       hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                type="submit">
                                Aplicar
                            </button>
                        </div>
                    </form>

                </div>

                @if (!$lista || $lista->count() === 0)
                    <div class="flex flex-col items-center justify-center py-16">
                        <div class="text-sm text-gray-500">Nenhum usuário encontrado.</div>

                        @if (!empty($pesquisa))
                            <a href="{{ route('usuarios.index') }}"
                                class="mt-4 inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white
                                      hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                Limpar busca
                            </a>
                        @endif
                    </div>
                @else
                    <div class="overflow-hidden rounded-xl ring-1 ring-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Nome</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        E-mail</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Permissão</th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Ações</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($lista as $u)
                                    @php
                                        $roleAtual = $u->roles->first()->name ?? null;
                                    @endphp

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900">{{ $u->name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $u->id }}</div>
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $u->email }}
                                        </td>

                                        <td class="px-4 py-3">
                                            @if ($roleAtual)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200">
                                                    {{ $roleAtual }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">
                                                    sem permissão
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3">
                                            @can('gerenciar-usuarios')
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('usuarios.edit', ['id' => $u->id]) }}"
                                                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-800
                                                              hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                                        Editar
                                                    </a>

                                                    <form method="POST"
                                                        action="{{ route('usuarios.destroy', ['id' => $u->id]) }}"
                                                        class="form-remover" data-confirm-title="Excluir usuário?"
                                                        data-confirm-text="Essa ação é permanente.">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="inline-flex items-center justify-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white
                                                                   hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200">
                                                            Excluir
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="text-right text-xs text-gray-400">-</div>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div class="text-xs text-gray-500">
                            Página: <strong class="text-gray-900">{{ $lista->currentPage() }}</strong>
                            <span class="mx-1">/</span>
                            Última: <strong class="text-gray-900">{{ $lista->lastPage() }}</strong>
                        </div>

                        @php
                            $perPageAtual = request()->query('per_page', $lista->perPage() ?? 20);
                            $pesquisaAtual = request()->query('pesquisa');

                            $hasPrev = $lista->currentPage() > 1;
                            $hasNext = $lista->hasMorePages();

                            $prevUrl = $hasPrev
                                ? $lista
                                    ->appends(['per_page' => $perPageAtual, 'pesquisa' => $pesquisaAtual])
                                    ->previousPageUrl()
                                : '#';
                            $nextUrl = $hasNext
                                ? $lista
                                    ->appends(['per_page' => $perPageAtual, 'pesquisa' => $pesquisaAtual])
                                    ->nextPageUrl()
                                : '#';
                        @endphp

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

                @endif

            </div>
        </div>

    </div>
</x-app-layout>
