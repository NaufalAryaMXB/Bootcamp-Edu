<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-violet-700 rounded-2xl p-6 sm:p-8 text-white shadow-lg shadow-indigo-200">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                            Dashboard Akun
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-black">
                            Halo, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-indigo-100 text-sm mt-1 max-w-xl">
                            Selamat datang di panel kontrol <strong>{{ config('app.name', 'EduShop') }}</strong>. Autentikasi dengan Laravel Breeze berhasil disesuaikan!
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-white text-indigo-700 hover:bg-indigo-50 font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                            Lihat Katalog Produk &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 font-semibold uppercase">Status Login</div>
                        <div class="text-sm font-bold text-gray-800">Terautentikasi</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 font-semibold uppercase">Sistem Autentikasi</div>
                        <div class="text-sm font-bold text-gray-800">Laravel Breeze</div>
                        <div class="text-xs text-emerald-600 font-medium">Aktif & Siap Pakai</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 font-semibold uppercase">Nama Website</div>
                        <div class="text-sm font-bold text-gray-800">{{ config('app.name', 'EduShop') }}</div>
                        <div class="text-xs text-gray-500">Platform E-Commerce</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
