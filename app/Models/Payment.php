<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    
    protected $casts = [
        'payment_date' => 'datetime',
    ];
    
    protected $fillable = [
        'transaction_id',
        'payment_date',
        'amount_paid',
        'photo_proof_payment',
        'payment_status',
        'rejection_reason',
        'request_message',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }
} 