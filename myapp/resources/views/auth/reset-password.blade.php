<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Atur Ulang Kata Sandi</h1>
        <p class="text-xs text-gray-500 mt-1">Buat kata sandi baru yang kuat untuk mengamankan akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" 
                          type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <x-text-input id="password" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" 
                          type="password" name="password" required autocomplete="new-password" 
                          placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <x-text-input id="password_confirmation" class="block mt-1.5 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Ketik ulang kata sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-200 transition font-bold text-sm">
                {{ __('Simpan Kata Sandi Baru') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
