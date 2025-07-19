<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'transaksi_id';
    
    protected $casts = [
        'order_date' => 'datetime',
        'estimated_delivery_date' => 'date',
    ];
    
    protected $fillable = [
        'user_id',
        'shipping_address_id',
        'recipient_name',
        'shipping_address',
        'recipient_phone',
        'shipping_note',
        'order_date',
        'total_harga',
        'status_order',
        'delivery_method',
        'estimated_delivery_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'transaction_id', 'transaksi_id');
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'transaksi_id');
    }

    /**
     * Get the display status based on payment and order status
     */
    public function getDisplayStatusAttribute()
    {
        $payment = $this->payments->last();
        
        // If no payment exists, show "Menunggu Pembayaran"
        if (!$payment) {
            return 'Menunggu Pembayaran';
        }

        // If payment is rejected, show "Pembayaran Ditolak"
        if ($payment->status_payment === 'rejected') {
            return 'Pembayaran Ditolak';
        }

        // If payment is pending, show order status
        if ($payment->status_payment === 'pending') {
            switch ($this->status_order) {
                case 'menunggu_konfirmasi_pembayaran':
                    return 'Menunggu Konfirmasi Pembayaran';
                case 'menunggu_pembayaran':
                    return 'Menunggu Pembayaran';
                case 'diproses':
                    return 'Pesanan Diproses';
                case 'dikemas':
                    return 'Pesanan Dikemas';
                case 'dikirim':
                    return 'Pesanan Dikirim';
                case 'selesai':
                    return 'Pesanan Selesai';
                case 'dibatalkan':
                    return 'Pesanan Dibatalkan';
                default:
                    return 'Menunggu Pembayaran';
            }
        }

        // If payment is approved, show order status
        if ($payment->status_payment === 'approved') {
            switch ($this->status_order) {
                case 'diproses':
                    return 'Pesanan Diproses';
                case 'dikemas':
                    return 'Pesanan Dikemas';
                case 'dikirim':
                    return 'Pesanan Dikirim';
                case 'selesai':
                    return 'Pesanan Selesai';
                case 'dibatalkan':
                    return 'Pesanan Dibatalkan';
                default:
                    return 'Menunggu Pembayaran';
            }
        }

        return 'Menunggu Pembayaran';
    }

    /**
     * Get the status class for CSS styling
     */
    public function getStatusClassAttribute()
    {
        $payment = $this->payments->last();
        
        if (!$payment) {
            return 'menunggu-pembayaran';
        }

        if ($payment->status_payment === 'rejected') {
            return 'pembayaran-ditolak';
        }

        if ($payment->status_payment === 'pending') {
            switch ($this->status_order) {
                case 'menunggu_konfirmasi_pembayaran':
                    return 'menunggu-konfirmasi-pembayaran';
                case 'menunggu_pembayaran':
                    return 'menunggu-pembayaran';
                case 'diproses':
                    return 'pesanan-diproses';
                case 'dikemas':
                    return 'pesanan-dikemas';
                case 'dikirim':
                    return 'pesanan-dikirim';
                case 'selesai':
                    return 'pesanan-selesai';
                case 'dibatalkan':
                    return 'pesanan-dibatalkan';
                default:
                    return 'menunggu-pembayaran';
            }
        }

        if ($payment->status_payment === 'approved') {
            switch ($this->status_order) {
                case 'diproses':
                    return 'pesanan-diproses';
                case 'dikemas':
                    return 'pesanan-dikemas';
                case 'dikirim':
                    return 'pesanan-dikirim';
                case 'selesai':
                    return 'pesanan-selesai';
                case 'dibatalkan':
                    return 'pesanan-dibatalkan';
                default:
                    return 'menunggu-pembayaran';
            }
        }

        return 'menunggu-pembayaran';
    }
} 