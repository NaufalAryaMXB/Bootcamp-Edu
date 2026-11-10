@extends('layouts.app')

@section('title', 'Beranda E-Commerce')

@section('content')
<div class="space-y-12">
    <!-- Hero Banner (Halaman Utama) -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 text-white shadow-xl shadow-indigo-900/10">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
        
        <div class="relative z-10 px-6 py-12 sm:px-12 sm:py-16 lg:py-20 max-w-4xl space-y-6">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold tracking-wide">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                <span>Eduwork Bootcamp - Sesi 12: Blade Templates & Components</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                Pusat Belanja Gadget & Aksesoris Komputer Modern
            </h1>

            <p class="text-indigo-100 text-sm sm:text-base leading-relaxed max-w-2xl">
                Jelajahi koleksi perangkat teknologi terbaik kami dengan harga terjangkau. Dibangun menggunakan arsitektur modular <strong class="text-white">Laravel Blade Components</strong> (<code class="bg-indigo-950/60 px-1.5 py-0.5 rounded text-indigo-300">&lt;x-navbar /&gt;</code>, <code class="bg-indigo-950/60 px-1.5 py-0.5 rounded text-indigo-300">&lt;x-footer /&gt;</code>, dan <code class="bg-indigo-950/60 px-1.5 py-0.5 rounded text-indigo-300">&lt;x-product-card /&gt;</code>).
            </p>

            <div class="pt-2 flex flex-wrap items-center gap-3">
                <a href="{{ route('products.index') }}" 
                   class="px-6 py-3.5 bg-white text-indigo-900 font-extrabold rounded-2xl shadow-lg hover:bg-indigo-50 hover:shadow-indigo-500/20 hover:-translate-y-0.5 transition-all duration-200 text-xs sm:text-sm flex items-center gap-2">
                    <span>Lihat Daftar Produk</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>

                <a href="{{ route('cart.index') }}" 
                   class="px-6 py-3.5 bg-indigo-700/60 hover:bg-indigo-700 text-white font-bold rounded-2xl border border-indigo-400/30 hover:-translate-y-0.5 transition-all duration-200 text-xs sm:text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Keranjang Belanja</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Value Propositions / Fitur Unggulan -->
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-900">100% Produk Original</h4>
                <p class="text-[11px] text-gray-500 mt-0.5">Garansi resmi distributor</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-900">Pengiriman Cepat</h4>
                <p class="text-[11px] text-gray-500 mt-0.5">Diproses di hari yang sama</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-900">Pembayaran Aman</h4>
                <p class="text-[11px] text-gray-500 mt-0.5">Metode transfer & e-wallet</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-900">Bantuan 24/7</h4>
                <p class="text-[11px] text-gray-500 mt-0.5">Layanan bantuan pelanggan</p>
            </div>
        </div>
    </section>

    <!-- Section Kategori Pilihan -->
    @if(isset($categories) && count($categories) > 0)
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-gray-900 tracking-tight">Kategori Produk</h2>
                <p class="text-xs text-gray-500">Pilih kategori untuk memfilter katalog produk</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                Semua Kategori &rarr;
            </a>
        </div>

        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('products.index') }}" 
               class="px-4 py-2 rounded-xl text-xs font-semibold bg-white border border-gray-200 hover:border-indigo-500 hover:text-indigo-600 shadow-2xs transition">
                🌟 Semua Kategori
            </a>
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-semibold bg-white border border-gray-200 hover:border-indigo-500 hover:text-indigo-600 shadow-2xs transition flex items-center gap-1.5">
                    <span>📁</span>
                    <span>{{ $category }}</span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Section Produk Unggulan (Menggunakan Blade Component x-product-card) --}}
    <section class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Produk Pilihan Terbaru</h2>
                    <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 text-[10px] font-bold border border-indigo-100">
                        &lt;x-product-card /&gt;
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-0.5">Produk berkualitas tinggi yang siap dipesan langsung ke keranjang Anda</p>
            </div>

            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                <span>Buka Seluruh Katalog ({{ $totalProducts ?? $featuredProducts->count() }} Produk)</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Product Grid rendered via Blade Component -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
                <!-- Memanggil Reusable Blade Component -->
                <x-product-card :product="$product" :showManageActions="false" />
            @empty
                <div class="col-span-full py-16 px-6 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-sm font-bold text-gray-700">Belum Ada Produk di Database</h3>
                    <p class="text-xs text-gray-500 mt-1">Tambahkan produk pertama untuk melihat tampilan katalog.</p>
                    <div class="mt-4">
                        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition">
                            + Tambah Produk Sekarang
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Info Box: Blade Components Reference -->
    <section class="rounded-2xl bg-gradient-to-r from-slate-900 to-indigo-950 text-white p-6 sm:p-8 border border-slate-800 shadow-md">
        <div class="max-w-3xl space-y-3">
            <span class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-400 bg-indigo-900/50 px-2.5 py-1 rounded-md border border-indigo-700/50">
                Arsitektur Blade Sesi 12
            </span>
            <h3 class="text-xl font-black">Komponen Blade yang Aktif di Halaman Ini</h3>
            <p class="text-xs text-slate-300 leading-relaxed">
                Halaman beranda ini menggunakan layout modular Blade:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
                <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700">
                    <span class="font-mono font-bold text-indigo-300 block mb-1">&lt;x-navbar /&gt;</span>
                    <span class="text-gray-400 text-[11px]">Header navigasi dengan indikator keranjang dinamis.</span>
                </div>
                <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700">
                    <span class="font-mono font-bold text-indigo-300 block mb-1">&lt;x-product-card /&gt;</span>
                    <span class="text-gray-400 text-[11px]">Komponen kartu produk interaktif dengan tombol beli.</span>
                </div>
                <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700">
                    <span class="font-mono font-bold text-indigo-300 block mb-1">&lt;x-footer /&gt;</span>
                    <span class="text-gray-400 text-[11px]">Footer konsisten dengan tautan bantuan & info legal.</span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
