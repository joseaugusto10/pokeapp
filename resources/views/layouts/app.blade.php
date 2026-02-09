<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>


    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#4f46e5'
            });
        </script>
    @endif

    @if (session('erro'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                text: "{{ session('erro') }}",
                confirmButtonColor: '#dc2626'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#f59e0b'
            });
        </script>
    @endif

    <script>
        document.querySelectorAll('.form-remover').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const title = form.dataset.confirmTitle || 'Tem certeza?';
                const text = form.dataset.confirmText || 'Essa ação não pode ser desfeita.';

                Swal.fire({
                    title,
                    text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sim, remover',
                    cancelButtonText: 'Cancelar'
                }).then((r) => {
                    if (r.isConfirmed) form.submit();
                });
            });
        });
    </script>



</body>

</html>
