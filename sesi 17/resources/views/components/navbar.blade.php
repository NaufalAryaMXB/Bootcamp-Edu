@props([
    'active' => ''
])

<!-- Top Notification Bar -->
<div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 text-indigo-100 text-xs py-2 px-4 shadow-sm">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
        <div class="flex items-center gap-2">
            <span class="px-2 py-0.5 rounded-full bg-indigo-500/30 text-indigo-200 text-[10px] font-bold uppercase tracking-wider border border-indigo-400/30">
                Sesi 13
            </span>
            <span class="text-xs font-medium">✨ Modul Database: Migration (Kategori, Produk, Pengguna, Pesanan) & Seeder</span>
        </div>
        <div class="flex items-center gap-4 text-[11px]">
            <a href="{{ route('pages.faq') }}" class="hover:text-white transition flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Bantuan / FAQ</span>
            </a>
            <span class="text-indigo-400">|</span>
            <a href="{{ route('pages.terms') }}" class="hover:text-white transition">Syarat & Ketentuan</a>
        </div>
    </div>
</div>

<!-- Main Navigation Bar Component -->
<header class="bg-white/95 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 shadow-sm transition-all duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Brand Logo -->
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold bg-gradient-to-r from-indigo-700 to-purple-700 bg-clip-text text-transparent">EduShop</span>
                        <span class="hidden sm:inline-block text-[10px] font-bold text-indigo-500 uppercase tracking-widest ml-1 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100">Blade</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                    <a href="{{ route('home') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors duration-150 {{ request()->is('/') ? 'text-indigo-600 bg-indigo-50/80 shadow-xs' : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50' }}">
                        Beranda
                    </a>

                    <a href="{{ route('products.index') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors duration-150 {{ request()->is('products*') && !request()->is('products/create') ? 'text-indigo-600 bg-indigo-50/80 shadow-xs' : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50' }}">
                        Katalog Produk
                    </a>

                    <a href="{{ route('cart.index') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors duration-150 {{ request()->is('cart*') ? 'text-indigo-600 bg-indigo-50/80 shadow-xs' : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50' }}">
                        Keranjang
                    </a>

                    <a href="{{ route('pages.about') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors duration-150 {{ request()->is('about') ? 'text-indigo-600 bg-indigo-50/80 shadow-xs' : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50' }}">
                        Tentang Kami
                    </a>

                    <a href="{{ route('pages.contact') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors duration-150 {{ request()->is('contact') ? 'text-indigo-600 bg-indigo-50/80 shadow-xs' : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50' }}">
                        Kontak
                    </a>
                </nav>
            </div>

            <!-- Action Buttons: Create Product & Shopping Cart -->
            <div class="flex items-center gap-2 sm:gap-3">
                
                <!-- Tombol Tambah Produk -->
                <a href="{{ route('products.create') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl text-xs font-bold shadow-sm shadow-emerald-200 hover:shadow-md transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="hidden sm:inline">Tambah Produk</span>
                </a>

                <!-- Cart Button with Dynamic Badge -->
                <a href="{{ route('cart.index') }}" 
                   class="relative p-2.5 rounded-xl bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 text-gray-700 transition duration-150 border border-gray-200" 
                   title="Keranjang Belanja">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 px-1.5 py-0.5 bg-rose-600 text-white text-[10px] font-extrabold rounded-full leading-none shadow-sm animate-pulse">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Mobile Hamburger Toggle -->
                <button type="button" 
                        onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" 
                        class="md:hidden p-2 rounded-xl text-gray-600 hover:text-indigo-600 hover:bg-gray-100 transition focus:outline-none"
                        aria-label="Toggle Mobile Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white px-4 pt-3 pb-4 space-y-1 shadow-lg">
        <a href="{{ route('home') }}" 
           class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('/') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50' }}">
            Beranda
        </a>
        <a href="{{ route('products.index') }}" 
           class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('products*') && !request()->is('products/create') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50' }}">
            Katalog Produk
        </a>
        <a href="{{ route('cart.index') }}" 
           class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('cart*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50' }}">
            Keranjang ({{ count(session('cart', [])) }})
        </a>
        <a href="{{ route('pages.about') }}" 
           class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('about') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50' }}">
            Tentang Kami
        </a>
        <a href="{{ route('pages.contact') }}" 
           class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('contact') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50' }}">
            Kontak
        </a>
        <div class="pt-2 border-t border-gray-100 flex gap-2">
            <a href="{{ route('products.create') }}" class="w-full text-center py-2 bg-emerald-600 text-white rounded-lg text-xs font-bold">
                + Tambah Produk Baru
            </a>
        </div>
    </div>
</header>
