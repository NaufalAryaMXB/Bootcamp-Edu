<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama / beranda E-Commerce.
     * Route: GET /
     * 
     * Sesi 20 & 24: Tampilkan data Kategori Produk dan Produk di halaman tampilan 
     * beserta produk terpopuler berdasarkan jumlah klik.
     */
    public function index()
    {
        // 1. Mengambil data Kategori Produk beserta jumlah produknya
        $categories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(6)
            ->get();

        // 2. Mengambil data Produk unggulan / terbaru beserta relasi kategorinya
        $featuredProducts = Product::with('productCategory')
            ->latest()
            ->take(8)
            ->get();

        // 3. Mengambil produk dengan interaksi/klik tertinggi (kolom klik / clicks)
        $clickColumn = Schema::hasColumn('products', 'klik') ? 'klik' : 'clicks';
        $popularProducts = Product::with('productCategory')
            ->orderBy($clickColumn, 'desc')
            ->take(4)
            ->get();

        return view('welcome', compact('categories', 'featuredProducts', 'popularProducts'));
    }
}
