<x-app-layout>
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Editar usuário</h1>
                <p class="text-sm text-gray-500">Atualize dados e permissão</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('usuarios.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-800
                          hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    Voltar
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <strong class="font-semibold">Corrige aí:</strong>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $roleAtual = $user->roles->first()->name ?? null;
        @endphp

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="p-6 space-y-8">
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Dados do usuário</h2>
                    <p class="mt-1 text-xs text-gray-500">ID: {{ $user->id }}</p>

                    <form method="POST" action="{{ route('usuarios.update', ['id' => $user->id]) }}" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="mt-1 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none
                                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                maxlength="120"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="mt-1 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none
                                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                maxlength="120"
                                required
                            >
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white
                                   hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                            Salvar dados
                        </button>
                    </form>
                </div>

                <div class="h-px w-full bg-gray-200"></div>

                @can('gerenciar-usuarios')
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900">Permissão</h2>
                        <p class="mt-1 text-xs text-gray-500">
                            Atual: <strong class="text-gray-900">{{ $roleAtual ?? 'sem permissão' }}</strong>
                        </p>

                        <form method="POST" action="{{ route('usuarios.role', ['id' => $user->id]) }}" class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-end">
                            @csrf
                            @method('PUT')

                            <div class="w-full sm:w-60">
                                <label class="block text-sm font-medium text-gray-700">Definir permissão</label>
                                <select
                                    name="role"
                                    class="mt-1 w-full rounded-lg border border-gray-300 bg-white px-3 pr-10 py-2 text-sm outline-none
                                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                    required
                                >
                                    <option value="">Selecione...</option>
                                    @foreach (['admin', 'editor', 'viewer'] as $r)
                                        <option value="{{ $r }}" @selected(old('role', $roleAtual) === $r)>{{ $r }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white
                                       hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                Salvar permissão
                            </button>
                        </form>

                        <form method="POST" action="{{ route('usuarios.permissao.remover', ['id' => $user->id]) }}"
                              class="form-remover mt-3"
                              data-confirm-title="Remover permissão?"
                              data-confirm-text="Esse usuário não acessa mais o sistema.">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-800
                                       hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                Remover permissão
                            </button>
                        </form>
                    </div>

                    <div class="h-px w-full bg-gray-200"></div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900">Excluir usuário</h2>
                        <p class="mt-1 text-xs text-gray-500">Ação permanente.</p>

                        <form method="POST" action="{{ route('usuarios.destroy', ['id' => $user->id]) }}"
                              class="form-remover mt-4"
                              data-confirm-title="Excluir usuário?"
                              data-confirm-text="Essa ação é permanente.">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white
                                       hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200">
                                Excluir usuário
                            </button>
                        </form>
                    </div>
                @endcan

            </div>
        </div>

    </div>
</x-app-layout>
