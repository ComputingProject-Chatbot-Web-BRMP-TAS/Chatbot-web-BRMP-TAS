@extends('layouts.app')

@section('content')
<style>
.transaksi-detail-container {
    max-width: 700px;
    margin: 100px auto 0 auto; /* Tambah margin-top agar tidak mepet Appbar */
    background: #f8fafc;
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    padding: 32px 24px;
}

.transaksi-detail-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, #16a34a, #22c55e, #16a34a);
    background-size: 200% 100%;
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

.back-button {
    background: linear-gradient(135deg, rgba(22, 163, 74, 0.1), rgba(34, 197, 94, 0.1));
    color: #16a34a;
    border: 2px solid #16a34a;
    border-radius: 12px;
    padding: 12px 20px;
    font-weight: 700;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(22, 163, 74, 0.2);
}

.back-button:hover {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(22, 163, 74, 0.3);
}

.transaksi-detail-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 24px;
    color: #1a1a1a;
    text-align: center;
    position: relative;
    background: linear-gradient(135deg, #16a34a, #22c55e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.transaksi-detail-info {
    margin-bottom: 24px;
    font-size: 1.1rem;
    background: rgba(255,255,255,0.7);
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.transaksi-detail-info .date-info {
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 8px;
}

.transaksi-detail-status {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 700;
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #15803d;
    border: 2px solid #16a34a;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(22, 163, 74, 0.2);
}

.delivery-info {
    background: rgba(255,255,255,0.7);
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    backdrop-filter: blur(10px);
    margin-bottom: 24px;
}

.delivery-info .info-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-weight: 600;
    color: #374151;
}

.delivery-info .info-item:last-child {
    margin-bottom: 0;
}

.delivery-info .info-label {
    min-width: 120px;
    color: #6b7280;
}

.delivery-info .info-value {
    color: #16a34a;
    font-weight: 700;
}

.transaksi-detail-table {
    width: 100%;
    margin-bottom: 24px;
    border-collapse: collapse;
    background: rgba(255,255,255,0.9);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}

.transaksi-detail-table th, .transaksi-detail-table td {
    padding: 16px 20px;
    text-align: left;
    border-bottom: 1px solid rgba(229, 231, 235, 0.5);
}

.transaksi-detail-table th {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
}

.transaksi-detail-table td {
    font-weight: 500;
    color: #4b5563;
    transition: background 0.2s ease;
}

.transaksi-detail-table tbody tr:hover {
    background: rgba(22, 163, 74, 0.05);
}

.transaksi-detail-table tbody tr:last-child td {
    border-bottom: none;
}

.product-name {
    font-weight: 700;
    color: #1f2937;
}

.quantity-badge {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: #fff;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 700;
    text-align: center;
    min-width: 40px;
    display: inline-block;
}

.price-cell {
    font-weight: 700;
    color: #16a34a;
    font-family: 'Courier New', monospace;
}

.transaksi-detail-total {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    padding: 20px;
    border-radius: 16px;
    font-weight: 800;
    color: #15803d;
    font-size: 1.3rem;
    text-align: right;
    margin-top: 16px;
    box-shadow: 0 4px 16px rgba(22, 163, 74, 0.2);
    border: 2px solid #16a34a;
}

.transaksi-detail-payment {
    background: linear-gradient(135deg, #fff, #f8fafc);
    border-radius: 16px;
    padding: 24px;
    margin-top: 24px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid rgba(229, 231, 235, 0.5);
}

.payment-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.payment-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 16px;
}

.payment-item {
    background: rgba(22, 163, 74, 0.05);
    padding: 12px 16px;
    border-radius: 10px;
    border-left: 4px solid #16a34a;
}

.payment-item .label {
    font-size: 0.9rem;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 4px;
}

.payment-item .value {
    font-weight: 700;
    color: #1f2937;
}

.payment-status {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #15803d;
    padding: 8px 12px;
    border-radius: 8px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
}

.payment-proof {
    margin-top: 16px;
    text-align: center;
}

.payment-proof .proof-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 12px;
    display: block;
}

.transaksi-detail-payment img {
    max-width: 280px;
    width: 100%;
    border-radius: 12px;
    margin-top: 8px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    border: 2px solid #e5e7eb;
    transition: transform 0.3s ease;
}

