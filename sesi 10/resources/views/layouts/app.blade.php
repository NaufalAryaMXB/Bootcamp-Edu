<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Online E-Commerce') - Sesi 10</title>
    <!-- Google Fonts & Tailwind CDN untuk tampilan modern -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-indigo-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span>EduShop</span>
            </a>

            <!-- Menu Navigasi Route Tugas Sesi 10 -->
            <nav class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 transition {{ request()->is('/') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Beranda</a>
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition {{ request()->is('products*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Produk</a>
                <a href="{{ route('cart.index') }}" class="hover:text-indigo-600 transition relative {{ request()->is('cart*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">
                    Keranjang
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="ml-1 px-2 py-0.5 text-xs bg-indigo-600 text-white rounded-full font-bold">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('checkout.index') }}" class="hover:text-indigo-600 transition {{ request()->is('checkout*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Checkout</a>
            </nav>
        </div>
    </header>

    <!-- Notifikasi Alert -->
    <main class="max-w-6xl mx-auto px-4 py-8 flex-1 w-full">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-500">
        <p>&copy; 2026 EduShop - Tugas Laravel Sesi 10</p>
    </footer>

</body>
</html>
