<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Error Validation Alert --}}
            @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg text-sm space-y-1">
                    <span class="font-bold block">Terjadi kesalahan input:</span>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Tambah Produk --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sm:p-8">
                <form action="{{ route('products.store') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nama Produk --}}
                    <div>
                        <x-input-label for="name" :value="__('Nama Produk')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')"
                                      required placeholder="Contoh: Wireless Mechanical Keyboard RGB" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Kategori & Stok --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="category" :value="__('Kategori')" />
                            <select id="category" name="category" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="stock" :value="__('Jumlah Stok')" />
                            <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full"
                                          :value="old('stock', 10)" min="0" required />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div>
                        <x-input-label for="price" :value="__('Harga (Rupiah)')" />
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-sm font-medium text-gray-400">Rp</span>
                            <x-text-input id="price" name="price" type="number" class="block w-full pl-10"
                                          :value="old('price')" step="1000" min="0" placeholder="750000" required />
                        </div>
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    {{-- URL Gambar --}}
                    <div>
                        <x-input-label for="image" :value="__('URL Gambar Produk (Opsional)')" />
                        <x-text-input id="image" name="image" type="url" class="mt-1 block w-full"
                                      :value="old('image')" placeholder="https://images.unsplash.com/photo-..." />
                        <p class="text-xs text-gray-400 mt-1">Biarkan kosong untuk menggunakan gambar default.</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <x-input-label for="description" :value="__('Deskripsi Produk')" />
                        <textarea id="description" name="description" rows="4"
                                  placeholder="Jelaskan spesifikasi dan keunggulan produk..."
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('description') }}</textarea>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                        <a href="{{ route('products.index') }}"
                           class="px-5 py-2.5 rounded-md border border-gray-300 text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <x-primary-button>
                            {{ __('Simpan Produk') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