.transaksi-detail-payment img:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.no-payment {
    text-align: center;
    color: #6b7280;
    font-style: italic;
    padding: 20px;
    background: rgba(107, 114, 128, 0.1);
    border-radius: 10px;
    border: 2px dashed #d1d5db;
}

@media (max-width: 768px) {
    .transaksi-detail-container {
        padding: 24px 16px;
        margin: 60px 16px 0 16px;
    }
    
    .transaksi-detail-title {
        font-size: 1.6rem;
    }
    
    .transaksi-detail-info {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
    }
    
    .transaksi-detail-table {
        font-size: 0.9rem;
    }
    
    .transaksi-detail-table th, .transaksi-detail-table td {
        padding: 12px 8px;
    }
    
    .payment-info {
        grid-template-columns: 1fr;
    }
    
    .transaksi-detail-payment img {
        max-width: 100%;
    }
}

@media (max-width: 480px) {
    .transaksi-detail-container {
        padding: 20px 12px;
        margin: 40px 8px 0 8px;
    }
    
    .transaksi-detail-title {
        font-size: 1.4rem;
    }
    
    .transaksi-detail-table {
        font-size: 0.8rem;
    }
    
    .transaksi-detail-table th, .transaksi-detail-table td {
        padding: 10px 6px;
    }
    
    .back-button {
        padding: 10px 16px;
        font-size: 0.9rem;
    }
}
</style>

<div class="transaksi-detail-container">
    <a href="{{ route('transaksi') }}" class="btn btn-outline-success mb-3" style="border-radius:8px;font-weight:600;">
        Kembali ke Daftar Transaksi
    </a>
    
    <div class="transaksi-detail-title">Detail Transaksi #{{ $transaction->transaksi_id }}</div>
    
    <div class="transaksi-detail-info">
        <div class="date-info">
            <span><b>Tanggal:</b> {{ \Carbon\Carbon::parse($transaction->order_date)->format('d M Y H:i') }}</span>
        </div>
        <span class="transaksi-detail-status">{{ $transaction->status }}</span>
    </div>
    
    <div class="delivery-info">
        <div class="info-item">
            <span class="info-label"><b>Metode Pengiriman:</b></span>
            <span class="info-value">{{ $transaction->delivery_method }}</span>
        </div>
        @if($transaction->estimated_delivery_date)
            <div class="info-item">
                <span class="info-label"><b>Estimasi Tiba:</b></span>
                <span class="info-value">{{ \Carbon\Carbon::parse($transaction->estimated_delivery_date)->translatedFormat('d M Y') }}</span>
            </div>
        @endif
    </div>
    
    <table class="transaksi-detail-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->transactionItems as $item)
            <tr>
                <td class="product-name">{{ $item->product->nama ?? '-' }}</td>
                <td><span class="quantity-badge">{{ $item->quantity }}</span></td>
                <td class="price-cell">IDR {{ number_format($item->unit_price,0,',','.') }}</td>
                <td class="price-cell">IDR {{ number_format($item->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="transaksi-detail-total">
        Total Belanja: IDR {{ number_format($transaction->total_harga,0,',','.') }}
    </div>
    
    <div class="transaksi-detail-payment">
        <div class="payment-title"><b>Pembayaran</b></div>
        @if($transaction->payments && count($transaction->payments) > 0)
            @php $payment = $transaction->payments->first(); @endphp
            <div class="payment-info">
                <div class="payment-item">
                    <div class="label">📅 Tanggal Pembayaran</div>
                    <div class="value">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y H:i') }}</div>
                </div>
                <div class="payment-item">
                    <div class="label">💰 Jumlah Dibayar</div>
                    <div class="value">IDR {{ number_format($payment->amount_paid,0,',','.') }}</div>
                </div>
                <div class="payment-item">
                    <div class="label">✅ Status Pembayaran</div>
                    <div class="value">
                        <span class="payment-status">{{ $payment->status }}</span>
                    </div>
                </div>
            </div>
            @if($payment->photo_proof_payment)
                <div class="payment-proof">
                    <span class="proof-label">📸 Bukti Transfer:</span>
                    <br>
                    <img src="{{ asset('storage/bukti_pembayaran/'.$payment->photo_proof_payment) }}" alt="Bukti Pembayaran">
                </div>
            @endif
        @else
            <div class="no-payment">
                ⚠️ Belum ada pembayaran untuk transaksi ini.
            </div>
        @endif
    </div>
</div>
@endsection