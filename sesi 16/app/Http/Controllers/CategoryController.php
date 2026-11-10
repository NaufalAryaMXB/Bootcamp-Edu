<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Tampilkan list kategori produk dalam bentuk tabel.
     * Tugas 2: Tabel berisi data: id, nama kategori, dan jumlah produk.
     * Serta tombol: tambah, edit, dan hapus.
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
     * Form tambah kategori baru.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah terdaftar.',
            'name.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', "Kategori '{$validated['name']}' berhasil ditambahkan!");
    }

    /**
     * Form edit kategori.
     */
    public function edit($id)
    {
        $category = Category::withCount('products')->findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Perbarui data kategori.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah digunakan.',
            'name.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil diperbarui!");
    }

    /**
     * Hapus kategori.
     */
    public function destroy($id)
    {
        $category = Category::withCount('products')->findOrFail($id);
        $name = $category->name;

        // Lepaskan referensi category_id pada produk terkait agar tidak melanggar foreign key
        $category->products()->update(['category_id' => null]);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', "Kategori '{$name}' berhasil dihapus!");
    }
}
