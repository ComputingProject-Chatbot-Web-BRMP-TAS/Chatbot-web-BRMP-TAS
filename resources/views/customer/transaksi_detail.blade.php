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

/* Product Cards Styles */
.product-cards-container {
    margin-bottom: 24px;
}

.product-card {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid rgba(34, 197, 94, 0.2);
    position: relative;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    border-color: rgba(34, 197, 94, 0.4);
}

.click-indicator {
    text-align: center;
    margin-top: 8px;
    font-size: 0.85rem;
    color: #666;
    transition: color 0.3s ease;
}

.product-card:hover + .click-indicator {
    color: #16a34a;
}

.product-image-placeholder {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #16a34a, #22c55e);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: bold;
    flex-shrink: 0;
}

.product-left-column {
    display: flex;
    flex-direction: column;
    gap: 12px;
    align-items: center;
    min-width: 120px;
}

.product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    margin-top: 12px;
    min-height: 140px;
}

.product-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.product-price {
    font-size: 1rem;
    font-weight: 600;
    color: #16a34a;
    margin: 0;
}

.product-actions {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100px;
}

.buy-again-btn {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.buy-again-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    color: white;
    text-decoration: none;
}



.quantity-badge {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: white;
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 700;
    text-align: center;
    min-width: 50px;
    display: inline-block;
    position: absolute;
    top: 28px;
    right: 20px;
}

.subtotal-info {
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: flex-end;
}

.subtotal-label {
    font-size: 0.9rem;
    color: #6b7280;
    font-weight: 500;
}

.subtotal-amount {
    font-size: 1rem;
    font-weight: 700;
    color: #16a34a;
}

