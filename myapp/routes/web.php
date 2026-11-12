<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// ============================================================
// Halaman Publik (Dapat diakses siapa saja)
// ============================================================
// Sesi 20: Halaman Utama / Beranda menampilkan Kategori dan Produk via HomeController
Route::get('/', [HomeController::class, 'index'])->name('home');

// Katalog & Detail Produk Publik (Dapat dilihat pengunjung)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
// Sesi 24: Fitur Klik Produk (mencatat klik & menampilkan detail)
Route::get('/products/{product}/click', [ProductController::class, 'click'])->name('products.click');
Route::post('/products/{product}/click', [ProductController::class, 'click'])->name('product.click');

// Route pendukung belanja (Keranjang)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// ============================================================
// Route Pengguna Terautentikasi (User Biasa & Admin)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// Tugas 3 Sesi 19: Terapkan Middleware Admin di Route
// ============================================================
// Seluruh rute di bawah ini HANYA dapat diakses oleh user dengan role 'admin'.
// User biasa yang mencoba mengakses akan mendapatkan error 403 (Akses Ditolak).
Route::middleware(['auth', 'admin'])->group(function () {
    // 1. Dashboard Utama Admin (Statistik Sesi 18)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Kelola Kategori Produk (CRUD Lengkap)
    // Sesi 21 & 22: Route Tambah, Simpan, Edit, Update, Hapus Kategori via ProductCategoryController
    Route::get('/categories/create', [ProductCategoryController::class, 'create'])->name('product-category.create');
    Route::get('/product-categories/create', [ProductCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [ProductCategoryController::class, 'store'])->name('product-category.store');
    Route::post('/categories/store', [ProductCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [ProductCategoryController::class, 'edit'])->name('categories.edit');
    Route::get('/product-categories/{category}/edit', [ProductCategoryController::class, 'edit'])->name('product-category.edit');
    Route::put('/categories/{category}', [ProductCategoryController::class, 'update'])->name('categories.update');
    Route::put('/product-categories/{category}', [ProductCategoryController::class, 'update'])->name('product-category.update');
    Route::delete('/categories/{category}', [ProductCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::delete('/product-categories/{category}', [ProductCategoryController::class, 'destroy'])->name('product-category.destroy');
    Route::resource('categories', ProductCategoryController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

    // 3. Kelola Produk (Aksi Admin: Tambah, Simpan, Edit, Update, Hapus)
    // Sesi 21 & 22: Route Tambah, Simpan, Edit, Update, Hapus Produk via ProductController
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});

require __DIR__.'/auth.php';
