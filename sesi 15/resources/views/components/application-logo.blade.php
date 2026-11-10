<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}>
    {{-- Custom Brand Icon: Modern Shopping Bag + Tech Star --}}
    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-700 to-violet-600 text-white shadow-md shadow-indigo-500/20">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
            <path d="M3 6h18"/>
            <path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
    </div>
    <div class="flex flex-col text-left">
        <span class="text-xl font-black tracking-tight text-gray-900 leading-none">
            Edu<span class="text-indigo-600">Shop</span>
        </span>
        <span class="text-[10px] font-semibold text-gray-400 tracking-wider uppercase mt-0.5">
            E-Commerce Store
        </span>
    </div>
</div>
