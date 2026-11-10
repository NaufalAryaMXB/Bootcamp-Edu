<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'EduShop') }} - Toko Online Terpercaya</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 text-gray-900 antialiased font-sans min-h-screen flex flex-col justify-between">
        
        <!-- Navbar -->
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <x-application-logo />
                </a>

                <nav class="flex items-center gap-3">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition">
                        Katalog Produk
                    </a>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                                Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-100 transition">
                                    Daftar Akun
                                </a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 flex-1 flex flex-col justify-center items-center text-center">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold tracking-wide uppercase mb-6">
                ✨ Selamat Datang di {{ config('app.name', 'EduShop') }}
            </span>

            <h1 class="text-4xl sm:text-6xl font-black text-gray-900 tracking-tight max-w-3xl leading-tight">
                Belanja Gadget & Elektronik Lebih <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Mudah & Aman</span>
            </h1>

            <p class="mt-4 text-base sm:text-lg text-gray-600 max-w-2xl">
                Platform e-commerce modern yang dilengkapi sistem autentikasi aman dengan <strong>Laravel Breeze</strong>, manajemen produk terintegrasi, dan kemudahan transaksi.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('products.index') }}" class="px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition text-sm">
                    Jelajahi Produk Kami
                </a>

                @guest
                    <a href="{{ route('register') }}" class="px-6 py-3.5 bg-white hover:bg-gray-50 border border-gray-200 text-gray-800 font-bold rounded-xl shadow-sm transition text-sm">
                        Buat Akun Gratis
                    </a>
                @endguest
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'EduShop') }}. Dibuat untuk Tugas Sesi 15 Eduwork.</p>
        </footer>

    </body>
</html>
