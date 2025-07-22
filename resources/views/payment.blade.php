@php($hideAppbar = true)
@extends('layouts.app')

@section('content')
@include('partials.appbar_fokus')
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
            <span style="font-weight:600;">⏰ BAYAR SEBELUM {{ $deadline }}</span>
            <div id="countdown-timer" style="font-size:2rem;font-weight:800;color:#f8f9fa;margin-top:8px;"></div>
        </div>
        <div class="payment-amount">
            Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
        </div>
    </div>

    <div class="row g-4">
        <!-- LEFT: Payment Info -->
        <div class="col-lg-7 col-md-6">
            <div class="alert-info">
                <strong>💡 Petunjuk Pembayaran:</strong><br>
                Silakan transfer sesuai nominal yang tertera dan unggah bukti transfer di bawah ini.
            </div>
            
            @if($address)
            <div class="alert-info">
                <strong>📍 Alamat Pengiriman:</strong><br>
                <strong>{{ $address->recipient_name }}</strong><br>
                {{ $address->address }}<br>
                Telp: {{ $address->recipient_phone }}
                @if($address->note)
                    <br><small class="text-muted">Catatan: {{ $address->note }}</small>
                @endif
            </div>
            @elseif($transaction->recipient_name)
            <div class="alert-info">
                <strong>📍 Alamat Pengiriman:</strong><br>
                <strong>{{ $transaction->recipient_name }}</strong><br>
                {{ $transaction->shipping_address }}<br>
                Telp: {{ $transaction->recipient_phone }}
                @if($transaction->shipping_note)
                    <br><small class="text-muted">Catatan: {{ $transaction->shipping_note }}</small>
                @endif
            </div>
            @endif
            
            <div class="upload-section">
                <div class="upload-title">
                    Unggah Bukti Transfer Pembayaran
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
                        <span class="text-muted">ID Transaksi:</span>
                        <strong>#{{ $transaction->transaksi_id }}</strong>
                    </div>
                    <div class="transaction-number">
                        <span class="text-muted">Tanggal Pesanan:</span>
                        <strong>{{ $transaction->order_date->format('d M Y H:i') }}</strong>
                    </div>
                    <div class="transaction-number">
                        <span class="text-muted">Metode Pengiriman:</span>
                        <strong>{{ ucfirst($transaction->delivery_method) }}</strong>
                    </div>
                    <div class="transaction-deadline">
                        <span>⏰</span>
                        <span class="text-muted">Bayar sebelum:</span>
                        <strong>{{ $deadline }}</strong>
                    </div>
                </div>

                @if($transaction->transactionItems && count($transaction->transactionItems) > 0)
                    @foreach($transaction->transactionItems as $item)
                        <div class="product-item">
                            <div class="product-details">
                                <div class="product-name">{{ $item->product->nama ?? '-' }}</div>
                                <div class="product-quantity">{{ $item->quantity }} × IDR {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                            </div>
                            <div class="product-price">IDR {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                @endif

                <div class="subtotal-section">
                    <div class="cost-item">
                        <span class="cost-label">Subtotal</span>
                        <span class="cost-value fw-bold">IDR {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="cost-breakdown">
                    <div class="cost-item">
                        <span class="cost-label">🚚 Ongkos Kirim</span>
                        <span class="cost-value">IDR {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label">🛡️ Asuransi Pengiriman</span>
                        <span class="cost-value">IDR {{ number_format($insurance, 0, ',', '.') }}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label fw-semibold">Total Biaya</span>
                        <span class="cost-value fw-bold">IDR {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="total-section">
                    <div class="total-amount">
                        💰 IDR {{ number_format($transaction->total_harga, 0, ',', '.') }}
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
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Ambil deadline dari server (format: d M Y Pukul H:i)
    var deadlineString = @json($deadline);
    // Ubah ke format yang bisa diparse JS
    // Contoh: "23 Jul 2025 Pukul 23:21" => "23 Jul 2025 23:21"
    var match = deadlineString.match(/^(\d{1,2} \w{3,9} \d{4}) Pukul (\d{2}:\d{2})/);
    if (!match) return;
    var dateStr = match[1] + ' ' + match[2];
    // Parse ke Date (asumsi zona waktu lokal user)
    var deadline = new Date(dateStr.replace(/ /g, '-').replace(/-/,' '));
    // Fallback jika parsing gagal
    if (isNaN(deadline.getTime())) {
      // Coba format lain
      deadline = new Date(match[1] + 'T' + match[2] + ':00');
    }
    function updateCountdown() {
      var now = new Date();
      var diff = deadline - now;
      if (diff <= 0) {
        document.getElementById('countdown-timer').innerHTML = 'Waktu pembayaran telah habis';
        clearInterval(timerInterval);
        return;
      }
      var hours = Math.floor(diff / (1000 * 60 * 60));
      var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((diff % (1000 * 60)) / 1000);
      document.getElementById('countdown-timer').innerHTML =
        'Sisa waktu Pembayaran: ' + hours.toString().padStart(2,'0') + ':' + minutes.toString().padStart(2,'0') + ':' + seconds.toString().padStart(2,'0');
    }
    updateCountdown();
    var timerInterval = setInterval(updateCountdown, 1000);
  });
</script>