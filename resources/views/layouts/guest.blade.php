<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">
<div class="min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-5xl min-h-[450px] rounded-2xl overflow-hidden bg-white shadow-xl border border-slate-200">
        <div class="grid grid-cols-1 lg:grid-cols-2">

            <section class="relative flex flex-col justify-between text-white min-h-[240px] sm:min-h-[280px] lg:min-h-[450px] p-6 sm:p-10 lg:p-20">
                <div class="absolute inset-0">
                    <img
                        src="https://cdn.pixabay.com/photo/2016/07/23/13/18/pokemon-1536848_1280.png"
                        alt="Background"
                        class="h-full w-full object-cover"
                        loading="lazy"
                        referrerpolicy="no-referrer"
                    >
                    <div class="absolute inset-0 bg-black/40"></div>
                </div>

                <div class="relative">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-xl bg-white/20 border border-white/30 grid place-items-center font-bold text-base sm:text-lg">
                            P
                        </div>

                        <div class="leading-tight">
                            <div class="font-semibold text-lg sm:text-xl tracking-wide">{{config('app.name', 'Laravel')}}</div>
                        </div>
                    </div>

                    <h1 class="mt-8 sm:mt-12 lg:mt-16 text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight text-white/95 drop-shadow-sm">
                        Olá,<br>
                        bem-vindo!
                    </h1>

                    <p class="mt-3 sm:mt-4 lg:mt-5 text-white/95 text-sm max-w-sm leading-relaxed drop-shadow-sm">
                        Plataforma para consulta de Pokémon, importação de dados da PokéAPI
                        e gerenciamento de favoritos por perfil de acesso.
                    </p>
                </div>

                <div class="relative flex items-center lg:mt-5 justify-between text-[1px] sm:text-xs text-white/95">
                    <span>{{ now()->format('Y') }} • {{ config('app.name', 'Laravel') }}</span>
                    <span class="font-medium">José Augusto</span>
                </div>
            </section>

            <section class="p-8 sm:p-10 flex items-center">
                <div class="w-full max-w-md mx-auto">
                    {{ $slot }}
                </div>
            </section>

        </div>
    </div>

</div>
</body>
</html>
