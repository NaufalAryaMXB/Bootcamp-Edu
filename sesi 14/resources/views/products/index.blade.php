@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="space-y-8">
    <!-- Header Page: Title & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Daftar Produk</h1>
                <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">
                    Katalog Lengkap
                </span>
            </div>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Katalog produk dinamis dengan filter, pencarian, dan komponen kartu produk <code class="text-indigo-600 font-semibold font-mono">&lt;x-product-card /&gt;</code>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('products.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md shadow-emerald-200 hover:shadow-lg transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Produk Baru</span>
            </a>
        </div>
    </div>

    <!-- Toolbar: Search, Category Filter, and Sort -->
    <div class="bg-white p-5 rounded-2xl border border-gray-200/90 shadow-xs">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <!-- Search Box -->
                <div class="relative w-full sm:w-64">
                    <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama produk..." 
                           class="w-full pl-10 pr-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                </div>

                <!-- Category Filter -->
                <select name="category" class="px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- Sort Filter -->
                <select name="sort" class="px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama: A - Z</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-xs">
                    Terapkan
                </button>

                @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('products.index') }}" class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline ml-1">
                        Reset Filter
                    </a>
                @endif
            </div>

            <div class="text-xs text-gray-500 w-full md:w-auto text-left md:text-right">
                Menampilkan <strong class="text-gray-800">{{ $products->count() }}</strong> dari <strong class="text-gray-800">{{ $products->total() }}</strong> total produk
            </div>
        </form>
    </div>

    {{-- Product Grid: Rendered using Blade Component x-product-card --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <!-- Menggunakan Komponen Blade Product Card dengan Opsi Kelola (Edit & Hapus) -->
            <x-product-card :product="$product" :showManageActions="true" />
        @empty
            <div class="col-span-full py-16 px-6 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-sm font-bold text-gray-700">Tidak Ada Produk yang Ditemukan</h3>
                <p class="text-xs text-gray-500 mt-1">Coba sesuaikan kata kunci pencarian atau reset filter kategori.</p>
                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold transition">
                        Reset Filter &amp; Tampilkan Semua
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="pt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
