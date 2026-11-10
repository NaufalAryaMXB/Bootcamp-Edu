@extends('layouts.app')

@section('title', 'Beranda E-Commerce')

@section('content')
<div class="space-y-10">
    <!-- Hero Banner (PageController@home) -->
    <div class="bg-gradient-to-r from-indigo-700 via-indigo-600 to-purple-600 rounded-3xl p-8 sm:p-12 text-white shadow-md relative overflow-hidden">
        <div class="relative z-10 max-w-2xl space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold tracking-wider uppercase">
                🚀 Sesi 11 - Controller Halaman & Produk
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Katalog Teknologi & Aksesoris Modern</h1>
            <p class="text-indigo-100 text-sm leading-relaxed">
                Aplikasi E-Commerce lengkap dengan <strong class="text-white">PageController</strong> untuk halaman statis & dinamis, serta <strong class="text-white">ProductController</strong> dengan fitur penuh CRUD (Tambah, Edit, Hapus, Detail).
            </p>
            <div class="pt-2 flex flex-wrap gap-3">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-white text-indigo-700 font-bold rounded-xl shadow hover:bg-indigo-50 transition text-xs">
                    Kelola Semua Produk &rarr;
                </a>
                <a href="{{ route('products.create') }}" class="px-5 py-2.5 bg-indigo-500/40 text-white font-semibold rounded-xl border border-white/20 hover:bg-indigo-500/60 transition text-xs">
                    + Tambah Produk Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm text-center">
            <span class="text-2xl font-black text-indigo-600">{{ $totalProducts ?? $featuredProducts->count() }}</span>
            <span class="text-xs text-gray-500 block font-medium mt-1">Total Produk</span>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm text-center">
            <span class="text-2xl font-black text-emerald-600">{{ isset($categories) ? count($categories) : 4 }}</span>
            <span class="text-xs text-gray-500 block font-medium mt-1">Kategori Tersedia</span>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm text-center">
            <span class="text-2xl font-black text-purple-600">2</span>
            <span class="text-xs text-gray-500 block font-medium mt-1">Controller Utama</span>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm text-center">
            <span class="text-2xl font-black text-amber-600">100%</span>
            <span class="text-xs text-gray-500 block font-medium mt-1">MySQL Terhubung</span>
        </div>
    </div>

    <!-- Produk Unggulan -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Produk Unggulan</h2>
                <p class="text-xs text-gray-500">Produk aktif yang diambil langsung dari database MySQL <code>ecommerce_db</code></p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua Katalog &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div>
                        <div class="relative overflow-hidden">
                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80' }}" alt="{{ $product->name }}" class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
                            <span class="absolute top-2 left-2 text-[10px] font-bold text-indigo-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded shadow-sm">
                                {{ $product->category }}
                            </span>
                        </div>
                        <div class="p-4 space-y-2">
                            <a href="{{ route('products.show', $product->id) }}" class="font-bold text-gray-900 text-sm hover:text-indigo-600 line-clamp-1">
                                {{ $product->name }}
                            </a>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                            <div class="flex items-center justify-between pt-2">
                                <span class="text-sm font-extrabold text-indigo-600">{{ $product->formatted_price }}</span>
                                <span class="text-[11px] text-gray-400">Stok: {{ $product->stock }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <a href="{{ route('products.show', $product->id) }}" class="text-xs font-semibold text-gray-600 hover:text-indigo-600">Detail</a>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="p-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition" title="Tambah ke keranjang">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-4 p-8 text-center bg-white rounded-xl border border-gray-200">
                    <p class="text-gray-500 text-sm">Belum ada produk di database.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
