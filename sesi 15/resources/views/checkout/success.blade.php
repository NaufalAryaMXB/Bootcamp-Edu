@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl border border-gray-200 p-8 text-center shadow-sm space-y-6">
    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>

    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">Pesanan Berhasil Dibuat!</h1>
        <p class="text-xs text-gray-500 mt-1">Data order telah tersimpan ke tabel <code>orders</code> di database MySQL.</p>
    </div>

    <div class="bg-gray-50 rounded-xl p-4 text-left text-xs space-y-2 border border-gray-100">
        <div class="flex justify-between"><span class="text-gray-500">Nomor Order:</span><span class="font-bold text-gray-800">#ORD-{{ $order->order_id }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Produk:</span><span class="font-bold text-gray-800">{{ $order->product ? $order->product->name : '-' }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Jumlah:</span><span class="font-bold text-gray-800">{{ $order->quantity }} item</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Total Pembayaran:</span><span class="font-bold text-indigo-600">{{ $order->formatted_total }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Waktu Order:</span><span class="font-semibold text-gray-700">{{ $order->order_date }}</span></div>
    </div>

    <div>
        <a href="{{ route('home') }}" class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl text-xs hover:bg-indigo-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
