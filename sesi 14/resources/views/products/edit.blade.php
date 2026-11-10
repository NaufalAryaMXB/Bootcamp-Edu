@extends('layouts.app')

@section('title', 'Edit Produk - ' . $product->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Breadcrumb & Title -->
    <div class="flex items-center justify-between pb-3 border-b border-gray-200">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Edit Data Produk</h1>
            <p class="text-xs text-gray-500 mt-1">Dikelola melalui <code class="text-indigo-600 font-semibold">ProductController@update</code></p>
        </div>
        <a href="{{ route('products.index') }}" class="text-xs font-semibold text-gray-600 hover:text-indigo-600">&larr; Kembali ke Katalog</a>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs space-y-1">
            <span class="font-bold block text-sm">Terjadi kesalahan input:</span>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit Produk -->
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200 shadow-sm space-y-5">
        @csrf
        @method('PUT')

        <!-- Nama Produk -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Produk <span class="text-rose-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>

        <!-- Kategori & Stok -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori <span class="text-rose-500">*</span></label>
                <select name="category" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white">
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category', $product->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jumlah Stok <span class="text-rose-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
        </div>

        <!-- Harga -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Harga (Rupiah) <span class="text-rose-500">*</span></label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-gray-400">Rp</span>
                <input type="number" name="price" value="{{ old('price', (int)$product->price) }}" step="1000" min="0" required class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
        </div>

        <!-- URL Gambar -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">URL Gambar Produk</label>
            <input type="url" name="image" value="{{ old('image', $product->image) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            @if($product->image)
                <div class="mt-2 flex items-center gap-3">
                    <img src="{{ $product->image }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200" alt="Preview">
                    <span class="text-[11px] text-gray-400">Pratinjau gambar saat ini</span>
                </div>
            @endif
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Produk</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Tombol Submit -->
        <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
            <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold shadow-md transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
