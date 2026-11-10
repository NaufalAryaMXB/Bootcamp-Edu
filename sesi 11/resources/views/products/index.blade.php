@extends('layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-200">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Kelola Produk E-Commerce</h1>
            <p class="text-xs text-gray-500 mt-1">Dikelola melalui <code class="text-indigo-600 font-semibold">ProductController</code> (Fitur CRUD Produk)</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('products.create') }}" class="px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 shadow transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Produk Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 w-48 sm:w-64">
            
            <select name="category" class="px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>

            <select name="sort" class="px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama: A - Z</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-lg text-xs font-semibold hover:bg-gray-800 transition">Terapkan</button>
            @if(request()->hasAny(['search', 'category', 'sort']))
                <a href="{{ route('products.index') }}" class="text-xs text-rose-600 hover:underline">Reset</a>
            @endif
        </form>

        <span class="text-xs text-gray-500">Menampilkan <strong>{{ $products->count() }}</strong> dari <strong>{{ $products->total() }}</strong> produk</span>
    </div>

    <!-- Product Grid with Management Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                <!-- Gambar & Kategori -->
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
                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                            {{ $product->description ?: 'Tidak ada deskripsi produk.' }}
                        </p>
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-sm font-extrabold text-indigo-600">{{ $product->formatted_price }}</span>
                            <span class="text-[11px] px-2 py-0.5 rounded bg-gray-100 text-gray-600 font-medium">Stok: {{ $product->stock }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Toolbar: CRUD Buttons -->
                <div class="p-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between gap-2">
                    <!-- Tombol Edit & Hapus (Mengelola Produk) -->
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('products.edit', $product->id) }}" class="px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 rounded-md transition" title="Edit Produk">
                            Edit
                        </a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1 text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 rounded-md transition" title="Hapus Produk">
                                Hapus
                            </button>
                        </form>
                    </div>

                    <!-- Tombol Tambah ke Keranjang -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="p-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition shadow-sm" title="Tambah ke Keranjang">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-4 p-12 text-center bg-white rounded-xl border border-gray-200">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-sm font-semibold text-gray-700">Tidak ada produk ditemukan</p>
                <a href="{{ route('products.create') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold">Tambah Produk Pertama</a>
            </div>
        @endforelse
    </div>

    <!-- Paginasi -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
