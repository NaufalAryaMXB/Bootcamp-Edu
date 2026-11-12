<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Lupa Kata Sandi?</h1>
        <p class="text-xs text-gray-500 mt-1">Masukkan alamat email terdaftar Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" 
                          type="email" name="email" :value="old('email')" required autofocus 
                          placeholder="nama@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-200 transition font-bold text-sm">
                {{ __('Kirim Tautan Reset Sandi') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-3 border-t border-gray-100 mt-4">
            <a href="{{ route('login') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                &larr; Kembali ke Halaman Masuk
            </a>
        </div>
    </form>
</x-guest-layout>
