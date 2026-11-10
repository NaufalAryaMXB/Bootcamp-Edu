<x-guest-layout>
    <!-- Header Formulir Login -->
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Selamat Datang Kembali</h1>
        <p class="text-xs text-gray-500 mt-1">Masuk ke akun {{ config('app.name', 'EduShop') }} Anda untuk melanjutkan.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" 
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                          placeholder="nama@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-gray-700" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition" href="{{ route('password.request') }}">
                        {{ __('Lupa sandi?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-xs font-medium text-gray-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-200 transition font-bold text-sm">
                {{ __('Masuk ke Akun') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-3 border-t border-gray-100 mt-4">
            <p class="text-xs text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
