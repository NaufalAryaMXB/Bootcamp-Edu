<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ============================================================
 * Model: Product (Sesi 15 - Tugas 1)
 * ============================================================
 *
 * Model ini merepresentasikan tabel `products` di database.
 *
 * Relasi:
 * - Product belongsTo ProductCategory (melalui category_id)
 * - Product hasMany Order (melalui product_id)
 *
 * Fitur:
 * - Scope: byCategory(), inStock()
 * - Accessor: formatted_price
 * - Pagination: digunakan di ProductController@index
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * Kolom mass assignment:
     * id, name, category_id, category, price, description, image, stock, clicks, klik
     */
    protected $fillable = [
        'name',
        'category_id',
        'category',
        'price',
        'description',
        'image',
        'stock',
        'clicks',
        'klik',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'category_id' => 'integer',
        'clicks' => 'integer',
        'klik' => 'integer',
    ];

    // ============================================================
    // Scope (Filter Query)
    // ============================================================

    /**
     * Scope: filter produk berdasarkan kategori.
     *
     * Contoh penggunaan:
     *   Product::byCategory('Gaming Gear')->get();
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
     *
     * Contoh penggunaan:
     *   Product::inStock()->get();
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // ============================================================
    // Relasi (Tugas 1: Atur Relasi antara Product & ProductCategory)
    // ============================================================

    /**
     * Relasi Many-to-One: Produk milik satu ProductCategory.
     *
     * Contoh penggunaan:
     *   $product = Product::find(1);
     *   $categoryName = $product->productCategory->name;
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Alias relasi ke Category model (backward compatibility).
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
