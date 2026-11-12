<x-guest-layout>
    <!-- Header Formulir Register -->
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Buat Akun Baru</h1>
        <p class="text-xs text-gray-500 mt-1">Daftar sekarang untuk mulai berbelanja di {{ config('app.name', 'EduShop') }}.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-semibold text-gray-700" />
            <x-text-input id="name" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" 
                          type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                          placeholder="Contoh: Budi Santoso" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" 
                          type="email" name="email" :value="old('email')" required autocomplete="username" 
                          placeholder="nama@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-gray-700" />

            <x-text-input id="password" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Minimal 8 karakter" />

            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-semibold text-gray-700" />

            <x-text-input id="password_confirmation" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ketik ulang kata sandi" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-200 transition font-bold text-sm">
                {{ __('Daftar Akun Baru') }}
            </x-primary-button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-3 border-t border-gray-100 mt-4">
            <p class="text-xs text-gray-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
