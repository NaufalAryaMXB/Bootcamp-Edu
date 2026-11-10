<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Admin (Tugas Sesi 18).
     * Ringkasan informasi:
     * 1. Jumlah produk
     * 2. Jumlah kategori produk
     * 3. Jumlah klik produk (total dan produk paling banyak diklik)
     */
    public function index()
    {
        // 1. Jumlah produk
        $totalProducts = Product::count();

        // 2. Jumlah kategori produk
        $totalCategories = Category::count();

        // 3. Jumlah klik produk
        $totalClicks = (int) Product::sum('clicks');

        // Statistik pendukung:
        // Produk dengan klik terbanyak (Top Viewed)
        $topClickedProducts = Product::with('productCategory')
            ->orderBy('clicks', 'desc')
            ->take(5)
            ->get();

        // Produk terbaru yang baru ditambahkan
        $recentProducts = Product::with('productCategory')
            ->latest()
            ->take(5)
            ->get();

        // Kategori terpopuler berdasarkan jumlah produk
        $popularCategories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get();

        // Stok produk menipis (< 5)
        $lowStockCount = Product::where('stock', '<', 5)->count();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalClicks',
            'topClickedProducts',
            'recentProducts',
            'popularCategories',
            'lowStockCount'
        ));
    }
}
