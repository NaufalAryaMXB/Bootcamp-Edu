<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Produk</a>
                <span>/</span>
                <span class="text-gray-900 font-semibold truncate">{{ $product->name }}</span>
            </div>

            {{-- Product Detail Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-8">
                {{-- Gambar Produk --}}
                <div class="rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                    <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80' }}"
                         alt="{{ $product->name }}"
                         class="w-full max-h-[380px] object-cover">
                </div>

                {{-- Info Produk --}}
                <div class="flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            {{-- Kategori dari relasi ProductCategory --}}
                            <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ $product->productCategory->name ?? $product->category ?? 'Umum' }}
                            </span>
                            <div class="flex gap-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="text-xs font-semibold text-amber-600 hover:text-amber-700 bg-amber-50 px-3 py-1 rounded-lg border border-amber-200">
                                    Edit
                                </a>
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

                        {{-- Info Relasi: Menampilkan nama kategori dari model ProductCategory --}}
                        <div class="border-t border-gray-100 pt-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Kategori Produk (Relasi)</h3>
                            <p class="text-sm text-gray-700">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    {{ $product->productCategory->name ?? 'Belum dikategorikan' }}
                                </span>
                                @if($product->productCategory)
                                    <span class="text-xs text-gray-400 ml-2">(ID: {{ $product->productCategory->id }})</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Kembali --}}
                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ route('products.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Daftar Produk
                        </a>
                    </div>
                </div>
            </div>

            {{-- Produk Terkait --}}
            @if($relatedProducts->count() > 0)
                <div class="space-y-4 pt-4">
                    <h2 class="text-lg font-bold text-gray-900">
                        Produk Terkait ({{ $product->productCategory->name ?? $product->category }})
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($relatedProducts as $related)
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                                <img src="{{ $related->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&q=80' }}"
                                     class="w-full h-32 object-cover">
                                <div class="p-3">
                                    <a href="{{ route('products.show', $related->id) }}"
                                       class="text-xs font-bold text-gray-800 hover:text-indigo-600 block truncate">
                                        {{ $related->name }}
                                    </a>
                                    <span class="text-xs font-extrabold text-indigo-600 block mt-1">{{ $related->formatted_price }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
