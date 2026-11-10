@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Katalog Produk</h1>
            <p class="text-xs text-gray-500">Daftar produk e-commerce dari database MySQL</p>
        </div>

        <!-- Filter & Search -->
        <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <select name="category" class="px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition">Filter</button>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80' }}" alt="{{ $product->name }}" class="w-full h-44 object-cover">
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-2 py-0.5 rounded">{{ $product->category }}</span>
                        <h3 class="font-semibold text-gray-900 text-sm mt-2 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] text-gray-400 block">Stok: {{ $product->stock }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $product->formatted_price }}</span>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg transition" title="Tambah ke keranjang">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 p-8 text-center bg-white rounded-xl border border-gray-200">
                <p class="text-gray-500 text-sm">Tidak ada produk ditemukan.</p>
            </div>
        @endforelse
    </div>

    <!-- Paginasi -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
