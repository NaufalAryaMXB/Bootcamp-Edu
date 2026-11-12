<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Tambah Kategori Baru') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Buat kategori baru untuk mengelompokkan produk di toko online Anda.</p>
            </div>
            <a href="{{ route('categories.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl transition shadow-2xs">
                &larr; Kembali ke Daftar Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Error Validation Alert --}}
            @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs sm:text-sm space-y-1 shadow-xs">
                    <span class="font-bold flex items-center gap-1.5 text-rose-900">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Terjadi kesalahan pengisian:
                    </span>
                    <ul class="list-disc list-inside mt-1 space-y-0.5 text-rose-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Card Form -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm">
                {{-- Sesi 21 - Tugas 2: Arahkan form ke route product-category.store dengan method POST --}}
                <form action="{{ route('product-category.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nama Kategori')" class="font-bold text-gray-700 text-xs uppercase tracking-wider" />
                        <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm placeholder-gray-400" 
                                      :value="old('name')" required autofocus placeholder="Contoh: Aksesoris & Gadget" />
                        <p class="text-[11px] text-gray-400 mt-1">Nama kategori harus unik dan belum pernah didaftarkan.</p>
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                        <a href="{{ route('categories.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Simpan Kategori</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
