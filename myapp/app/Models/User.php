<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Helper cek apakah pengguna memiliki role admin.
     */
    public function isAdmin(): bool
    {
        return strtolower($this->role ?? '') === 'admin';
    }

    /**
     * Relasi ke CartItem: Barang-barang di keranjang user.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'user_id');
    }

    /**
     * Relasi ke Pesanan: Satu user memiliki banyak pesanan.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
