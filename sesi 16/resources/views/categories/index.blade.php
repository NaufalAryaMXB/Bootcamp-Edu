<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Daftar Kategori Produk') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Kelola seluruh kategori produk e-commerce Anda.</p>
            </div>
            <div>
                <!-- Tombol Tambah Kategori -->
                <a href="{{ route('categories.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-indigo-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Kategori</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Search & Toolbar -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <form method="GET" action="{{ route('categories.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
                    <div class="relative w-full sm:w-72">
                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..." class="w-full pl-10 pr-3.5 py-2 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('categories.index') }}" class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline">Reset</a>
                    @endif
                </form>

                <div class="text-xs text-gray-500 text-right w-full sm:w-auto">
                    Total: <strong class="text-gray-900 font-bold">{{ $categories->total() }}</strong> Kategori
                </div>
            </div>

            <!-- Tabel Kategori (Tugas 2: ID, Nama Kategori, Jumlah Produk, Tombol: Tambah, Edit, Hapus) -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead class="bg-gray-50/80 border-b border-gray-100 text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 sm:px-6 w-20 text-center">ID</th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6">Nama Kategori</th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6 text-center w-36">Jumlah Produk</th>
                                <th scope="col" class="py-3.5 px-4 sm:px-6 text-right w-44">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($categories as $category)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <!-- ID -->
                                    <td class="py-4 px-4 sm:px-6 text-center font-bold text-gray-500">
                                        #{{ $category->id }}
                                    </td>

                                    <!-- Nama Kategori -->
                                    <td class="py-4 px-4 sm:px-6">
                                        <div class="font-bold text-gray-900 text-sm sm:text-base">{{ $category->name }}</div>
                                        <span class="text-[11px] text-gray-400">Dibuat {{ $category->created_at?->diffForHumans() ?? '-' }}</span>
                                    </td>

                                    <!-- Jumlah Produk -->
                                    <td class="py-4 px-4 sm:px-6 text-center">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $category->products_count > 0 ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-gray-100 text-gray-500' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                            {{ $category->products_count }} Produk
                                        </span>
                                    </td>

                                    <!-- Tombol: Edit dan Hapus -->
                                    <td class="py-4 px-4 sm:px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('categories.edit', $category->id) }}" 
                                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-lg text-xs font-bold transition"
                                               title="Edit Kategori">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Edit</span>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ $category->name }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-bold transition"
                                                        title="Hapus Kategori">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-gray-400">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                        <p class="font-bold text-gray-600 text-sm">Belum Ada Kategori</p>
                                        <p class="text-xs text-gray-400 mt-1">Silakan tambahkan kategori baru untuk mulai mengelompokkan produk.</p>
                                        <a href="{{ route('categories.create') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold">Tambah Kategori</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
