<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'EduShop') }} - Beranda E-Commerce</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 text-gray-900 antialiased font-sans min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

        <!-- ============================================================ -->
        <!-- Top Navbar                                                   -->
        <!-- ============================================================ -->
        <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <!-- Brand / Logo -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white shadow-md shadow-indigo-200 group-hover:scale-105 transition transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-black tracking-tight text-gray-900">
                            Edu<span class="text-indigo-600">Shop</span>
                        </span>
                    </a>

                    <!-- Nav Links -->
                    <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-gray-600">
                        <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-700 transition">Beranda</a>
                        <a href="#kategori" class="hover:text-indigo-600 transition">Kategori</a>
                        <a href="#produk" class="hover:text-indigo-600 transition">Produk Pilihan</a>
                        <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Semua Katalog</a>
                    </nav>
                </div>

                <!-- Right Actions: Cart & Auth -->
                <div class="flex items-center gap-3">
                    <!-- Cart Icon with Live Counter -->
                    @php 
                        $cartCount = auth()->check() 
                            ? \App\Models\CartItem::where('user_id', auth()->id())->count() 
                            : count(session('cart', [])); 
                    @endphp
                    <a href="{{ route('cart.index') }}" 
                       class="relative p-2.5 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition duration-150"
                       title="Keranjang Belanja">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute top-1 right-1 min-w-[20px] h-5 px-1.5 flex items-center justify-center text-[10px] font-black text-white bg-indigo-600 rounded-full shadow ring-2 ring-white animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Auth State Controls -->
                    @if (Route::has('login'))
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                                    Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                                    <span>Halo, {{ Str::words(Auth::user()->name, 1, '') }}</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-xs font-medium text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Keluar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:text-indigo-600 transition">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 text-xs sm:text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-100 transition">
                                    Daftar Akun
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <main class="flex-1">

            <!-- ============================================================ -->
            <!-- Flash Message                                                -->
            <!-- ============================================================ -->
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <a href="{{ route('cart.index') }}" class="text-xs font-bold text-emerald-700 underline hover:text-emerald-900">Lihat Keranjang &rarr;</a>
                    </div>
                </div>
            @endif

            <!-- ============================================================ -->
            <!-- Hero Section                                                 -->
            <!-- ============================================================ -->
            <section class="relative overflow-hidden py-16 sm:py-24 bg-gradient-to-b from-indigo-50/50 via-white to-slate-50 border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-100/70 border border-indigo-200 text-indigo-800 text-xs font-bold tracking-wide uppercase mb-6 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-indigo-600 animate-ping"></span>
                        Sesi 20 Eduwork - Controller View Integration
                    </div>

                    <h1 class="text-4xl sm:text-6xl font-black text-gray-900 tracking-tight max-w-4xl mx-auto leading-tight">
                        Temukan Gadget & Elektronik <br class="hidden sm:inline">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500">
                            Terbaik untuk Kebutuhan Anda
                        </span>
                    </h1>

                    <p class="mt-5 text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        Data kategori produk dan koleksi produk terkini di bawah ini diambil langsung melalui <strong>HomeController</strong> dan dirender dinamis ke dalam Blade template.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                        <a href="#produk" class="px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition text-sm flex items-center gap-2">
                            <span>Jelajahi Produk Unggulan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        <a href="#kategori" class="px-6 py-3.5 bg-white hover:bg-gray-50 border border-gray-200 text-gray-800 font-bold rounded-xl shadow-sm transition text-sm flex items-center gap-2">
                            <span>Lihat Kategori</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-12 pt-8 border-t border-gray-200/60 max-w-3xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">100% Original</h4>
                                <p class="text-[11px] text-gray-500">Garansi resmi pabrik</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Pengiriman Cepat</h4>
                                <p class="text-[11px] text-gray-500">Siap kirim ke Nusantara</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Harga Terbaik</h4>
                                <p class="text-[11px] text-gray-500">Promo menarik tiap hari</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Support 24/7</h4>
                                <p class="text-[11px] text-gray-500">Pelayanan responsif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ============================================================ -->
            <!-- TUGAS SESI 20: TAMPILKAN DATA KATEGORI PRODUK DARI CONTROLLER -->
            <!-- ============================================================ -->
            <section id="kategori" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-2">
                            <span>Kategori Produk</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                            Jelajahi Berdasarkan Kategori
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            Pilih kategori favorit Anda untuk melihat semua koleksi produk terkait.
                        </p>
                    </div>

                    <a href="{{ route('products.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition self-start md:self-auto">
                        <span>Lihat Semua Produk</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($categories->isEmpty())
                    <div class="bg-white rounded-2xl p-8 text-center border border-gray-100 shadow-sm">
                        <p class="text-gray-500 text-sm">Belum ada kategori yang ditambahkan.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                        @foreach($categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->name]) }}"
                               class="group bg-white rounded-2xl p-5 border border-gray-100 shadow-xs hover:shadow-lg hover:border-indigo-200 transition-all duration-300 flex flex-col items-center text-center">
                                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white group-hover:scale-110 flex items-center justify-center transition-all duration-300 shadow-xs mb-3">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-sm text-gray-900 group-hover:text-indigo-600 transition truncate w-full">
                                    {{ $category->name }}
                                </h3>
                                <span class="text-[11px] font-medium text-gray-400 mt-1">
                                    {{ $category->products_count }} Produk
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- ============================================================ -->
            <!-- TUGAS SESI 20: TAMPILKAN DATA PRODUK DARI CONTROLLER         -->
            <!-- ============================================================ -->
            <section id="produk" class="py-16 bg-white border-y border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-2">
                                <span>Produk Unggulan</span>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                                Koleksi Produk Terbaru
                            </h2>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                Produk terpilih dengan kualitas terbaik dan penawaran paling menarik hari ini.
                            </p>
                        </div>

                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-xl text-xs font-bold transition">
                            <span>Buka Katalog Lengkap</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>

                    @if($featuredProducts->isEmpty())
                        <div class="bg-slate-50 rounded-2xl p-12 text-center border border-gray-100">
                            <p class="text-gray-500 text-sm">Belum ada produk yang tersedia saat ini.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($featuredProducts as $product)
                                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs hover:shadow-xl hover:border-gray-200 transition-all duration-300 overflow-hidden flex flex-col group">
                                    
                                    <!-- Image Thumbnail (Clickable untuk Fitur Klik Produk Sesi 24) -->
                                    <a href="{{ route('products.click', $product->id) }}" class="relative w-full h-48 bg-slate-100 overflow-hidden flex items-center justify-center">
                                        @if($product->image)
                                            @php
                                                $imgSrc = \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])
                                                    ? $product->image
                                                    : asset('storage/' . $product->image);
                                            @endphp
                                            <img src="{{ $imgSrc }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                            <div class="hidden w-full h-full items-center justify-center bg-indigo-50 text-indigo-400">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif

                                        <!-- Badge Kategori -->
                                        <div class="absolute top-3 left-3">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-white/90 backdrop-blur-md text-gray-800 shadow-xs border border-gray-100">
                                                {{ $product->productCategory?->name ?? 'Umum' }}
                                            </span>
                                        </div>

                                        <!-- Badge Klik Produk (Sesi 24) -->
                                        <div class="absolute top-3 right-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-bold bg-amber-500/90 text-white shadow-xs">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                                {{ number_format($product->klik ?? $product->clicks ?? 0) }} klik
                                            </span>
                                        </div>
                                    </a>

                                    <!-- Content -->
                                    <div class="p-4 flex-1 flex flex-col justify-between">
                                        <div>
                                            <h3 class="font-bold text-sm text-gray-900 group-hover:text-indigo-600 transition line-clamp-1">
                                                <a href="{{ route('products.click', $product->id) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">
                                                {{ $product->description ?? 'Tidak ada deskripsi produk.' }}
                                            </p>
                                        </div>

                                        <div class="mt-4 pt-3 border-t border-gray-100">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-bold block">Harga</span>
                                                    <span class="text-base font-black text-indigo-600">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </span>
                                                </div>

                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                                    {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                                                </span>
                                            </div>

                                            <!-- Tombol Aksi: Detail (Klik Produk) & Tambah Keranjang -->
                                            <div class="mt-3 grid grid-cols-2 gap-2">
                                                <a href="{{ route('products.click', $product->id) }}"
                                                   class="text-center py-2 px-3 text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                                                    Detail
                                                </a>

                                                <form action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" 
                                                            {{ $product->stock <= 0 ? 'disabled' : '' }}
                                                            class="w-full py-2 px-3 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed rounded-xl shadow-xs transition flex items-center justify-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                        <span>Beli</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <!-- ============================================================ -->
            <!-- SECTION PRODUK TERPOPULER / PALING BANYAK DILIHAT            -->
            <!-- ============================================================ -->
            @if(isset($popularProducts) && $popularProducts->isNotEmpty())
                <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-gradient-to-tr from-indigo-900 via-indigo-800 to-slate-900 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
                        
                        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-8">
                            <div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-500/30 border border-indigo-400/30 text-indigo-200 text-xs font-bold tracking-wide uppercase mb-3">
                                    <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Tren Terkini (Clicks)
                                </span>
                                <h3 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                                    Produk Paling Sering Dilihat Pengunjung
                                </h3>
                                <p class="text-indigo-200 text-xs sm:text-sm mt-1 max-w-xl">
                                    Pelanggan kami sangat menyukai produk-produk ini berdasarkan jumlah interaksi dan klik.
                                </p>
                            </div>

                            <a href="{{ route('products.index', ['sort' => 'latest']) }}" 
                               class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white text-indigo-950 font-bold text-xs hover:bg-indigo-50 transition shadow-lg shrink-0 self-start lg:self-auto">
                                <span>Katalog Lengkap</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>

                        <!-- Grid Popular Products -->
                        <div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($popularProducts as $item)
                                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 hover:border-white/20 transition flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between text-[11px] text-indigo-200 font-semibold mb-2">
                                            <span>{{ $item->productCategory?->name ?? 'Umum' }}</span>
                                            <span class="flex items-center gap-1 text-amber-300 font-bold">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                                {{ number_format($item->klik ?? $item->clicks ?? 0) }} klik
                                            </span>
                                        </div>
                                        <h4 class="font-bold text-sm text-white line-clamp-1">
                                            <a href="{{ route('products.click', $item->id) }}" class="hover:text-amber-300 transition">
                                                {{ $item->name }}
                                            </a>
                                        </h4>
                                        <p class="text-base font-black text-amber-300 mt-2">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between">
                                        <a href="{{ route('products.click', $item->id) }}" class="text-xs font-bold text-white hover:underline flex items-center gap-1">
                                            Lihat detail &rarr;
                                        </a>

                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="p-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition" title="Beli">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </section>
            @endif

        </main>

        <!-- ============================================================ -->
        <!-- Footer                                                       -->
        <!-- ============================================================ -->
        <footer class="bg-white border-t border-gray-100 py-10 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-black text-sm">
                        E
                    </div>
                    <span class="font-black text-gray-900 text-lg">EduShop</span>
                    <span class="text-xs text-gray-400 ms-2">&copy; {{ date('Y') }} Eduwork Fullstack Laravel.</span>
                </div>

                <div class="flex flex-wrap items-center gap-6 text-xs text-gray-500 font-medium">
                    <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Beranda</a>
                    <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Katalog Produk</a>
                    <a href="{{ route('cart.index') }}" class="hover:text-indigo-600 transition">Keranjang Belanja</a>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Dashboard Admin</a>
                            <a href="{{ route('categories.index') }}" class="hover:text-indigo-600 transition">Kategori</a>
                        @endif
                    @endauth
                </div>

                <p class="text-[11px] text-gray-400">
                    Sesi 20: Menampilkan Kategori & Produk via Controller
                </p>
            </div>
        </footer>

    </body>
</html>
