<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * Kolom mass assignment:
     * id, name, category_id, category, price, description, image, stock, created_at, updated_at
     */
    protected $fillable = [
        'name',
        'category_id',
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
        'category_id' => 'integer',
    ];

    // ============================================================
    // Relasi Eloquent (Tugas 1: Atur Relasi Model Product & ProductCategory)
    // ============================================================

    /**
     * Relasi Many-to-One: Setiap Produk dimiliki oleh satu ProductCategory.
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Relasi alias category().
     */
    public function categoryRelation()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Relasi ke Order (satu produk bisa memiliki banyak transaksi order).
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }

    // ============================================================
    // Scope (Filter Query)
    // ============================================================

    /**
     * Scope: filter produk berdasarkan nama kategori.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where(function ($q) use ($category) {
            $q->where('category', $category)
              ->orWhereHas('productCategory', function ($subQuery) use ($category) {
                  $subQuery->where('name', $category);
              });
        });
    }

    /**
     * Scope: produk yang masih memiliki stok.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // ============================================================
    // Accessor
    // ============================================================

    /**
     * Mendapatkan nama kategori dari relasi atau kolom fallback.
     */
    public function getCategoryNameAttribute(): string
    {
        return $this->productCategory?->name ?? $this->category ?? 'Umum';
    }

    /**
     * Format harga Rupiah (contoh: Rp 799.000).
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
