@props([
    'product' => null,
    'showManageActions' => false
])

@if($product)
<div class="bg-white rounded-2xl border border-gray-200/90 overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
    <div>
        <!-- Product Image & Category Badge -->
        <div class="relative overflow-hidden aspect-4/3 bg-gray-100">
            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80' }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
            
            <!-- Category Tag -->
            <span class="absolute top-3 left-3 text-[10px] font-extrabold tracking-wide uppercase text-indigo-700 bg-white/95 backdrop-blur-md px-2.5 py-1 rounded-lg shadow-sm border border-indigo-100">
                {{ $product->category }}
            </span>

            <!-- Stock Status Badge -->
            @if($product->stock <= 0)
                <span class="absolute top-3 right-3 text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-200">
                    Habis
                </span>
            @elseif($product->stock < 5)
                <span class="absolute top-3 right-3 text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                    Sisa {{ $product->stock }}
                </span>
            @endif
        </div>

        <!-- Product Information -->
        <div class="p-5 space-y-2.5">
            <a href="{{ route('products.show', $product->id) }}" 
               class="font-bold text-gray-900 text-sm hover:text-indigo-600 transition-colors line-clamp-1 block"
               title="{{ $product->name }}">
                {{ $product->name }}
            </a>

            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                {{ $product->description ?: 'Produk berkualitas tinggi dengan garansi resmi dan performa terbaik di kelasnya.' }}
            </p>

            <div class="pt-2 flex items-baseline justify-between">
                <div>
                    <span class="text-xs text-gray-400 block text-[10px] uppercase font-semibold">Harga</span>
                    <span class="text-base font-black text-indigo-600">
                        {{ $product->formatted_price ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-[11px] px-2 py-0.5 rounded-md bg-gray-100 text-gray-600 font-medium">
                        Stok: {{ $product->stock }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Footer Toolbar: Actions & Add to Cart -->
    <div class="p-4 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between gap-2">
        @if($showManageActions)
            <!-- Admin / Management Actions (Edit & Delete) -->
            <div class="flex items-center gap-1.5">
                <a href="{{ route('products.edit', $product->id) }}" 
                   class="px-2.5 py-1.5 text-xs font-semibold bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 rounded-lg transition"
                   title="Edit Data Produk">
                    Edit
                </a>

                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk \'{{ $product->name }}\'?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-2.5 py-1.5 text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 rounded-lg transition"
                            title="Hapus Produk">
                        Hapus
                    </button>
                </form>
            </div>
        @else
            <!-- Public User Action (Detail Link) -->
            <a href="{{ route('products.show', $product->id) }}" 
               class="text-xs font-semibold text-gray-600 hover:text-indigo-600 transition flex items-center gap-1">
                <span>Lihat Detail</span>
                <span class="text-indigo-500">&rarr;</span>
            </a>
        @endif

        <!-- Quick Add to Cart Button -->
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" 
                    @if($product->stock <= 0) disabled @endif
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 {{ $product->stock > 0 ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }} rounded-xl text-xs font-bold transition duration-150"
                    title="{{ $product->stock > 0 ? 'Tambah ke Keranjang Belanja' : 'Stok Habis' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Beli</span>
            </button>
        </form>
    </div>
</div>
@endif
