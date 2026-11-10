@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Keranjang Belanja</h1>
        <a href="{{ route('products.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">&larr; Lanjut Belanja</a>
    </div>

    @if(empty($cart))
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <h3 class="text-base font-bold text-gray-700">Keranjang Anda masih kosong</h3>
            <p class="text-xs text-gray-500 mt-1">Silakan pilih produk terlebih dahulu untuk mulai berbelanja.</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold text-xs hover:bg-indigo-700 transition">Lihat Katalog Produk</a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 border-b border-gray-200 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Produk</th>
                        <th class="p-4">Harga</th>
                        <th class="p-4">Jumlah</th>
                        <th class="p-4">Subtotal</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($cart as $id => $item)
                        <tr>
                            <td class="p-4 flex items-center gap-3">
                                <img src="{{ $item['image'] ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80' }}" class="w-12 h-12 object-cover rounded-lg border border-gray-100">
                                <span class="font-semibold text-gray-800">{{ $item['name'] }}</span>
                            </td>
                            <td class="p-4 text-gray-600">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="p-4 font-semibold">{{ $item['quantity'] }}</td>
                            <td class="p-4 font-bold text-indigo-600">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-6 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-gray-500">Total Pembayaran:</span>
                    <span class="text-xl font-extrabold text-indigo-600 block">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl text-sm hover:bg-indigo-700 shadow transition">Lanjut ke Checkout &rarr;</a>
            </div>
        </div>
    @endif
</div>
@endsection
