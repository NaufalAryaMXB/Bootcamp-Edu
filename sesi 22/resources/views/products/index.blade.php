<x-app-layout>
    {{-- Page Header --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Daftar Produk') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Kelola data inventaris dan katalog produk toko online.</p>
            </div>
            <div>
                @auth
                    @if(Auth::user()->isAdmin())
                        <!-- Tombol Tambah Produk (Hanya Admin) -->
                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md shadow-indigo-100 transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Produk</span>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Message: Notifikasi Sukses --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs sm:text-sm font-medium flex items-center gap-2 shadow-xs">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Toolbar: Search, Category Filter, and Sort --}}
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        {{-- Search Box --}}
                        <div class="relative w-full sm:w-64">
                            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama / deskripsi..."
                                   class="w-full pl-10 pr-3.5 py-2 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>

                        {{-- Category Filter --}}
                        <select name="category" class="px-3.5 py-2 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>

                        {{-- Sort Filter --}}
                        <select name="sort" class="px-3.5 py-2 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A - Z</option>
                        </select>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-xs">
                            Filter
                        </button>

                        @if(request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route('products.index') }}" class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline ml-1">
                                Reset
                            </a>
                        @endif
                    </div>

                    <div class="text-xs text-gray-500 w-full md:w-auto text-left md:text-right">
                        Menampilkan <strong class="text-gray-900">{{ $products->count() }}</strong> dari <strong class="text-gray-900">{{ $products->total() }}</strong> Produk
                    </div>
                </form>
            </div>

            {{-- Tabel Produk (Tugas 3: id, nama, deskripsi, stok, harga, gambar, tombol: tambah, edit, hapus) --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead class="bg-gray-50/80 border-b border-gray-100 text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 sm:px-6 w-16 text-center">ID</th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6 w-20 text-center">Gambar</th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6">Nama Produk</th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6">Deskripsi</th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6 text-center w-24">Stok</th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6 text-right w-36">Harga</th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6 text-right w-44">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($products as $product)
                                <tr class="hover:bg-slate-50/80 transition">
                                    {{-- 1. ID --}}
                                    <td class="py-4 px-4 sm:px-6 text-center font-bold text-gray-500">
                                        #{{ $product->id }}
                                    </td>

                                    {{-- 2. Gambar --}}
                                    <td class="py-4 px-4 sm:px-6 text-center">
                                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 border border-gray-100 flex items-center justify-center mx-auto shadow-2xs">
                                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&q=80' }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                    </td>

                                    {{-- 3. Nama Produk & Kategori --}}
                                    <td class="py-4 px-4 sm:px-6">
                                        <a href="{{ route('products.show', $product->id) }}" class="font-bold text-gray-900 hover:text-indigo-600 transition block">
                                            {{ $product->name }}
                                        </a>
                                        <span class="inline-block mt-1 text-[10px] font-extrabold uppercase tracking-wider text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">
                                            {{ $product->productCategory->name ?? $product->category ?? 'Umum' }}
                                        </span>
                                    </td>

                                    {{-- 4. Deskripsi --}}
                                    <td class="py-4 px-4 sm:px-6 max-w-xs">
                                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                            {{ $product->description ?: 'Tidak ada deskripsi.' }}
                                        </p>
                                    </td>

                                    {{-- 5. Stok --}}
                                    <td class="py-4 px-4 sm:px-6 text-center">
                                        @if($product->stock <= 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                Habis
                                            </span>
                                        @elseif($product->stock < 5)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                {{ $product->stock }} (Menipis)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                {{ $product->stock }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- 6. Harga --}}
                                    <td class="py-4 px-4 sm:px-6 text-right font-black text-indigo-600 text-sm sm:text-base">
                                        {{ $product->formatted_price }}
                                    </td>

                                    {{-- 7. Tombol Aksi: Tambah (di atas), Edit, Hapus (Khusus Admin) --}}
                                    <td class="py-4 px-4 sm:px-6 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            @auth
                                                @if(Auth::user()->isAdmin())
                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-lg text-xs font-bold transition"
                                                       title="Edit Produk">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                        <span>Edit</span>
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                          onsubmit="return confirm('Hapus produk \'{{ $product->name }}\'?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-bold transition"
                                                                title="Hapus Produk">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            <span>Hapus</span>
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('products.show', $product->id) }}"
                                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold transition">
                                                        <span>Lihat Detail &rarr;</span>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{ route('products.show', $product->id) }}"
                                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold transition">
                                                    <span>Lihat Detail &rarr;</span>
                                                </a>
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-gray-400">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <p class="font-bold text-gray-600 text-sm">Tidak Ada Produk yang Ditemukan</p>
                                        <p class="text-xs text-gray-400 mt-1">Coba sesuaikan filter atau tambahkan produk baru.</p>
                                        <a href="{{ route('products.create') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold">Tambah Produk Baru</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if($products->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