.transaksi-detail-total {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    padding: 20px;
    border-radius: 16px;
    font-weight: 800;
    color: white;
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

.payment-upload-form {
    background: linear-gradient(135deg, #fff, #f8fafc);
    border-radius: 16px;
    padding: 24px;
    margin-top: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid rgba(229, 231, 235, 0.5);
}

.upload-form-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.upload-form-title::before {
    content: '📤';
    font-size: 1.3rem;
}

.upload-form {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
}

.upload-form:hover {
    border-color: #16a34a;
    background: #f1f8f4;
}

.upload-form .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.upload-form .form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.upload-form .form-control:focus {
    border-color: #16a34a;
    box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
}

.upload-form .form-text {
    font-size: 0.9rem;
    color: #6b7280;
    margin-top: 4px;
}

.upload-btn {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 1rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(22, 163, 74, 0.3);
    margin-top: 16px;
}

.upload-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(22, 163, 74, 0.4);
    background: linear-gradient(135deg, #15803d, #16a34a);
}

.payment-instructions {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border: 1px solid #90caf9;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
    color: #1976d2;
}

.payment-instructions .instructions-title {
    font-weight: 700;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.payment-instructions .instructions-title::before {
    content: '💡';
    font-size: 1.1rem;
}

.payment-instructions ul {
    margin: 8px 0 0 0;
    padding-left: 20px;
}

.payment-instructions li {
    margin-bottom: 4px;
    font-size: 0.95rem;
}

.alert {
    border-radius: 12px;
    border: none;
    padding: 16px 20px;
    margin-bottom: 24px;
    font-weight: 500;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

.alert-success {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #15803d;
    border-left: 4px solid #16a34a;
}

.alert-danger {
    background: linear-gradient(135deg, #fecaca, #fca5a5);
    color: #dc2626;
    border-left: 4px solid #dc2626;
}

.alert .btn-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: inherit;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.alert .btn-close:hover {
    opacity: 1;
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
    
    .product-card {
        flex-direction: column;
        text-align: center;
        gap: 12px;
        align-items: center;
    }
    
    .product-left-column {
        min-width: auto;
        width: 100%;
    }
    
    .product-image-placeholder {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .quantity-badge {
        position: static;
        margin: 0 auto;
    }
    
    .product-actions {
        justify-content: center;
        margin-top: 8px;
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
    
    .back-button {
        padding: 10px 16px;
        font-size: 0.9rem;
    }
}
</style>

<div class="transaksi-detail-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <a href="{{ route('transaksi') }}" class="btn btn-outline-success mb-3" style="border-radius:8px;font-weight:600;">
        Kembali ke Daftar Transaksi
    </a>
    
    <div class="transaksi-detail-title">Detail Transaksi #{{ $transaction->transaction_id }}</div>
    
    <div class="transaksi-detail-info">
        <div class="date-info">
            <span><b>Tanggal:</b> {{ $transaction->order_date->format('d M Y H:i') }}</span>
        </div>
        <span class="transaksi-detail-status">{{ $transaction->display_status }}</span>
    </div>
    
    <div class="delivery-info">
        <div class="info-item">
            <span class="info-label"><b>Metode Pengiriman:</b></span>
            <span class="info-value">{{ $transaction->delivery_method }}</span>
        </div>
        @if($transaction->estimated_delivery_date)
            <div class="info-item">
                <span class="info-label"><b>Estimasi Tiba:</b></span>
                <span class="info-value">{{ $transaction->estimated_delivery_date->translatedFormat('d M Y') }}</span>
            </div>
        @endif
    </div>
    
    @if($transaction->recipient_name || $transaction->shippingAddress)
    <div class="delivery-info">
        <div class="info-item">
            <span class="info-label"><b>Alamat Pengiriman:</b></span>
            <span class="info-value">
                @if($transaction->shippingAddress)
                    {{ $transaction->shippingAddress->recipient_name }}<br>
                    {{ $transaction->shippingAddress->address }}<br>
                    Telp: {{ $transaction->shippingAddress->recipient_phone }}
                    @if($transaction->shippingAddress->note)
                        <br><small class="text-muted">Catatan: {{ $transaction->shippingAddress->note }}</small>
                    @endif
                @else
                    {{ $transaction->recipient_name }}<br>
                    {{ $transaction->shipping_address }}<br>
                    Telp: {{ $transaction->recipient_phone }}
                    @if($transaction->shipping_note)
                        <br><small class="text-muted">Catatan: {{ $transaction->shipping_note }}</small>
                    @endif
                @endif
            </span>
        </div>
    </div>
    @endif
    
    <!-- Product Cards Section -->
    <div class="product-cards-container">
        @foreach($transaction->transactionItems as $item)
        @php
            $productHistory = \App\Models\ProductHistory::where('product_id', $item->product->product_id)
                ->where('recorded_at', '<=', $transaction->order_date)
                ->orderBy('recorded_at', 'desc')
                ->first();
        @endphp
        <div class="product-card" style="cursor: pointer;" onclick="window.location.href='{{ $productHistory ? route('produk.history.detail', $productHistory->history_id) : route('produk.detail', $item->product->product_id) }}'">
            <div class="product-left-column">
                <div class="product-image-placeholder">
                    @if($item->product->image1)
                        <img src="{{ asset('storage/' . $item->product->image1) }}" alt="{{ $item->product->product_name }}" style="width:100%;height:100%;object-fit:cover;border-radius:12px;">
                    @else
                        <i class="fas fa-seedling" style="font-size:24px;"></i>
                    @endif
                </div>
                <div class="product-actions">
                    <a href="{{ route('produk.detail', $item->product->product_id) }}" class="buy-again-btn" onclick="event.stopPropagation();">
                         Beli Lagi
                    </a>
                </div>
            </div>
            <div class="product-info">
                <div class="product-details">
                    <h5 class="product-name">{{ $item->product->product_name ?? '-' }}</h5>
                    <p class="product-price">Rp{{ number_format($item->unit_price,0,',','.') }} / {{ $item->product->unit ?? 'kg' }}</p>
                </div>
                <div class="subtotal-info">
                    <span class="subtotal-label">Subtotal:</span>
                    <span class="subtotal-amount">Rp{{ number_format($item->subtotal,0,',','.') }}</span>
                </div>
            </div>
            <div class="quantity-badge">
                {{ $item->quantity }}{{ $item->product->unit ?? 'kg' }}
            </div>
        </div>
        <!-- <div class="click-indicator">
            <i class="fas fa-mouse-pointer" style="margin-right: 4px;"></i>
            Klik untuk {{ $productHistory ? 'lihat history produk' : 'lihat detail produk' }}
        </div> -->
        @endforeach
    </div>
    
    <div class="transaksi-detail-total">
        Total Belanja: Rp{{ number_format($transaction->total_price,0,',','.') }}
    </div>
    
    <!-- Payment History Section -->
    @if($transaction->payments->count() > 0)
        <div class="transaksi-detail-payment" style="margin-top: 24px;">
            <div class="payment-title">
                <b>Riwayat Pembayaran</b>
            </div>
            @foreach($transaction->payments as $index => $payment)
                <div class="payment-info" style="margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <div style="font-weight: 600; color: #1f2937;">Pembayaran ke-{{ $index + 1 }}</div>
                        <div style="font-size: 0.85rem; padding: 4px 8px; border-radius: 6px; background: {{ $payment->payment_status == 'rejected' ? '#dc2626' : ($payment->payment_status == 'approved' ? '#16a34a' : '#f59e0b') }}; color: white; font-weight: 600;">
                            {{ ucfirst($payment->payment_status) }}
                        </div>
                    </div>
                    <div style="font-size: 0.9rem; color: #6b7280; margin-bottom: 8px;">
                        {{ $payment->payment_date ? $payment->payment_date->format('d M Y H:i') : $payment->created_at->format('d M Y H:i') }}
                    </div>
                    @if($payment->rejection_reason)
                        <div style="font-size: 0.85rem; color: #dc2626; margin-top: 8px; padding: 8px; background: rgba(220, 38, 38, 0.1); border-radius: 6px; border-left: 3px solid #dc2626;">
                            <strong>Alasan Penolakan:</strong><br>
                            {{ $payment->rejection_reason }}
                        </div>
                    @endif
                    @if($payment->photo_proof_payment)
                        <div style="margin-top: 8px;">
                            <strong style="font-size: 0.85rem; color: #6b7280;">Bukti Pembayaran:</strong>
                            <div style="margin-top: 4px;">
                                <img src="{{ asset('storage/bukti_pembayaran/'.$payment->photo_proof_payment) }}" 
                                     alt="Bukti Pembayaran" 
                                     style="max-width: 200px; max-height: 150px; border-radius: 8px; border: 1px solid #e5e7eb;">
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="transaksi-detail-payment">
        <div class="payment-title"><b>Pembayaran</b></div>
        @php
        $payments = $transaction->payments;
        $hasPayments = $payments && count($payments) > 0;
        $allRejected = $hasPayments && $payments->every(function($p) { 
            return in_array($p->payment_status, ['rejected']); 
        });
        $showCountdown = $transaction->order_status === 'menunggu_pembayaran' && !$allRejected;
    @endphp
    
    @if($showCountdown)
    <div id="countdown-section" style="margin-bottom:24px;display:flex;flex-direction:column;align-items:center;">
        <div style="font-size:1.1rem;font-weight:700;color:#222;margin-bottom:8px;">Sisa Waktu Pembayaran</div>
        <div id="countdown-timer" style="font-size:2rem;font-weight:800;color:#d32f2f;background:#fff3e0;border:2px solid #ff9800;padding:10px 28px;border-radius:10px;box-shadow:0 2px 8px rgba(255,152,0,0.08);margin-bottom:8px;"></div>
        <div id="countdown-desc" style="font-size:0.98rem;color:#666;text-align:center;max-width:350px;">Pastikan pembayaran dan upload bukti dilakukan sebelum waktu habis. Jika waktu habis, transaksi akan otomatis dibatalkan oleh sistem.</div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var orderDate = @json($transaction->order_date->format('Y-m-d H:i:s'));
        var deadline = new Date(new Date(orderDate.replace(/-/g,'/')).getTime() + 24*60*60*1000);
        function updateCountdown() {
          var now = new Date();
          var diff = deadline - now;
          var timerDiv = document.getElementById('countdown-timer');
          var descDiv = document.getElementById('countdown-desc');
          if (diff <= 0) {
            timerDiv.innerHTML = 'WAKTU HABIS';
            timerDiv.style.color = '#b71c1c';
            timerDiv.style.background = '#ffebee';
            timerDiv.style.border = '2px solid #b71c1c';
            descDiv.innerHTML = '<b style="color:#b71c1c;">Waktu pembayaran telah habis. Transaksi akan dibatalkan otomatis oleh sistem.</b>';
            clearInterval(timerInterval);
            return;
          }
          var hours = Math.floor(diff / (1000 * 60 * 60));
          var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((diff % (1000 * 60)) / 1000);
          timerDiv.innerHTML = hours.toString().padStart(2,'0') + ':' + minutes.toString().padStart(2,'0') + ':' + seconds.toString().padStart(2,'0');
          timerDiv.style.color = '#d32f2f';
          timerDiv.style.background = '#fff3e0';
          timerDiv.style.border = '2px solid #ff9800';
          descDiv.innerHTML = 'Pastikan pembayaran dan upload bukti dilakukan sebelum waktu habis. Jika waktu habis, transaksi akan otomatis dibatalkan oleh sistem.';
        }
        updateCountdown();
        var timerInterval = setInterval(updateCountdown, 1000);
      });
    </script>
    @endif

        @php
            $payments = $transaction->payments;
            $hasPayments = $payments && count($payments) > 0;
            $allRejected = $hasPayments && $payments->every(function($p) { return $p->payment_status === 'rejected'; });
            $showUploadForm = (!$hasPayments && $transaction->order_status === 'menunggu_pembayaran') || $allRejected;
            $latestPayment = $hasPayments ? $payments->last() : null;
        @endphp
        
        @if($hasPayments && !$allRejected)
            @php $payment = $payments->last(); @endphp
            <div class="payment-info">
                <div class="payment-item">
                    <div class="label">📅 Tanggal Pembayaran</div>
                    <div class="value">{{ $payment->payment_date->format('d M Y H:i') }}</div>
                </div>
                <div class="payment-item">
                    <div class="label">💰 Jumlah Dibayar</div>
                    <div class="value">IDR {{ number_format($payment->amount_paid,0,',','.') }}</div>
                </div>
                <div class="payment-item">
                    <div class="label">✅ Status Pembayaran</div>
                    <div class="value">
                        <span class="payment-status">{{ $payment->payment_status }}</span>
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
        @elseif(!$hasPayments)
            <div class="no-payment">
                ⚠️ Belum ada pembayaran untuk transaksi ini.
            </div>
        @endif
        @if($showUploadForm)
            <div class="payment-upload-form">
                @if($allRejected)
                    <div class="alert alert-warning" style="border-radius:10px; margin-bottom:16px;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                            <i class="fas fa-exclamation-triangle" style="color:#f59e0b;font-size:1.2rem;"></i>
                            <strong style="color:#92400e;">Upload Ulang Bukti Pembayaran Diperlukan</strong>
                        </div>
                        <div style="color:#92400e;margin-bottom:12px;">
                            Bukti pembayaran sebelumnya <span style="color:#dc2626;font-weight:600;">ditolak</span>. Silakan upload ulang bukti pembayaran yang benar agar transaksi dapat diproses.
                        </div>
                        @if($latestPayment && $latestPayment->rejection_reason)
                            <div style="background:rgba(220,38,38,0.1);padding:12px;border-radius:8px;border-left:3px solid #dc2626;margin-bottom:12px;">
                                <strong style="color:#dc2626;">Alasan penolakan:</strong><br>
                                <span style="color:#dc2626;">{{ $latestPayment->rejection_reason }}</span>
                            </div>
                        @endif
                        <div style="background:rgba(22,163,74,0.1);padding:12px;border-radius:8px;border-left:3px solid #16a34a;margin-bottom:12px;">
                            <strong style="color:#16a34a;">Yang Perlu Dilakukan:</strong><br>
                            <span style="color:#16a34a;">Upload ulang bukti pembayaran yang benar sesuai alasan penolakan di atas</span>
                        </div>
                    </div>
                @endif
                <div class="payment-instructions">
                    <div class="instructions-title">Petunjuk Pembayaran:</div>
                    <ul>
                        <li>Transfer sejumlah <strong>IDR {{ number_format($transaction->total_price,0,',','.') }}</strong></li>
                        <li>Simpan bukti transfer (screenshot atau foto)</li>
                        <li>Upload bukti transfer di bawah ini</li>
                        <li>Tim kami akan memverifikasi pembayaran Anda</li>
                        @if($allRejected)
                            <li style="color:#dc2626;font-weight:600;">⚠️ Pastikan bukti pembayaran terlihat jelas dan lengkap</li>
                            <li style="color:#dc2626;font-weight:600;">⚠️ Perhatikan alasan penolakan sebelumnya</li>
                        @endif
                    </ul>
                </div>
                <div class="upload-form-title">
                    @if($allRejected)
                        🔄 Upload Ulang Bukti Pembayaran
                    @else
                        📤 Upload Bukti Pembayaran
                    @endif
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="upload-form">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('payment.upload') }}">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->transaction_id }}">
                        <div class="mb-3">
                            <label for="buktiPembayaran" class="form-label">Pilih file gambar bukti transfer</label>
                            <input class="form-control" 
                                   type="file" 
                                   id="buktiPembayaran" 
                                   name="bukti_pembayaran" 
                                   accept="image/*" 
                                   required>
                            <div class="form-text">Format yang didukung: JPG, JPEG, PNG (Max. 10MB)</div>
                        </div>
                        <button type="submit" class="upload-btn">
                            @if($allRejected)
                                🔄 Upload Ulang Bukti Pembayaran
                            @else
                                📤 Upload Bukti Pembayaran
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection