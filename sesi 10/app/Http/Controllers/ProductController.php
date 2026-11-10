<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar semua produk (dengan filter kategori & pencarian).
     * Route: GET /products
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sortBy = $request->get('sort', 'latest');
        match ($sortBy) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12);

        $categories = Product::select('category')
            ->distinct()
            ->pluck('category');

        if (!view()->exists('products.index')) {
            return response()->json([
                'route'      => '/products',
                'page'       => 'Daftar Produk E-Commerce',
                'message'    => 'Route /products berhasil berjalan!',
                'categories' => $categories,
                'products'   => $products
            ]);
        }

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Tampilkan detail satu produk.
     * Route: GET /products/{id}
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $relatedProducts = Product::byCategory($product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        if (!view()->exists('products.show')) {
            return response()->json([
                'route'            => "/products/{$id}",
                'page'             => 'Detail Produk',
                'product'          => $product,
                'related_products' => $relatedProducts
            ]);
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
