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
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 text-gray-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 dark:text-gray-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-6 relative overflow-hidden">
            
            <!-- Background ornaments -->
            <div class="absolute top-10 left-10 w-40 h-40 bg-amber-200/40 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-56 h-56 bg-yellow-300/40 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmYmJmMjQiIGZpbGwtb3BhY2l0eT0iMC4wMyI+PHBhdGggZD0iTTM2IDE2YzAtMi4yMSAxLjc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0wIDI4YzAtMi4yMSAxLjc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0tMjAgMGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLjc5LTQtNHptMC0yOGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLjc5LTQtNHoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-20"></div>
            

            <!-- Card -->
            <div class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg shadow-2xl border border-amber-100 dark:border-gray-700 rounded-3xl">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                        {{ config('app.name', 'Madu Suwawa') }}
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Masuk untuk melanjutkan</p>
                </div>
                {{ $slot }}
            </div>

            <!-- Decorative footer bubble -->
            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-[600px] h-[200px] bg-gradient-to-t from-amber-100/50 to-transparent rounded-t-[50%] blur-2xl"></div>
        </div>
    </body>
</html>
