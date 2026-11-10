<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Detail Produk') }}
            </h2>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl transition shadow-2xs">
                &larr; Kembali ke Katalog
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Alert --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs sm:text-sm font-medium flex items-center gap-2 shadow-xs">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs sm:text-sm font-medium flex items-center gap-2 shadow-xs">
                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600 font-semibold">Katalog Produk</a>
                <span>/</span>
                <span class="text-gray-900 font-bold truncate">{{ $product->name }}</span>
            </div>

            {{-- Product Detail Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-10">
                {{-- Gambar Produk --}}
                <div class="rounded-2xl overflow-hidden bg-gray-50 flex items-center justify-center border border-gray-100">
                    <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80' }}"
                         alt="{{ $product->name }}"
                         class="w-full max-h-[400px] object-cover">
                </div>

                {{-- Info Produk --}}
                <div class="flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            {{-- Kategori dari relasi ProductCategory --}}
                            <span class="text-[11px] font-black text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full uppercase tracking-wider border border-indigo-100">
                                {{ $product->productCategory->name ?? $product->category ?? 'Umum' }}
                            </span>

                            {{-- Tombol Edit & Hapus HANYA untuk Admin --}}
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                           class="inline-flex items-center gap-1 text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-xl border border-amber-200 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            <span>Edit Produk</span>
                                        </a>

                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk \'{{ $product->name }}\'?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-xl border border-rose-200 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight">{{ $product->name }}</h1>

                        <div class="flex items-baseline gap-3">
                            <span class="text-3xl font-black text-indigo-600">{{ $product->formatted_price }}</span>
                            <span class="text-xs px-3 py-1 rounded-full font-bold {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' }}">
                                {{ $product->stock > 0 ? 'Stok Tersedia: ' . $product->stock . ' unit' : 'Stok Habis' }}
                            </span>
                        </div>

                        <div class="border-t border-gray-100 pt-4">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Deskripsi Produk</h3>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">{{ $product->description ?: 'Tidak ada deskripsi rinci untuk produk ini.' }}</p>
                        </div>
                    </div>

                    {{-- Form Tambah ke Keranjang Belanja --}}
                    <div class="pt-6 border-t border-gray-100">
                        <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="w-full sm:w-28">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Jumlah</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ max(1, $product->stock) }}" 
                                       @if($product->stock <= 0) disabled @endif
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm text-center font-bold focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            <div class="w-full sm:flex-1 sm:pt-4">
                                <button type="submit" 
                                        @if($product->stock <= 0) disabled @endif
                                        class="w-full py-3 px-6 {{ $product->stock > 0 ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-md shadow-indigo-100' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }} font-bold rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span>{{ $product->stock > 0 ? '+ Tambah ke Keranjang' : 'Stok Habis' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Produk Terkait --}}
            @if($relatedProducts->count() > 0)
                <div class="space-y-4 pt-4">
                    <h2 class="text-base font-bold text-gray-900">
                        Produk Terkait ({{ $product->productCategory->name ?? $product->category }})
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($relatedProducts as $related)
                            <div class="bg-white rounded-2xl border border-gray-100 p-3 shadow-2xs hover:shadow-md transition">
                                <img src="{{ $related->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&q=80' }}"
                                     class="w-full h-32 object-cover rounded-xl mb-2">
                                <a href="{{ route('products.show', $related->id) }}"
                                   class="text-xs font-bold text-gray-800 hover:text-indigo-600 block truncate">
                                    {{ $related->name }}
                                </a>
                                <span class="text-xs font-black text-indigo-600 block mt-1">{{ $related->formatted_price }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
