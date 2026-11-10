@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">Formulir Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Form Checkout -->
        <div class="md:col-span-2 bg-white rounded-xl border border-gray-200 p-6 shadow-sm space-y-4">
            <h2 class="text-base font-bold text-gray-800 border-b border-gray-100 pb-3">Informasi Pemesanan</h2>
            <form action="{{ route('checkout.process') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Penerima</label>
                    <input type="text" name="shipping_name" required value="Budi Santoso" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="shipping_phone" required value="081234567890" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Kota Tujuan</label>
                    <input type="text" name="shipping_city" required value="Jakarta Selatan" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat Lengkap</label>
                    <textarea name="shipping_address" rows="3" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">Jl. Sudirman Kav. 25, RT 01/RW 02</textarea>
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow transition text-sm">
                        Konfirmasi & Buat Pesanan
                    </button>
                </div>
            </form>
        </div>

        <!-- Ringkasan Keranjang -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm h-fit space-y-4">
            <h2 class="text-base font-bold text-gray-800 border-b border-gray-100 pb-3">Ringkasan Belanja</h2>
            <div class="space-y-3">
                @foreach($cart as $item)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-700 truncate max-w-[150px]">{{ $item['name'] }} &times; {{ $item['quantity'] }}</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs font-bold text-gray-600">Total</span>
                <span class="text-base font-extrabold text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
