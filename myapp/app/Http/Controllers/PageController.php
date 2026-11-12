<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * ==========================================================
     * Controller untuk Mengelola Halaman Website (PageController)
     * ==========================================================
     */

    /**
     * Halaman Utama / Beranda (Home)
     * Route: GET /
     */
    public function home()
    {
        // Mengambil produk terbaru untuk ditampilkan di beranda
        $featuredProducts = Product::latest()->take(8)->get();
        $totalProducts    = Product::count();
        $categories       = Category::pluck('name');
        if ($categories->isEmpty()) {
            $categories = Product::select('category')->distinct()->pluck('category');
        }

        if (!view()->exists('home')) {
            return response()->json([
                'page'              => 'Home / Beranda',
                'message'           => 'Controller Mengelola Halaman (PageController@home) berhasil berjalan!',
                'total_produk'      => $totalProducts,
                'featured_products' => $featuredProducts
            ]);
        }

        return view('home', compact('featuredProducts', 'totalProducts', 'categories'));
    }

    /**
     * Halaman Tentang Kami (About Us)
     * Route: GET /about
     */
    public function about()
    {
        $info = [
            'app_name'    => 'EduShop E-Commerce',
            'version'     => '1.0.0 (Sesi 12)',
            'description' => 'Platform E-Commerce modern berbasis Laravel yang dibangun selama bootcamp Eduwork.',
            'vision'      => 'Memberikan pengalaman belanja online teknologi yang cepat, mudah, dan aman.',
            'mission'     => [
                'Menyediakan produk periferal komputer & gadget berkualitas',
                'Pelayanan pelanggan responsif 24/7',
                'Pengiriman cepat dan bergaransi resmi'
            ]
        ];

        if (!view()->exists('pages.about')) {
            return response()->json([
                'page'    => 'Tentang Kami (About Us)',
                'message' => 'Controller Mengelola Halaman (PageController@about) berhasil berjalan!',
                'data'    => $info
            ]);
        }

        return view('pages.about', compact('info'));
    }

    /**
     * Halaman Kontak (Contact Us)
     * Route: GET /contact
     */
    public function contact()
    {
        $contactInfo = [
            'email'    => 'support@edushop.test',
            'phone'    => '+62 812-3456-7890',
            'address'  => 'Gedung Eduwork Lt. 3, Jakarta Selatan',
            'work_hours' => 'Senin - Jumat, 09:00 - 18:00 WIB'
        ];

        if (!view()->exists('pages.contact')) {
            return response()->json([
                'page'    => 'Kontak Kami (Contact Us)',
                'message' => 'Controller Mengelola Halaman (PageController@contact) berhasil berjalan!',
                'data'    => $contactInfo
            ]);
        }

        return view('pages.contact', compact('contactInfo'));
    }

    /**
     * Memproses Pengiriman Pesan Kontak
     * Route: POST /contact
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10',
        ]);

        // Dalam implementasi penuh, data ini bisa dikirim ke email atau disimpan ke tabel messages
        return back()->with('success', "Terima kasih, {$validated['name']}! Pesan Anda telah kami terima.");
    }

    /**
     * Halaman Tanya Jawab / FAQ
     * Route: GET /faq
     */
    public function faq()
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara memesan produk di EduShop?',
                'answer'   => 'Pilih produk di halaman Katalog Produk, klik tombol Tambah ke Keranjang, lalu buka halaman Checkout untuk mengisi data pengiriman.'
            ],
            [
                'question' => 'Apakah barang bergaransi?',
                'answer'   => 'Semua produk elektronik dan aksesoris di EduShop bergaransi resmi distributor selama 1 tahun.'
            ],
            [
                'question' => 'Metode pembayaran apa saja yang didukung?',
                'answer'   => 'Kami mendukung Transfer Bank, Virtual Account, dan sistem pembayaran digital lainnya.'
            ]
        ];

        if (!view()->exists('pages.faq')) {
            return response()->json([
                'page'    => 'FAQ / Pertanyaan Umum',
                'message' => 'Controller Mengelola Halaman (PageController@faq) berhasil berjalan!',
                'data'    => $faqs
            ]);
        }

        return view('pages.faq', compact('faqs'));
    }

    /**
     * Halaman Syarat & Ketentuan (Terms & Conditions)
     * Route: GET /terms
     */
    public function terms()
    {
        if (!view()->exists('pages.terms')) {
            return response()->json([
                'page'    => 'Syarat & Ketentuan',
                'message' => 'Controller Mengelola Halaman (PageController@terms) berhasil berjalan!'
            ]);
        }

        return view('pages.terms');
    }
}
