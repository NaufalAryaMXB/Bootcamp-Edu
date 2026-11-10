@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="space-y-8">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-indigo-600">Beranda</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Produk</a>
        <span>/</span>
        <span class="text-gray-900 font-semibold truncate">{{ $product->name }}</span>
    </div>

    <!-- Product Detail Card -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-8">
        <!-- Gambar Produk -->
        <div class="rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center border border-gray-100">
            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80' }}" alt="{{ $product->name }}" class="w-full max-h-[380px] object-cover">
        </div>

        <!-- Info Produk -->
        <div class="flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full uppercase tracking-wider">
                        {{ $product->category }}
                    </span>
                    <div class="flex gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="text-xs font-semibold text-amber-600 hover:text-amber-700 bg-amber-50 px-3 py-1 rounded-lg border border-amber-200">Edit</a>
                    </div>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">{{ $product->name }}</h1>

                <div class="flex items-baseline gap-3">
                    <span class="text-3xl font-extrabold text-indigo-600">{{ $product->formatted_price }}</span>
                    <span class="text-xs px-2.5 py-1 rounded-full {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'bg-rose-50 text-rose-700' }}">
                        {{ $product->stock > 0 ? 'Stok Tersedia: ' . $product->stock : 'Stok Habis' }}
                    </span>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Produk</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $product->description ?: 'Tidak ada deskripsi rinci untuk produk ini.' }}</p>
                </div>
            </div>

            <!-- Form Tambah ke Keranjang -->
            <form action="{{ route('cart.add') }}" method="POST" class="pt-4 border-t border-gray-100 flex items-center gap-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="w-24">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Jumlah</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-center font-bold focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="flex-1 pt-4">
                    <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Tambah ke Keranjang</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Produk Terkait -->
    @if($relatedProducts->count() > 0)
        <div class="space-y-4 pt-6">
            <h2 class="text-lg font-bold text-gray-900">Produk Terkait (Kategori {{ $product->category }})</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedProducts as $related)
                    <div class="bg-white rounded-xl border border-gray-200 p-3 shadow-sm hover:shadow transition">
                        <img src="{{ $related->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&q=80' }}" class="w-full h-32 object-cover rounded-lg mb-2">
                        <a href="{{ route('products.show', $related->id) }}" class="text-xs font-bold text-gray-800 hover:text-indigo-600 block truncate">{{ $related->name }}</a>
                        <span class="text-xs font-extrabold text-indigo-600 block mt-1">{{ $related->formatted_price }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
