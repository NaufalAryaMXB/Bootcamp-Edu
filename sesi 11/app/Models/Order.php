<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Nama tabel dari sesi sebelumnya.
     */
    protected $table = 'orders';

    /**
     * Primary key pada tabel orders di ecommerce_db adalah order_id.
     */
    protected $primaryKey = 'order_id';

    /**
     * Kolom timestamp pada tabel orders di sesi sebelumnya:
     * hanya ada order_date (tanpa updated_at).
     */
    const CREATED_AT = 'order_date';
    const UPDATED_AT = null;

    /**
     * Kolom mass assignment sesuai struktur tabel orders di ecommerce_db:
     * order_id, user_id, product_id, quantity, total, order_date
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total',
        'order_date',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'quantity'   => 'integer',
        'total'      => 'decimal:2',
        'order_date' => 'datetime',
    ];

    // ============================================================
    // Relasi
    // ============================================================

    /**
     * Setiap order mengarah ke satu produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Order dimiliki oleh user (jika ada relasi dengan tabel users).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ============================================================
    // Accessor
    // ============================================================

    /**
     * Format total harga ke mata uang Rupiah.
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
