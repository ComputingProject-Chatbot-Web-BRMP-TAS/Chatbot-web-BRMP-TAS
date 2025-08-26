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
        'billing_code_file',
        'no_rek_ongkir',
        'photo_proof_payment_billing',
        'photo_proof_payment_ongkir',
        'payment_status',
        'rejection_reason',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }
} 