<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database MySQL.
     * Menggunakan tabel categories (atau product_categories).
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
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
