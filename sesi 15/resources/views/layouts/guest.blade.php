<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EduShop') }} - Autentikasi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-0 pb-12 px-4">
            <div class="mb-4">
                <a href="/" class="hover:opacity-90 transition transform hover:-translate-y-0.5 inline-block">
                    <x-application-logo />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-8 py-8 bg-white border border-gray-100 shadow-xl shadow-slate-200/50 overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>

            <footer class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'EduShop') }}. All rights reserved.
            </footer>
        </div>
    </body>
</html>
