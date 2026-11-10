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
    // Scope (Filter Query)
    // ============================================================

    /**
     * Scope: filter produk berdasarkan kategori.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where(function ($q) use ($category) {
            $q->where('category', $category)
              ->orWhereHas('categoryRelation', function ($subQuery) use ($category) {
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
    // Relasi
    // ============================================================

    /**
     * Produk berelasi ke Category.
     */
    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

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
