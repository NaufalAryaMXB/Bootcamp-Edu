<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }} — {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Error Alert --}}
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

            {{-- Form Edit Produk --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sm:p-8">
                <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nama Produk --}}
                    <div>
                        <x-input-label for="name" :value="__('Nama Produk')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                      :value="old('name', $product->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Kategori & Stok --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="category" :value="__('Kategori')" />
                            <select id="category" name="category" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category', $product->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="stock" :value="__('Jumlah Stok')" />
                            <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full"
                                          :value="old('stock', $product->stock)" min="0" required />
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div>
                        <x-input-label for="price" :value="__('Harga (Rupiah)')" />
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-sm font-medium text-gray-400">Rp</span>
                            <x-text-input id="price" name="price" type="number" class="block w-full pl-10"
                                          :value="old('price', (int)$product->price)" step="1000" min="0" required />
                        </div>
                    </div>

                    {{-- URL Gambar --}}
                    <div>
                        <x-input-label for="image" :value="__('URL Gambar Produk')" />
                        <x-text-input id="image" name="image" type="url" class="mt-1 block w-full"
                                      :value="old('image', $product->image)" />
                        @if($product->image)
                            <div class="mt-2 flex items-center gap-3">
                                <img src="{{ $product->image }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200" alt="Preview">
                                <span class="text-xs text-gray-400">Pratinjau gambar saat ini</span>
                            </div>
                        @endif
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <x-input-label for="description" :value="__('Deskripsi Produk')" />
                        <textarea id="description" name="description" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                        <a href="{{ route('products.index') }}"
                           class="px-5 py-2.5 rounded-md border border-gray-300 text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-md bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold shadow-sm transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
