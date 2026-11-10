@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    <!-- Header -->
    <div class="text-center space-y-3">
        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full">Dikelola oleh PageController@about</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Tentang EduShop E-Commerce</h1>
        <p class="text-sm text-gray-500 max-w-xl mx-auto">{{ $info['description'] }}</p>
    </div>

    <!-- Vision & Mission Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200 shadow-sm space-y-3">
            <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Visi Kami</h2>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $info['vision'] }}</p>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200 shadow-sm space-y-3">
            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Misi Kami</h2>
            <ul class="space-y-2 text-sm text-gray-600">
                @foreach($info['mission'] as $item)
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-500 font-bold">&#10003;</span>
                        <span>{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Tech Stack Info -->
    <div class="bg-gradient-to-r from-gray-900 to-indigo-950 rounded-2xl p-8 text-white space-y-4">
        <h3 class="text-lg font-bold">Teknologi yang Digunakan</h3>
        <p class="text-xs text-gray-300 leading-relaxed">Website ini dibangun dengan arsitektur MVC (Model-View-Controller) menggunakan Framework Laravel 11, database MySQL dari Laragon, serta styling modern responsif.</p>
        <div class="flex flex-wrap gap-2 pt-2">
            <span class="px-3 py-1 bg-white/10 rounded-lg text-xs font-semibold">Laravel 11</span>
            <span class="px-3 py-1 bg-white/10 rounded-lg text-xs font-semibold">PHP 8.3</span>
            <span class="px-3 py-1 bg-white/10 rounded-lg text-xs font-semibold">MySQL (ecommerce_db)</span>
            <span class="px-3 py-1 bg-white/10 rounded-lg text-xs font-semibold">Tailwind CSS</span>
        </div>
    </div>
</div>
@endsection
