<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight">
            {{ __('Edit Kategori') }} &mdash; {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Back Link -->
            <div>
                <a href="{{ route('categories.index') }}" class="text-xs font-semibold text-gray-500 hover:text-indigo-600 inline-flex items-center gap-1 transition">
                    &larr; Kembali ke Daftar Kategori
                </a>
            </div>

            <!-- Card Form -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm">
                <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Nama Kategori')" class="font-bold text-gray-700" />
                        <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm" 
                                      :value="old('name', $category->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl text-xs text-gray-500">
                        Kategori ini saat ini memiliki <strong>{{ $category->products_count }} produk</strong> terhubung.
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                        <a href="{{ route('categories.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <x-primary-button class="py-2.5 px-6 rounded-xl bg-amber-600 hover:bg-amber-700 font-bold text-xs">
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
