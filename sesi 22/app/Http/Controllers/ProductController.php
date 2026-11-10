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
     * TUGAS 21 - No 1:
     * Menampilkan formulir tambah produk baru.
     * Route: GET /admin/products/create atau GET /products/create
     */
    public function create()
    {
        // Mengambil daftar kategori dari ProductCategory model
        $categories = ProductCategory::pluck('name');
        if ($categories->isEmpty()) {
            $categories = collect(['Elektronik & Komputer', 'Aksesoris & Periferal', 'Audio & Headset', 'Gaming Gear', 'Smart Gadget']);
        }

        if (view()->exists('product.create')) {
            return view('product.create', compact('categories'));
        }

        return view('products.create', compact('categories'));
    }

    /**
     * TUGAS 21 - No 4:
     * Memvalidasi input dan menyimpan produk baru ke database.
     * Route: POST /products (name: product.store)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Produk
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|url|max:255',
        ], [
            'name.required'     => 'Nama produk wajib diisi.',
            'name.max'          => 'Nama produk maksimal 150 karakter.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'price.required'    => 'Harga produk wajib diisi.',
            'price.numeric'     => 'Harga produk harus berupa angka.',
            'price.min'         => 'Harga produk tidak boleh bernilai negatif.',
            'stock.required'    => 'Jumlah stok wajib diisi.',
            'stock.integer'     => 'Jumlah stok harus berupa bilangan bulat.',
            'stock.min'         => 'Jumlah stok tidak boleh kurang dari 0.',
            'image.url'         => 'Format URL gambar tidak valid.',
        ]);

        // 2. Hubungkan atau buat ProductCategory berdasarkan nama
        $productCategory = ProductCategory::firstOrCreate(['name' => $validated['category']]);
        $validated['category_id'] = $productCategory->id;

        // Berikan gambar default jika input gambar kosong
        if (empty($validated['image'])) {
            $validated['image'] = 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=600&q=80';
        }

        // 3. Simpan produk ke database
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
     * TUGAS SESI 22 - No 1:
     * Menampilkan formulir edit produk berdasarkan ID.
     * Route: GET /products/{product}/edit
     */
    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = ProductCategory::pluck('name');
        if ($categories->isEmpty()) {
            $categories = collect(['Elektronik & Komputer', 'Aksesoris & Periferal', 'Audio & Headset', 'Gaming Gear', 'Smart Gadget']);
        }

        if (view()->exists('product.edit')) {
            return view('product.edit', compact('product', 'categories'));
        }

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * TUGAS SESI 22 - No 3:
     * Memvalidasi input perubahan data produk dan menyimpannya di database.
     * Route: PUT/PATCH /products/{product}
     */
    public function update(Request $request, $id)
    {
        // 1. Temukan produk berdasarkan ID
        $product = Product::findOrFail($id);

        // 2. Validasi input perubahan data
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|url|max:255',
        ], [
            'name.required'     => 'Nama produk wajib diisi.',
            'name.max'          => 'Nama produk maksimal 150 karakter.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'price.required'    => 'Harga produk wajib diisi.',
            'price.numeric'     => 'Harga produk harus berupa angka.',
            'price.min'         => 'Harga produk tidak boleh bernilai negatif.',
            'stock.required'    => 'Jumlah stok wajib diisi.',
            'stock.integer'     => 'Jumlah stok harus berupa bilangan bulat.',
            'stock.min'         => 'Jumlah stok tidak boleh kurang dari 0.',
            'image.url'         => 'Format URL gambar tidak valid.',
        ]);

        // 3. Hubungkan relasi category_id berdasarkan nama kategori
        $productCategory = ProductCategory::firstOrCreate(['name' => $validated['category']]);
        $validated['category_id'] = $productCategory->id;

        // 4. Simpan perubahan ke database
        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', "Data produk '{$product->name}' berhasil diperbarui!");
    }

    /**
     * TUGAS SESI 22 - No 4:
     * Menghapus data produk dari database berdasarkan ID.
     * Route: DELETE /products/{product}
     */
    public function destroy($id)
    {
        // 1. Temukan produk berdasarkan ID
        $product = Product::findOrFail($id);
        $productName = $product->name;

        // 2. Hapus data dari database
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Produk '{$productName}' berhasil dihapus dari sistem.");
    }
}
