<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $primaryKey = 'transaction_item_id';
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaksi_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'produk_id');
    }
} 