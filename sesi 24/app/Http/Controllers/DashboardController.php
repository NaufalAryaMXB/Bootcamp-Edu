<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * ============================================================
 * Sesi 23 - DashboardController
 * ============================================================
 * 
 * Controller untuk mengelola halaman Dashboard Admin:
 * Menampilkan ringkasan metrik data dari database:
 * 1. Jumlah Produk
 * 2. Jumlah Klik Produk
 * 3. Jumlah Kategori Produk
 */
class DashboardController extends Controller
{
    /**
     * TUGAS 23 - No 3:
     * Menampilkan data dari database ke halaman dashboard admin:
     * - Jumlah Produk
     * - Jumlah Klik Produk
     * - Jumlah Kategori
     * 
     * Route: GET /dashboard
     */
    public function index()
    {
        // 1. Jumlah Produk dari database
        $jumlahProduk  = Product::count();
        $totalProducts = $jumlahProduk;

        // 2. Jumlah Kategori dari database
        $jumlahKategori  = Category::count();
        $totalCategories = $jumlahKategori;

        // 3. Jumlah Klik Produk dari database (mendukung kolom 'klik' maupun 'clicks')
        if (Schema::hasColumn('products', 'klik')) {
            $jumlahKlikProduk = (int) Product::sum('klik');
            if ($jumlahKlikProduk === 0 && Schema::hasColumn('products', 'clicks')) {
                $jumlahKlikProduk = (int) Product::sum('clicks');
            }
        } else {
            $jumlahKlikProduk = (int) Product::sum('clicks');
        }
        $totalClicks = $jumlahKlikProduk;

        // Metrik & data pendukung untuk visualisasi dashboard:
        // Top 5 Produk paling banyak diklik / dilihat
        $clickColumn = Schema::hasColumn('products', 'klik') ? 'klik' : 'clicks';
        $topClickedProducts = Product::with('productCategory')
            ->orderBy($clickColumn, 'desc')
            ->take(5)
            ->get();

        // 5 Produk terbaru
        $recentProducts = Product::with('productCategory')
            ->latest()
            ->take(5)
            ->get();

        // Kategori terpopuler berdasarkan jumlah produknya
        $popularCategories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get();

        // Jumlah produk dengan stok menipis (< 5)
        $lowStockCount = Product::where('stock', '<', 5)->count();

        // Melempar seluruh data ke tampilan dashboard.blade.php
        return view('dashboard', compact(
            'jumlahProduk',
            'totalProducts',
            'jumlahKategori',
            'totalCategories',
            'jumlahKlikProduk',
            'totalClicks',
            'topClickedProducts',
            'recentProducts',
            'popularCategories',
            'lowStockCount'
        ));
    }
}
