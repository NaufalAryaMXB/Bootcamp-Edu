<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama / beranda E-Commerce.
     * Route: GET /
     */
    public function index()
    {
        $featuredProducts = Product::latest()->take(8)->get();

        if (!view()->exists('home')) {
            return view()->exists('welcome') 
                ? view('welcome', ['products' => $featuredProducts])
                : response()->json([
                    'route'    => '/',
                    'page'     => 'Home / Beranda E-Commerce',
                    'message'  => 'Route / berhasil berjalan!',
                    'total_produk' => $featuredProducts->count(),
                    'products' => $featuredProducts
                ]);
        }

        return view('home', compact('featuredProducts'));
    }
}
