<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Dashboard Admin') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Ringkasan performa katalog, kategori, dan interaksi pengunjung toko.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('products.create') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Produk</span>
                </a>
                <a href="{{ route('categories.create') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Kategori</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome Banner --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-700 via-indigo-600 to-violet-600 p-6 sm:p-8 text-white shadow-xl shadow-indigo-200/50">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white text-xs font-bold tracking-wide uppercase mb-3">
                            ✨ Panel Kontrol Admin
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-black">
                            Selamat Datang, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-indigo-100 text-xs sm:text-sm mt-1.5 max-w-xl leading-relaxed">
                            Berikut adalah ringkasan inventaris dan performa minat produk pada toko <strong>{{ config('app.name', 'EduShop') }}</strong> hari ini.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('products.index') }}" 
                           class="px-5 py-2.5 bg-white text-indigo-700 hover:bg-indigo-50 text-xs font-bold rounded-xl shadow-md transition">
                            Kelola Produk &rarr;
                        </a>
                        <a href="{{ route('categories.index') }}" 
                           class="px-5 py-2.5 bg-indigo-800/60 hover:bg-indigo-800 text-white text-xs font-bold rounded-xl border border-white/20 transition">
                            Kelola Kategori &rarr;
                        </a>
                    </div>
                </div>

                {{-- Decorative circles --}}
                <div class="absolute -right-8 -bottom-12 w-48 h-48 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
                <div class="absolute right-32 -top-12 w-32 h-32 rounded-full bg-violet-400/20 blur-xl pointer-events-none"></div>
            </div>

            {{-- 3 KARTU STATISTIK UTAMA (Tugas Sesi 23: Jumlah Produk, Jumlah Kategori, Jumlah Klik) --}}
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-black tracking-wider uppercase text-gray-400">
                        Ringkasan Informasi Utama (Sesi 23)
                    </h3>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-[11px] font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                        Data Terhubung ke Controller
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- 1. Jumlah Produk --}}
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah Produk</p>
                                <h3 class="text-3xl font-black text-gray-900 mt-2">
                                    {{ number_format($jumlahProduk ?? $totalProducts ?? 0) }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <span class="text-emerald-600 font-bold">Aktif di katalog</span>
                                    <span>&bull; {{ $lowStockCount ?? 0 }} stok menipis</span>
                                </p>
                            </div>
                            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-xs">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between text-xs">
                            <a href="{{ route('products.index') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                                Lihat semua produk &rarr;
                            </a>
                            <span class="text-gray-400 text-[11px]">Inventaris</span>
                        </div>
                    </div>

                    {{-- 2. Jumlah Kategori --}}
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah Kategori</p>
                                <h3 class="text-3xl font-black text-gray-900 mt-2">
                                    {{ number_format($jumlahKategori ?? $totalCategories ?? 0) }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="text-violet-600 font-bold">Kategori produk</span> terdaftar
                                </p>
                            </div>
                            <div class="w-14 h-14 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-xs">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between text-xs">
                            <a href="{{ route('categories.index') }}" class="font-bold text-violet-600 hover:text-violet-800 transition">
                                Kelola kategori &rarr;
                            </a>
                            <span class="text-gray-400 text-[11px]">Kelompok Produk</span>
                        </div>
                    </div>

                    {{-- 3. Jumlah Klik Produk --}}
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah Klik Produk</p>
                                <h3 class="text-3xl font-black text-gray-900 mt-2">
                                    {{ number_format($jumlahKlikProduk ?? $totalClicks ?? 0) }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="text-amber-600 font-bold">Minat & interaksi</span> pengunjung
                                </p>
                            </div>
                            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-xs">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between text-xs">
                            <span class="font-bold text-amber-600">
                                Rata-rata {{ $totalProducts > 0 ? round($totalClicks / $totalProducts) : 0 }} klik / produk
                            </span>
                            <span class="text-gray-400 text-[11px]">Metrik Trafik</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Grid Konten Bawah: Produk Terpopuler (Berdasarkan Klik) & Kategori --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Tabel Produk Terpopuler Berdasarkan Klik (2 Kolom) --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="font-bold text-base text-gray-900">Produk Paling Sering Diklik</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Daftar produk dengan jumlah tayang/klik tertinggi oleh pengunjung.</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                            🔥 Top Clicks
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50/80 text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                                <tr>
                                    <th class="py-3 px-4 rounded-l-xl">Produk</th>
                                    <th class="py-3 px-4">Kategori</th>
                                    <th class="py-3 px-4 text-right">Harga</th>
                                    <th class="py-3 px-4 text-center rounded-r-xl">Jumlah Klik</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($topClickedProducts as $index => $item)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-3">
                                                <span class="w-5 text-center font-extrabold text-gray-400">
                                                    {{ $index + 1 }}
                                                </span>
                                                <img src="{{ $item->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&q=80' }}"
                                                     alt="{{ $item->name }}" 
                                                     class="w-10 h-10 object-cover rounded-lg border border-gray-100">
                                                <div>
                                                    <a href="{{ route('products.show', $item->id) }}" class="font-bold text-gray-900 hover:text-indigo-600 transition block truncate max-w-[180px] sm:max-w-xs">
                                                        {{ $item->name }}
                                                    </a>
                                                    <span class="text-[11px] text-gray-400">Stok: {{ $item->stock }} unit</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-gray-600 font-medium">
                                            <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 text-[10px] font-bold">
                                                {{ $item->productCategory->name ?? $item->category ?? 'Umum' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-black text-gray-900">
                                            {{ $item->formatted_price }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 font-black text-xs border border-amber-200">
                                                <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                                {{ number_format($item->clicks) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-gray-400">
                                            Belum ada data klik produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Kategori & Distribusi Produk (1 Kolom) --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-base text-gray-900">Distribusi Kategori</h3>
                            <a href="{{ route('categories.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                                Kelola &rarr;
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 mb-4">Jumlah produk yang terhubung pada setiap kategori.</p>

                        <div class="space-y-3">
                            @forelse($popularCategories as $cat)
                                <div class="p-3 bg-slate-50/80 rounded-xl flex items-center justify-between hover:bg-slate-100 transition">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-xs">
                                            {{ substr($cat->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-xs text-gray-800 block truncate max-w-[140px]">
                                                {{ $cat->name }}
                                            </span>
                                            <span class="text-[10px] text-gray-400">Kategori #{{ $cat->id }}</span>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-white text-indigo-700 border border-gray-200 shadow-2xs">
                                        {{ $cat->products_count }} Produk
                                    </span>
                                </div>
                            @empty
                                <div class="py-8 text-center text-gray-400 text-xs">
                                    Belum ada kategori yang dibuat.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                        <a href="{{ route('categories.create') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition inline-flex items-center gap-1">
                            <span>+ Tambah Kategori Baru</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
