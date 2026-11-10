<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

/**
 * ============================================================
 * Sesi 21 - ProductCategoryController
 * ============================================================
 * 
 * Controller untuk mengelola Kategori Produk:
 * 1. Menampilkan halaman tambah kategori (create)
 * 2. Memvalidasi input dan menyimpan ke database (store)
 * 3. Menampilkan daftar kategori, edit, update, dan delete (CRUD lengkap)
 */
class ProductCategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori produk.
     * Route: GET /categories
     */
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        return view('categories.index', compact('categories'));
    }

    /**
     * TUGAS 21 - No 1:
     * Menampilkan halaman formulir tambah kategori produk.
     * Route: GET /categories/create
     */
    public function create()
    {
        if (view()->exists('product-category.create')) {
            return view('product-category.create');
        }

        return view('categories.create');
    }

    /**
     * TUGAS 21 - No 4:
     * Memvalidasi input formulir dan menyimpannya ke database.
     * Route: POST /categories (name: product-category.store)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Kategori
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string'   => 'Nama kategori harus berupa teks yang valid.',
            'name.unique'   => 'Nama kategori sudah terdaftar di sistem.',
            'name.max'      => 'Nama kategori tidak boleh lebih dari 100 karakter.',
        ]);

        // 2. Simpan Data ke Database
        $category = Category::create($validated);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil ditambahkan ke database!");
    }

    /**
     * Menampilkan detail kategori produk tertentu.
     */
    public function show($id)
    {
        $category = Category::withCount('products')->with('products')->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Menampilkan formulir edit kategori.
     */
    public function edit($id)
    {
        $category = Category::withCount('products')->findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Memvalidasi dan memperbarui data kategori.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string'   => 'Nama kategori harus berupa teks yang valid.',
            'name.unique'   => 'Nama kategori sudah digunakan oleh kategori lain.',
            'name.max'      => 'Nama kategori tidak boleh lebih dari 100 karakter.',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil diperbarui!");
    }

    /**
     * Menghapus data kategori dari database.
     */
    public function destroy($id)
    {
        $category = Category::withCount('products')->findOrFail($id);
        $name = $category->name;

        // Lepaskan relasi category_id pada produk terkait
        $category->products()->update(['category_id' => null]);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', "Kategori '{$name}' berhasil dihapus dari sistem!");
    }
}
