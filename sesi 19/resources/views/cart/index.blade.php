<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Keranjang Belanja') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Daftar produk yang ingin Anda beli.</p>
            </div>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl transition shadow-2xs">
                &larr; Lanjut Belanja
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert -->
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

            @if(empty($cart))
                <!-- Empty Cart State -->
                <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-12 sm:p-16 text-center shadow-xs">
                    <div class="w-20 h-20 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800">Keranjang Belanja Anda Masih Kosong</h2>
                    <p class="text-xs sm:text-sm text-gray-500 max-w-md mx-auto mt-1 leading-relaxed">
                        Anda belum menambahkan produk apa pun ke keranjang. Jelajahi katalog produk kami untuk menemukan barang impian Anda!
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md shadow-indigo-100 transition">
                            <span>Jelajahi Katalog Produk Sekarang &rarr;</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    <!-- Daftar Item Keranjang (2 Kolom) -->
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-bold text-sm text-gray-800">Daftar Barang ({{ count($cart) }} Item)</h3>
                            <span class="text-xs text-gray-400">Harga Satuan</span>
                        </div>

                        <div class="divide-y divide-gray-100">
                            @foreach($cart as $id => $item)
                                <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 border border-gray-100 shrink-0">
                                            <img src="{{ $item['image'] ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=150&q=80' }}" 
                                                 alt="{{ $item['name'] }}" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <a href="{{ route('products.show', $id) }}" class="font-bold text-sm text-gray-900 hover:text-indigo-600 transition block">
                                                {{ $item['name'] }}
                                            </a>
                                            <span class="text-xs text-indigo-600 font-bold block mt-0.5">
                                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                                            </span>
                                            <span class="text-[11px] text-gray-400">
                                                Jumlah: <strong>{{ $item['quantity'] }} unit</strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between sm:justify-end gap-4 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                                        <div class="text-right">
                                            <span class="text-[10px] uppercase font-bold text-gray-400 block">Subtotal</span>
                                            <span class="text-sm font-black text-gray-900">
                                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <!-- Tombol Hapus Item -->
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus barang ini dari keranjang?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl border border-transparent hover:border-rose-200 transition"
                                                    title="Hapus dari keranjang">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Ringkasan Belanja (1 Kolom) -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
                        <h3 class="font-bold text-base text-gray-900 pb-3 border-b border-gray-100">Ringkasan Pesanan</h3>

                        <div class="space-y-2.5 text-xs text-gray-600">
                            <div class="flex justify-between">
                                <span>Total Item</span>
                                <span class="font-bold text-gray-900">{{ collect($cart)->sum('quantity') }} barang</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya Pengiriman</span>
                                <span class="font-bold text-emerald-600 uppercase">Gratis Ongkir</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex items-baseline justify-between">
                            <span class="text-xs font-bold text-gray-700 uppercase">Total Bayar</span>
                            <span class="text-xl font-black text-indigo-600">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="button" 
                                onclick="alert('Pesanan berhasil dibuat! Terima kasih telah berbelanja di EduShop.');"
                                class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs sm:text-sm shadow-md shadow-indigo-100 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Lanjut ke Pembayaran</span>
                        </button>

                        <a href="{{ route('products.index') }}" class="block text-center text-xs font-bold text-gray-500 hover:text-indigo-600 transition">
                            &larr; Tambah Barang Lain
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
