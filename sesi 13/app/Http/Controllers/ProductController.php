<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * ==========================================================
     * Controller untuk Mengelola Produk (ProductController - CRUD)
     * ==========================================================
     */

    /**
     * 1. Menampilkan daftar / katalog semua produk
     * Route: GET /products
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter berdasarkan kategori jika ada parameter ?category=...
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Pencarian berdasarkan nama produk jika ada parameter ?search=...
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Pengurutan produk (sort)
        $sortBy = $request->get('sort', 'latest');
        match ($sortBy) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            default      => $query->latest(),
        };

        // Paginasi: 8 produk per halaman
        $products = $query->paginate(8)->withQueryString();

        // Mengambil kategori dari tabel categories (atau fallback ke distinct produk)
        $categories = Category::pluck('name');
        if ($categories->isEmpty()) {
            $categories = Product::select('category')->distinct()->pluck('category');
        }

        if (!view()->exists('products.index')) {
            return response()->json([
                'page'       => 'Daftar Produk E-Commerce',
                'message'    => 'ProductController@index berhasil!',
                'categories' => $categories,
                'products'   => $products
            ]);
        }

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * 2. Menampilkan formulir tambah produk baru
     * Route: GET /products/create
     */
    public function create()
    {
        $categories = Category::pluck('name');
        if ($categories->isEmpty()) {
            $categories = collect(['Elektronik & Komputer', 'Aksesoris & Periferal', 'Audio & Headset', 'Gaming Gear', 'Smart Gadget']);
        }

        if (!view()->exists('products.create')) {
            return response()->json([
                'page'       => 'Form Tambah Produk Baru',
                'message'    => 'ProductController@create berhasil!',
                'categories' => $categories
            ]);
        }

        return view('products.create', compact('categories'));
    }

    /**
     * 3. Menyimpan data produk baru ke database
     * Route: POST /products
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string|max:50',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|url|max:255',
        ]);

        // Berikan gambar default jika input gambar kosong
        if (empty($validated['image'])) {
            $validated['image'] = 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=600&q=80';
        }

        // Simpan ke database menggunakan Eloquent Model
        $product = Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', "Produk '{$product->name}' berhasil ditambahkan ke katalog!");
    }

    /**
     * 4. Menampilkan detail spesifik satu produk
     * Route: GET /products/{id}
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Rekomendasi produk terkait dalam kategori yang sama
        $relatedProducts = Product::byCategory($product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        if (!view()->exists('products.show')) {
            return response()->json([
                'page'             => "Detail Produk: {$product->name}",
                'message'          => 'ProductController@show berhasil!',
                'product'          => $product,
                'related_products' => $relatedProducts
            ]);
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * 5. Menampilkan formulir edit produk
     * Route: GET /products/{id}/edit
     */
    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = ['Aksesoris', 'Wearable', 'Audio', 'Gadget', 'Komputer', 'Umum'];

        if (!view()->exists('products.edit')) {
            return response()->json([
                'page'       => "Form Edit Produk: {$product->name}",
                'message'    => 'ProductController@edit berhasil!',
                'product'    => $product,
                'categories' => $categories
            ]);
        }

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * 6. Memperbarui data produk di database
     * Route: PUT/PATCH /products/{id}
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string|max:50',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|url|max:255',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', "Data produk '{$product->name}' berhasil diperbarui!");
    }

    /**
     * 7. Menghapus produk dari database
     * Route: DELETE /products/{id}
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $productName = $product->name;

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Produk '{$productName}' berhasil dihapus dari sistem.");
    }
}
