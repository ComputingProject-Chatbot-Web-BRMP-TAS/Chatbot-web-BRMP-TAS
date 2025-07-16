@extends('layouts.app')

@section('content')
<style>
.payment-container {
    max-width: 1200px;
    margin: 60px auto 0;
    padding: 20px;
}

.payment-header {
    text-align: center;
    margin-bottom: 40px;
    padding: 30px;
    background: linear-gradient(135deg, #176a3a 0%, #218838 100%);
    border-radius: 16px;
    color: white;
    position: relative;
    overflow: hidden;
}

.payment-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.05); opacity: 0.8; }
}

.payment-deadline {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 10px;
    opacity: 0.95;
    position: relative;
    z-index: 1;
}

.payment-amount {
    font-size: 3rem;
    font-weight: 700;
    letter-spacing: 2px;
    position: relative;
    z-index: 1;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.upload-section {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #f0f0f0;
    margin-bottom: 30px;
}

.upload-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}

.upload-title::before {
    content: '📁';
    font-size: 1.5rem;
}

.upload-form {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 25px;
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
}

.upload-form:hover {
    border-color: #28a745;
    background: #f1f8f4;
}

.file-input {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.file-input:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
}

.upload-btn {
    background: #176a3a;
    border: none;
    border-radius: 8px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 1rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.upload-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    background: #14592f;
}

.order-summary {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #f0f0f0;
    height: fit-content;
    position: sticky;
    top: 20px;
}

.summary-header {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f8f9fa;
}

.summary-header::before {
    content: '📋';
    font-size: 1.5rem;
}

.transaction-info {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

.transaction-number {
    font-size: 1rem;
    margin-bottom: 8px;
}

.transaction-deadline {
    font-size: 0.95rem;
    color: #dc3545;
    display: flex;
    align-items: center;
    gap: 5px;
}

.product-item {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    display: flex;
    justify-content: between;
    align-items: flex-start;
}

.product-details {
    flex: 1;
}

.product-name {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 5px;
    color: #333;
}

.product-quantity {
    font-size: 0.9rem;
    color: #666;
}

.product-price {
    font-weight: 600;
    font-size: 1.1rem;
    color: #333;
}

.cost-breakdown {
    margin: 20px 0;
}

.cost-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.cost-item:last-child {
    border-bottom: none;
}

.cost-label {
    color: #666;
    font-size: 0.95rem;
}

.cost-value {
    font-weight: 500;
    color: #333;
}

.subtotal-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin: 15px 0;
}

.total-section {
    background: linear-gradient(135deg, #176a3a 0%, #218838 100%);
    color: white;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    margin-top: 20px;
}

.total-amount {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.alert-info {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    color: #1976d2;
}

@media (max-width: 768px) {
    .payment-container {
        margin-top: 20px;
        padding: 15px;
    }
    
    .payment-amount {
        font-size: 2.2rem;
    }
    
    .upload-section,
    .order-summary {
        margin-bottom: 20px;
    }
    
    .order-summary {
        position: static;
    }
}
</style>

<div class="payment-container">
    <!-- Payment Header -->
    <div class="payment-header">
        <div class="payment-deadline">
            ⏰ BAYAR SEBELUM {{ $deadline ?? '11 JULI 2025 PUKUL 22:46' }}
        </div>
        <div class="payment-amount">
            IDR {{ number_format($grand_total ?? 75725, 0, ',', '.') }}
        </div>
    </div>

    <div class="row g-4">
        <!-- LEFT: Payment Info -->
        <div class="col-lg-7 col-md-6">
            <div class="alert-info">
                <strong>💡 Petunjuk Pembayaran:</strong><br>
                Silakan transfer sesuai nominal yang tertera dan unggah bukti transfer di bawah ini.
            </div>
            
            <div class="upload-section">
                <div class="upload-title">
                    Unggah Bukti Transfer Pembayaran
                </div>
                
                <div class="upload-form">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('payment.upload_proof') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="buktiPembayaran" class="form-label fw-semibold">Pilih file gambar bukti transfer</label>
                            <input class="form-control file-input" 
                                   type="file" 
                                   id="buktiPembayaran" 
                                   name="bukti_pembayaran" 
                                   accept="image/*" 
                                   required>
                            <div class="form-text">Format yang didukung: JPG, JPEG, PNG (Max. 5MB)</div>
                        </div>
                        <button type="submit" class="upload-btn">
                            📤 Unggah Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- RIGHT: Order Summary -->
        <div class="col-lg-5 col-md-6">
            <div class="order-summary">
                <div class="summary-header">
                    Ringkasan Pesanan
                </div>
                
                <div class="transaction-info">
                    <div class="transaction-number">
                        <span class="text-muted">Transaksi #:</span> 
                        <strong>{{ $transaction_number ?? '71996' }}</strong>
                    </div>
                    <div class="transaction-deadline">
                        <span>⏰</span>
                        <span class="text-muted">Bayar sebelum:</span>
                        <strong>{{ $deadline ?? '11 Juli 2025 pukul 22:46' }}</strong>
                    </div>
                </div>

                <div class="product-item">
                    <div class="product-details">
                        <div class="product-name">{{ $product_name ?? 'Cardigan' }}</div>
                        <div class="product-quantity">1 × IDR {{ number_format($product_price ?? 25000, 0, ',', '.') }}</div>
                    </div>
                    <div class="product-price">IDR {{ number_format($product_price ?? 25000, 0, ',', '.') }}</div>
                </div>

                <div class="subtotal-section">
                    <div class="cost-item">
                        <span class="cost-label">Subtotal</span>
                        <span class="cost-value fw-bold">IDR {{ number_format($subtotal ?? 25000, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="cost-breakdown">
                    <div class="cost-item">
                        <span class="cost-label">🚚 Ongkos Kirim</span>
                        <span class="cost-value">IDR {{ number_format($shipping ?? 50600, 0, ',', '.') }}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label">🛡️ Asuransi Pengiriman</span>
                        <span class="cost-value">IDR {{ number_format($insurance ?? 125, 0, ',', '.') }}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label fw-semibold">Total Biaya</span>
                        <span class="cost-value fw-bold">IDR {{ number_format($total_biaya ?? 50725, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="total-section">
                    <div class="total-amount">
                        💰 IDR {{ number_format($grand_total ?? 75725, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-top: 5px;">
                        Jumlah Total yang Harus Dibayar
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection