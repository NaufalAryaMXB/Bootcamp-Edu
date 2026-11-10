@props([
    'year' => date('Y')
])

<footer class="bg-gray-900 text-gray-300 border-t border-gray-800 mt-auto">
    <!-- Top Footer Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            
            <!-- Col 1: Brand & About -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold text-white">EduShop</span>
                </div>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Platform E-Commerce modern berbasis Laravel dengan implementasi Blade Template Engine, reusable components, dan integrasi database MySQL.
                </p>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-800 border border-gray-700 text-[11px] text-gray-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Tugas Bootcamp Eduwork Sesi 13</span>
                </div>
            </div>

            <!-- Col 2: Navigasi Utama -->
            <div class="space-y-3">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Halaman Utama</h3>
                <ul class="space-y-2 text-xs">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                            <span class="text-indigo-500">&rsaquo;</span> Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                            <span class="text-indigo-500">&rsaquo;</span> Katalog Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                            <span class="text-indigo-500">&rsaquo;</span> Keranjang Belanja
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.create') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                            <span class="text-indigo-500">&rsaquo;</span> Tambah Produk Baru
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 3: Informasi & Bantuan -->
            <div class="space-y-3">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Bantuan & Legal</h3>
                <ul class="space-y-2 text-xs">
                    <li>
                        <a href="{{ route('pages.about') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                            <span class="text-indigo-500">&rsaquo;</span> Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.contact') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                            <span class="text-indigo-500">&rsaquo;</span> Hubungi Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.faq') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                            <span class="text-indigo-500">&rsaquo;</span> Pertanyaan Umum (FAQ)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.terms') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                            <span class="text-indigo-500">&rsaquo;</span> Syarat & Ketentuan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 4: Teknologi & Komponen Blade -->
            <div class="space-y-3">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Komponen Blade</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Halaman ini dirender menggunakan struktur komponen Blade Laravel:
                </p>
                <div class="space-y-1.5 font-mono text-[11px]">
                    <div class="p-2 rounded bg-gray-800 text-indigo-300 border border-gray-700/60">
                        &lt;x-navbar /&gt;
                    </div>
                    <div class="p-2 rounded bg-gray-800 text-indigo-300 border border-gray-700/60">
                        &lt;x-footer /&gt;
                    </div>
                    <div class="p-2 rounded bg-gray-800 text-indigo-300 border border-gray-700/60">
                        &lt;x-product-card :product="$item" /&gt;
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Copyright Bar -->
    <div class="border-t border-gray-800 bg-gray-950 py-6 text-xs text-gray-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ $year }} EduShop. Dilindungi Hak Cipta. Tugas Bootcamp Eduwork Sesi 13.</p>
            <div class="flex items-center gap-4 text-xs">
                <span class="text-gray-400">Laravel Blade Engine</span>
                <span class="text-gray-600">&bull;</span>
                <span class="text-gray-400">Tailwind CSS</span>
                <span class="text-gray-600">&bull;</span>
                <span class="text-gray-400">MySQL Database</span>
            </div>
        </div>
    </div>
</footer>
