<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes - E-Commerce
|--------------------------------------------------------------------------
|
| Daftar route untuk website E-Commerce.
|
*/

// ============================================================
// Halaman Utama
// ============================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ============================================================
// Produk
// ============================================================
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');       // /products
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');     // /products/{id}
});

// ============================================================
// Keranjang Belanja
// ============================================================
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');          // /cart
    Route::post('/add', [CartController::class, 'add'])->name('add');          // POST /cart/add
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove'); // DELETE /cart/remove/{id}
});

// ============================================================
// Checkout & Order
// ============================================================
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [OrderController::class, 'checkout'])->name('index');      // /checkout
    Route::post('/process', [OrderController::class, 'process'])->name('process'); // POST /checkout/process
    Route::get('/success/{order}', [OrderController::class, 'success'])->name('success'); // /checkout/success/{order}
});
