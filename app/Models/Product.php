<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'produk_id';
    protected $fillable = [
        'nama', 'jenis_kategori', 'deskripsi', 'jumlah_biji', 'harga', 'gambar', 'stok'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id', 'produk_id');
    }
}
