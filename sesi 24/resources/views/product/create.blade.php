<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Tambah Produk Baru') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Lengkapi data produk untuk menambahkan ke katalog toko.</p>
            </div>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl transition shadow-2xs">
                &larr; Kembali ke Daftar Produk
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Error Validation Alert --}}
            @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs sm:text-sm space-y-1 shadow-xs">
                    <span class="font-bold flex items-center gap-1.5 text-rose-900">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Mohon periksa kembali formulir Anda:
                    </span>
                    <ul class="list-disc list-inside mt-1 space-y-0.5 text-rose-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Tambah Produk --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                {{-- Sesi 21 - Tugas 3: Arahkan form ke route product.store dengan method POST --}}
                <form action="{{ route('product.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nama Produk --}}
                    <div>
                        <x-input-label for="name" :value="__('Nama Produk')" class="font-bold text-gray-700 text-xs uppercase tracking-wider" />
                        <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm placeholder-gray-400" 
                                      :value="old('name')" required placeholder="Contoh: MacBook Pro M3 14-inch" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    {{-- Kategori & Stok --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="category" :value="__('Kategori Produk')" class="font-bold text-gray-700 text-xs uppercase tracking-wider" />
                            <select id="category" name="category" required
                                    class="mt-2 block w-full border-gray-200 rounded-xl shadow-2xs focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-white">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-1.5" />
                        </div>

                        <div>
                            <x-input-label for="stock" :value="__('Jumlah Stok')" class="font-bold text-gray-700 text-xs uppercase tracking-wider" />
                            <x-text-input id="stock" name="stock" type="number" class="mt-2 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                          :value="old('stock', 10)" min="0" required placeholder="0" />
                            <x-input-error :messages="$errors->get('stock')" class="mt-1.5" />
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div>
                        <x-input-label for="price" :value="__('Harga Produk (Rupiah)')" class="font-bold text-gray-700 text-xs uppercase tracking-wider" />
                        <div class="relative mt-2">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-sm font-bold text-gray-400">Rp</span>
                            <x-text-input id="price" name="price" type="number" class="block w-full pl-11 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                          :value="old('price')" step="1000" min="0" placeholder="1500000" required />
                        </div>
                        <x-input-error :messages="$errors->get('price')" class="mt-1.5" />
                    </div>

                    {{-- URL Gambar & Live Preview --}}
                    <div x-data="{ imageUrl: '{{ old('image') }}' }">
                        <x-input-label for="image" :value="__('URL Gambar Produk')" class="font-bold text-gray-700 text-xs uppercase tracking-wider" />
                        <x-text-input id="image" name="image" type="url" class="mt-2 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm placeholder-gray-400"
                                      x-model="imageUrl" placeholder="https://images.unsplash.com/..." />
                        <p class="text-[11px] text-gray-400 mt-1">Gunakan URL gambar langsung (JPG, PNG, WebP). Kosongkan untuk gambar bawaan.</p>
                        <x-input-error :messages="$errors->get('image')" class="mt-1.5" />

                        <div x-show="imageUrl" class="mt-3 flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-gray-100">
                            <img :src="imageUrl" alt="Pratinjau" class="w-14 h-14 object-cover rounded-lg border border-gray-200 bg-white" 
                                 x-on:error="$el.src='https://placehold.co/100x100?text=Gambar+Invalid'">
                            <div class="text-xs text-gray-500">
                                <span class="font-bold text-gray-700 block">Pratinjau Gambar</span>
                                Pastikan tautan gambar dapat diakses secara publik.
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <x-input-label for="description" :value="__('Deskripsi Produk')" class="font-bold text-gray-700 text-xs uppercase tracking-wider" />
                        <textarea id="description" name="description" rows="4"
                                  placeholder="Jelaskan spesifikasi, keunggulan, atau garansi produk..."
                                  class="mt-2 block w-full border-gray-200 rounded-xl shadow-2xs focus:border-indigo-500 focus:ring-indigo-500 text-sm placeholder-gray-400">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1.5" />
                    </div>

                    {{-- Tombol Submit & Cancel --}}
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                        <a href="{{ route('products.index') }}"
                           class="px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Simpan Produk</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
