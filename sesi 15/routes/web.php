<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// Sesi 15: Routes untuk Produk (CRUD + Pagination)
// ============================================================
// Resource route secara otomatis membuat 7 route:
// GET    /products          -> index   (Daftar produk + pagination)
// GET    /products/create   -> create  (Form tambah produk)
// POST   /products          -> store   (Simpan produk baru)
// GET    /products/{id}     -> show    (Detail produk)
// GET    /products/{id}/edit -> edit   (Form edit produk)
// PUT    /products/{id}     -> update  (Update data produk)
// DELETE /products/{id}     -> destroy (Hapus produk)
Route::resource('products', ProductController::class);

// Route keranjang belanja
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Route halaman statis
Route::get('/home', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
