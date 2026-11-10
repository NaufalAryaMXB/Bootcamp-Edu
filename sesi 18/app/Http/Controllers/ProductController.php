<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

/**
 * ============================================================
 * Sesi 15 - ProductController
 * ============================================================
 *
 * Tugas 2: Tampilkan data produk menggunakan Controller dan Blade.
 * Tugas 3: Pagination untuk membatasi data per halaman.
 *
 * Controller ini mengelola seluruh operasi CRUD produk
 * dan memanfaatkan relasi Product -> ProductCategory.
 */
class ProductController extends Controller
{
    /**
     * 1. Menampilkan daftar / katalog semua produk (dengan Pagination)
     * Route: GET /products
     *
     * Tugas 2: Data produk ditampilkan via Controller ke Blade view.
     * Tugas 3: Pagination menggunakan ->paginate(8) untuk membatasi
     *          jumlah data yang tampil dalam satu halaman.
     */
    public function index(Request $request)
    {
        // Query produk dengan eager loading relasi ProductCategory
        $query = Product::with('productCategory');

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

        // ============================================================
        // TUGAS 3: Pagination - Membatasi 8 produk per halaman
        // ============================================================
        // ->paginate(8) menghasilkan LengthAwarePaginator
        // ->withQueryString() mempertahankan parameter GET saat pindah halaman
        $products = $query->paginate(8)->withQueryString();

        // Mengambil kategori dari tabel categories via model ProductCategory
        $categories = ProductCategory::pluck('name');

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * 2. Menampilkan formulir tambah produk baru
     * Route: GET /products/create
     */
    public function create()
    {
        // Mengambil kategori dari ProductCategory model
        $categories = ProductCategory::pluck('name');
        if ($categories->isEmpty()) {
            $categories = collect(['Elektronik & Komputer', 'Aksesoris & Periferal', 'Audio & Headset', 'Gaming Gear', 'Smart Gadget']);
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

        // Cari atau buat ProductCategory berdasarkan nama, lalu set category_id
        $productCategory = ProductCategory::firstOrCreate(['name' => $validated['category']]);
        $validated['category_id'] = $productCategory->id;

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
        // Eager load relasi productCategory
        $product = Product::with('productCategory')->findOrFail($id);

        // Tugas Sesi 18: Catat klik produk setiap kali halaman detail dibuka
        $product->increment('clicks');

        // Rekomendasi produk terkait dalam kategori yang sama
        $relatedProducts = Product::byCategory($product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * 5. Menampilkan formulir edit produk
     * Route: GET /products/{id}/edit
     */
    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = ProductCategory::pluck('name');
        if ($categories->isEmpty()) {
            $categories = collect(['Aksesoris', 'Wearable', 'Audio', 'Gadget', 'Komputer', 'Umum']);
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

        // Update category_id berdasarkan nama kategori
        $productCategory = ProductCategory::firstOrCreate(['name' => $validated['category']]);
        $validated['category_id'] = $productCategory->id;

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
