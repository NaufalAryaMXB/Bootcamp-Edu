<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    /**
     * Kolom mass assignment:
     * id, user_id, product_id, quantity, total
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'quantity' => 'integer',
        'total'    => 'decimal:2',
    ];

    // ============================================================
    // Relasi
    // ============================================================

    /**
     * Setiap pesanan dimiliki oleh satu pengguna (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Setiap pesanan mengarah ke satu produk (Product).
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
