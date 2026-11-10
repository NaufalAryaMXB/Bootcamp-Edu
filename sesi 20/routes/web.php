<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
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
    Route::resource('categories', CategoryController::class);

    // 3. Kelola Produk (Aksi Admin: Tambah, Simpan, Edit, Update, Hapus)
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__.'/auth.php';
