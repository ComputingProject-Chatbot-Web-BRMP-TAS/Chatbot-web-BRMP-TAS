<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'transaksi_id';
    protected $fillable = [
        'user_id',
        'order_date',
        'total_harga',
        'status',
        'delivery_method',
        'estimated_delivery_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
} 