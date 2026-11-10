@extends('layouts.app')

@section('title', 'Syarat & Ketentuan')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl border border-gray-200 shadow-sm space-y-6">
    <div class="border-b border-gray-100 pb-4">
        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full">Dikelola oleh PageController@terms</span>
        <h1 class="text-2xl font-extrabold text-gray-900 mt-2">Syarat dan Ketentuan Layanan</h1>
        <p class="text-xs text-gray-400 mt-1">Terakhir diperbarui: Oktober 2026</p>
    </div>

    <div class="space-y-4 text-xs text-gray-600 leading-relaxed">
        <h2 class="text-sm font-bold text-gray-800">1. Ketentuan Umum</h2>
        <p>Dengan mengakses dan melakukan transaksi di website EduShop, Anda menyetujui seluruh syarat dan ketentuan yang berlaku.</p>

        <h2 class="text-sm font-bold text-gray-800">2. Pemesanan Produk</h2>
        <p>Pesanan produk diproses sesuai dengan stok yang tersedia di database. Transaksi dinyatakan sah setelah Anda mengisi data checkout dan konfirmasi pesanan berhasil dilakukan.</p>

        <h2 class="text-sm font-bold text-gray-800">3. Kebijakan Pengembalian</h2>
        <p>Barang yang rusak akibat cacat produksi dapat ditukar dalam waktu 7 hari sejak tanggal penerimaan dengan melampirkan video unboxing.</p>
    </div>
</div>
@endsection
