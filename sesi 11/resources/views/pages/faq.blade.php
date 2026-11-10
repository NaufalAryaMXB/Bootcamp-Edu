@extends('layouts.app')

@section('title', 'Tanya Jawab / FAQ')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full">Dikelola oleh PageController@faq</span>
        <h1 class="text-3xl font-extrabold text-gray-900">Pertanyaan yang Sering Diajukan (FAQ)</h1>
        <p class="text-xs text-gray-500">Temukan jawaban cepat untuk pertanyaan umum seputar layanan dan produk EduShop.</p>
    </div>

    <div class="space-y-4">
        @foreach($faqs as $faq)
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-2">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-extrabold">Q</span>
                    {{ $faq['question'] }}
                </h3>
                <p class="text-xs text-gray-600 pl-8 leading-relaxed">{{ $faq['answer'] }}</p>
            </div>
        @endforeach
    </div>

    <!-- Help Box -->
    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 text-center space-y-2">
        <h4 class="font-bold text-indigo-900 text-sm">Masih punya pertanyaan lain?</h4>
        <p class="text-xs text-indigo-700">Hubungi tim customer service kami melalui formulir kontak.</p>
        <div class="pt-2">
            <a href="{{ route('pages.contact') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition">Hubungi Kami &rarr;</a>
        </div>
    </div>
</div>
@endsection
