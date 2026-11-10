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

Route::get('/', function () {
    return view('welcome');
});

// Sesi 18: Dashboard Admin Utama dengan Ringkasan Statistik
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// Sesi 16: Menu & CRUD Kategori Produk dan Produk
// ============================================================
// 1. Resource route untuk Kategori Produk (List, Tambah, Edit, Hapus)
Route::resource('categories', CategoryController::class);

// 2. Resource route untuk Produk (List, Tambah, Edit, Hapus)
Route::resource('products', ProductController::class);

// Route pendukung e-commerce
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/home', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
