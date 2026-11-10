<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('dashboard') : route('products.index') }}">
                        <x-application-logo class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>

                            <!-- Link List Kategori Produk (Hanya Admin) -->
                            <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                {{ __('Kategori Produk') }}
                            </x-nav-link>
                        @endif
                    @endauth

                    <!-- Link List Produk (Semua Pengunjung & User) -->
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Daftar Produk') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Kanan Atas: Icon Keranjang Belanja + Profile/Auth -->
            <div class="hidden sm:flex sm:items-center sm:gap-3 sm:ms-6">
                <!-- Icon Keranjang Belanja di Kanan Atas -->
                <a href="{{ route('cart.index') }}" 
                   class="relative p-2 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50/70 rounded-xl transition duration-150"
                   title="Lihat Keranjang Belanja">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>

                    @php 
                        $cartCount = auth()->check() 
                            ? \App\Models\CartItem::where('user_id', auth()->id())->count() 
                            : count(session('cart', [])); 
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 min-w-[20px] h-5 px-1.5 flex items-center justify-center text-[10px] font-black text-white bg-indigo-600 rounded-full shadow-sm ring-2 ring-white animate-pulse">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                @auth
                    <!-- Dropdown Profil User -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-xl text-gray-700 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1.5">
                                    <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil Saya') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="text-rose-600">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-xs font-bold text-gray-600 hover:text-indigo-600 px-3 py-2 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-3.5 py-2 rounded-xl shadow-xs transition">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger & Mobile Cart -->
            <div class="-me-2 flex items-center gap-2 sm:hidden">
                <!-- Mobile Cart Icon -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @if(count(session('cart', [])) > 0)
                        <span class="absolute top-1 right-1 w-4 h-4 flex items-center justify-center text-[9px] font-black text-white bg-indigo-600 rounded-full">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(Auth::user()->isAdmin())
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        {{ __('Kategori Produk') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                {{ __('Daftar Produk') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                {{ __('Keranjang Belanja') }} ({{ count(session('cart', [])) }})
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profil Saya') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Keluar') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 py-2 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="block text-center text-xs font-bold text-indigo-600 bg-indigo-50 py-2 rounded-xl">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="block text-center text-xs font-bold text-white bg-indigo-600 py-2 rounded-xl">
                        Daftar Akun Baru
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
