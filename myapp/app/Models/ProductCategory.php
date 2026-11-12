<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ============================================================
 * Model: ProductCategory (Sesi 15 - Tugas 1)
 * ============================================================
 *
 * Model ini merepresentasikan tabel `categories` di database.
 * Setiap ProductCategory memiliki relasi One-to-Many ke Product.
 *
 * Relasi:
 * - ProductCategory hasMany Product (melalui category_id)
 * - Product belongsTo ProductCategory
 */
class ProductCategory extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database MySQL.
     */
    protected $table = 'categories';

    /**
     * Kolom yang dapat diisi secara massal (mass assignment).
     */
    protected $fillable = [
        'name',
    ];

    // ============================================================
    // Relasi Eloquent (Tugas 1: Atur Relasi Model)
    // ============================================================

    /**
     * Relasi One-to-Many: Satu kategori produk memiliki banyak produk.
     *
     * Contoh penggunaan:
     *   $category = ProductCategory::find(1);
     *   $products = $category->products; // Semua produk dalam kategori ini
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}

