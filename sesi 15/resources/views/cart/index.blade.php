@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- Cart Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Keranjang Belanja</h1>
                <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">
                    {{ count($cart) }} Item
                </span>
            </div>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Periksa kembali daftar produk yang Anda pilih sebelum melanjutkan ke pembayaran.
            </p>
        </div>

        <a href="{{ route('products.index') }}" 
           class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Lanjut Pilih Produk</span>
        </a>
    </div>

    @if(empty($cart))
        <!-- Empty Cart State -->
        <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-12 sm:p-16 text-center shadow-xs">
            <div class="w-20 h-20 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-gray-800">Keranjang Belanja Anda Masih Kosong</h2>
            <p class="text-xs sm:text-sm text-gray-500 max-w-md mx-auto mt-1 leading-relaxed">
                Anda belum menambahkan produk apa pun ke keranjang. Jelajahi katalog produk kami untuk menemukan gadget & perangkat impian Anda!
            </p>
            <div class="mt-8 flex justify-center gap-3">
                <a href="{{ route('products.index') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-2xl text-xs sm:text-sm font-bold shadow-md shadow-indigo-200 transition">
                    Jelajahi Katalog Produk Sekarang &rarr;
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Table of Items in Cart (2 Cols on Desktop) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200/90 shadow-xs overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-900">Daftar Item Belanja</h3>
                    <span class="text-xs text-gray-500">{{ count($cart) }} jenis produk</span>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach($cart as $id => $item)
                        <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/50 transition">
                            
                            <!-- Product Details -->
                            <div class="flex items-center gap-4">
                                <img src="{{ $item['image'] ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80' }}" 
                                     alt="{{ $item['name'] }}" 
                                     class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-xl border border-gray-200 shrink-0">
                                
                                <div class="space-y-1">
                                    <h4 class="font-bold text-gray-900 text-sm hover:text-indigo-600 transition">
                                        {{ $item['name'] }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        Harga Satuan: <span class="font-semibold text-gray-700">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                    </p>
                                    <span class="inline-block text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                                        Jumlah: {{ $item['quantity'] }} pcs
                                    </span>
                                </div>
                            </div>

                            <!-- Subtotal & Remove Action -->
                            <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-2 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                                <div class="text-right">
                                    <span class="text-[10px] text-gray-400 block sm:inline">Subtotal:</span>
                                    <span class="text-sm sm:text-base font-extrabold text-indigo-600">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </span>
                                </div>

                                <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-800 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <span>💡 Tips: Klik <em>Lanjut Pilih Produk</em> jika ingin menambahkan barang lain.</span>
                </div>
            </div>

            <!-- Order Summary Card (1 Col on Desktop) -->
            <div class="bg-white rounded-2xl border border-gray-200/90 p-6 shadow-xs space-y-6">
                <h3 class="text-base font-extrabold text-gray-900 pb-3 border-b border-gray-100">Ringkasan Pesanan</h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between text-gray-600">
                        <span>Total Harga Barang</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-gray-600">
                        <span>Estimasi Ongkos Kirim</span>
                        <span class="font-bold text-emerald-600">GRATIS (Promo)</span>
                    </div>

                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Layanan</span>
                        <span class="font-semibold text-gray-900">Rp 0</span>
                    </div>

                    <div class="pt-3 border-t border-gray-200 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-gray-900">Total Pembayaran</span>
                        <span class="text-xl font-black text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Checkout Action Button -->
                <div class="space-y-3 pt-2">
                    <a href="{{ route('checkout.index') }}" 
                       class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-extrabold text-xs sm:text-sm text-center shadow-md shadow-indigo-200 block transition duration-200">
                        Lanjut ke Pembayaran &rarr;
                    </a>

                    <a href="{{ route('products.index') }}" 
                       class="w-full py-2.5 px-4 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-xl font-semibold text-xs text-center block transition">
                        Kembali ke Katalog
                    </a>
                </div>

                <!-- Guarantee Badges -->
                <div class="pt-4 border-t border-gray-100 space-y-2 text-[11px] text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Transaksi 100% Aman &amp; Terenkripsi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Garansi Pengembalian Jika Barang Rusak</span>
                    </div>
                </div>

            </div>

        </div>
    @endif

</div>
@endsection
