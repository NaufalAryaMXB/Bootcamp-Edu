<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes - E-Commerce Sesi 13 (Migrations, Seeders, & Database)
|--------------------------------------------------------------------------
|
| 1. Controller Mengelola Halaman (PageController)
| 2. Controller Mengelola Produk (ProductController - Resource CRUD)
| 3. Fitur E-commerce Lanjutan (Cart & Checkout)
|
*/

// ============================================================
// 1. KONTROLER MENGELOLA HALAMAN (PageController)
// ============================================================
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('pages.about');
    Route::get('/contact', 'contact')->name('pages.contact');
    Route::post('/contact', 'contactSubmit')->name('pages.contact.submit');
    Route::get('/faq', 'faq')->name('pages.faq');
    Route::get('/terms', 'terms')->name('pages.terms');
});

// ============================================================
// 2. KONTROLER MENGELOLA PRODUK (ProductController - Full CRUD)
// ============================================================
// Otomatis menyediakan 7 route standar Laravel:
// - GET    /products          (index)   - Daftar produk
// - GET    /products/create   (create)  - Form tambah produk
// - POST   /products          (store)   - Simpan produk baru
// - GET    /products/{id}     (show)    - Detail produk
// - GET    /products/{id}/edit (edit)   - Form edit produk
// - PUT    /products/{id}     (update)  - Simpan perubahan produk
// - DELETE /products/{id}     (destroy) - Hapus produk
Route::resource('products', ProductController::class);

// ============================================================
// 3. FITUR E-COMMERCE: KERANJANG BELANJA (CartController)
// ============================================================
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
});

// ============================================================
// 4. FITUR E-COMMERCE: CHECKOUT & ORDER (OrderController)
// ============================================================
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [OrderController::class, 'checkout'])->name('index');
    Route::post('/process', [OrderController::class, 'process'])->name('process');
    Route::get('/success/{order}', [OrderController::class, 'success'])->name('success');
});
