<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EduShop') - Laravel Sesi 11</title>
    <!-- Tailwind CSS & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Top Info Bar -->
    <div class="bg-indigo-900 text-indigo-200 text-xs py-2 px-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <span>✨ Sesi 11: Controller Mengelola Produk & Mengelola Halaman</span>
            <div class="flex gap-4">
                <a href="{{ route('pages.faq') }}" class="hover:text-white transition">FAQ</a>
                <a href="{{ route('pages.terms') }}" class="hover:text-white transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-extrabold text-indigo-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span>EduShop</span>
            </a>

            <!-- Nav Links: PageController & ProductController -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 transition {{ request()->is('/') ? 'text-indigo-600 font-bold' : 'text-gray-600' }}">Beranda</a>
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition {{ request()->is('products*') && !request()->is('products/create') ? 'text-indigo-600 font-bold' : 'text-gray-600' }}">Kelola Produk</a>
                <a href="{{ route('pages.about') }}" class="hover:text-indigo-600 transition {{ request()->is('about') ? 'text-indigo-600 font-bold' : 'text-gray-600' }}">Tentang Kami</a>
                <a href="{{ route('pages.contact') }}" class="hover:text-indigo-600 transition {{ request()->is('contact') ? 'text-indigo-600 font-bold' : 'text-gray-600' }}">Kontak</a>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('products.create') }}" class="px-3.5 py-2 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 transition flex items-center gap-1 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Produk</span>
                </a>

                <a href="{{ route('cart.index') }}" class="p-2 bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 text-gray-700 rounded-lg transition relative" title="Keranjang Belanja">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 px-1.5 py-0.2 bg-rose-600 text-white text-[10px] font-bold rounded-full">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-6xl mx-auto px-4 py-8 flex-1 w-full">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8 text-xs text-gray-500">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>&copy; 2026 EduShop - Tugas Bootcamp Eduwork Sesi 11</p>
            <div class="flex gap-6">
                <a href="{{ route('home') }}" class="hover:text-indigo-600">Beranda</a>
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Katalog</a>
                <a href="{{ route('pages.about') }}" class="hover:text-indigo-600">Tentang Kami</a>
                <a href="{{ route('pages.contact') }}" class="hover:text-indigo-600">Kontak</a>
                <a href="{{ route('pages.faq') }}" class="hover:text-indigo-600">FAQ</a>
            </div>
        </div>
    </footer>

</body>
</html>
