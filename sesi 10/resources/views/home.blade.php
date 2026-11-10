@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="space-y-8">
    <!-- Hero Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
        <div class="space-y-3 max-w-xl">
            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold tracking-wider uppercase">Tugas Sesi 10</span>
            <h1 class="text-3xl font-extrabold tracking-tight">Selamat Datang di EduShop</h1>
            <p class="text-indigo-100 text-sm leading-relaxed">Website E-Commerce Laravel dengan integrasi database MySQL sesi sebelumnya.</p>
            <div class="pt-2">
                <a href="{{ route('products.index') }}" class="inline-block px-5 py-2.5 bg-white text-indigo-600 font-semibold rounded-xl shadow hover:bg-indigo-50 transition text-sm">Lihat Semua Produk &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Produk Unggulan -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Produk Unggulan</h2>
                <p class="text-xs text-gray-500">Produk terhubung langsung dari database MySQL ecommerce_db</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
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
                                <span class="text-xs text-gray-400 block">Harga</span>
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
                    <p class="text-gray-500 text-sm">Belum ada produk di database.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
