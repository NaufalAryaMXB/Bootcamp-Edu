<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Nama tabel dari sesi sebelumnya.
     */
    protected $table = 'products';

    /**
     * Kolom mass assignment sesuai struktur tabel products di ecommerce_db:
     * id, name, category, price, description, image, stock, created_at, updated_at
     */
    protected $fillable = [
        'name',
        'category',
        'price',
        'description',
        'image',
        'stock',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // ============================================================
    // Scope (Filter Query)
    // ============================================================

    /**
     * Scope: filter produk berdasarkan kategori.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: produk yang masih memiliki stok.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // ============================================================
    // Relasi
    // ============================================================

    /**
     * Produk memiliki relasi ke banyak transaksi orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }

    // ============================================================
    // Accessor
    // ============================================================

    /**
     * Format harga Rupiah (contoh: Rp 799.000).
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
