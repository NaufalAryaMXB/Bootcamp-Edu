@extends('layouts.app')

@section('title', 'Kontak Kami')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full">Dikelola oleh PageController@contact</span>
        <h1 class="text-3xl font-extrabold text-gray-900">Hubungi Kami</h1>
        <p class="text-xs text-gray-500 max-w-md mx-auto">Punya pertanyaan seputar produk atau pesanan? Tim kami siap membantu Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Info Kontak -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-6">
            <h2 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">Informasi Kontak</h2>

            <div class="space-y-4 text-xs">
                <div>
                    <span class="text-gray-400 block font-semibold uppercase tracking-wider mb-1">Email Dukungan</span>
                    <a href="mailto:{{ $contactInfo['email'] }}" class="text-indigo-600 font-bold hover:underline">{{ $contactInfo['email'] }}</a>
                </div>

                <div>
                    <span class="text-gray-400 block font-semibold uppercase tracking-wider mb-1">Nomor Telepon / WA</span>
                    <span class="font-bold text-gray-800">{{ $contactInfo['phone'] }}</span>
                </div>

                <div>
                    <span class="text-gray-400 block font-semibold uppercase tracking-wider mb-1">Alamat Kantor</span>
                    <span class="text-gray-600 leading-relaxed block">{{ $contactInfo['address'] }}</span>
                </div>

                <div>
                    <span class="text-gray-400 block font-semibold uppercase tracking-wider mb-1">Jam Operasional</span>
                    <span class="text-gray-600">{{ $contactInfo['work_hours'] }}</span>
                </div>
            </div>
        </div>

        <!-- Form Kirim Pesan -->
        <div class="md:col-span-2 bg-white p-6 sm:p-8 rounded-2xl border border-gray-200 shadow-sm">
            <h2 class="text-base font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">Kirim Pesan Langsung</h2>

            <form action="{{ route('pages.contact.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Budi Santoso" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required placeholder="budi@example.com" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Subjek / Topik <span class="text-rose-500">*</span></label>
                    <input type="text" name="subject" required placeholder="Pertanyaan seputar stok keyboard wireless..." class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Isi Pesan <span class="text-rose-500">*</span></label>
                    <textarea name="message" rows="4" required placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow transition">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
