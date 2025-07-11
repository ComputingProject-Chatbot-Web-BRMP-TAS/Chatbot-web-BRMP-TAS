@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    body { 
        background: #f4f6fa !important; 
        font-family: 'Roboto', sans-serif;
    }
    .cart-main {
        max-width: 1200px;
        margin: 40px auto 0 auto;
        display: flex;
        gap: 32px;
        align-items: flex-start;
    }
    .cart-left {
        flex: 2;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }
    .cart-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-top: -70px;
        margin-bottom: 24px;
    }
    .cart-title-margin {
        margin-top: 80px;
    }
    .cart-empty-box {
        background: #fff;
        border-radius: 18px;
        padding: 36px 32px;
        display: flex;
        align-items: center;
        gap: 28px;
        margin-bottom: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .cart-empty-img {
        width: 90px;
        height: 90px;
        background: #eaffea;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
    }
    .cart-empty-content {
        flex: 1;
        
    }
    .cart-empty-content h5 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 6px;
        color: #222;
    }
    .cart-empty-content p {
        color: #666;
        margin-bottom: 18px;
    }
    .cart-empty-content .btn-green {
        background: #388e3c;
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
        padding: 8px 28px;
        border: none;
        text-decoration: none;
        display: inline-block;
        transition: background 0.2s;
    }
    .cart-empty-content .btn-green:hover {
        background: #2e7d32;
    }
    .cart-summary {
        flex: 1;
        background: #fff;
        border-radius: 18px;
        padding: 28px 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        min-width: 260px;
        margin-top: -10px;
    }
    .cart-summary-title {
        font-weight: 600;
        margin-bottom: 18px;
    }
    .cart-summary-promo {
        background: #fffde7;
        border-radius: 8px;
        padding: 10px 14px;
        color: #bfa100;
        font-size: 15px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .cart-summary .btn {
        width: 100%;
        border-radius: 8px;
        background: #eee;
        color: #bbb;
        font-weight: 600;
        pointer-events: none;
        border: none;
        padding: 12px;
    }
    .recommend-section {
        max-width: 1200px;
        margin: 40px auto 0 auto;
    }
    .recommend-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 24px;
    }
    .recommend-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 22px;
    }
    .recommend-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 0 0 16px 0;
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }
    .recommend-img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 14px 14px 0 0;
        background: #eaffea;
    }
    .recommend-info {
        padding: 12px 16px 0 16px;
    }
    .recommend-title2 {
        font-weight: 500;
        font-size: 16px;
        margin-bottom: 4px;
        color: #222;
    }
    .recommend-price {
        color: #388e3c;
        font-weight: bold;
        font-size: 17px;
        margin-bottom: 4px;
    }
    .recommend-rating {
        color: #ffd600;
        font-size: 15px;
        margin-bottom: 4px;
    }
    .recommend-btn {
        margin: 10px 16px 0 16px;
        background: #fffbe7;
        color: #388e3c;
        border: 1.5px solid #ffd600;
        border-radius: 8px;
        font-weight: 600;
        padding: 6px 0;
        transition: background 0.2s;
        cursor: pointer;
    }
    .recommend-btn:hover {
        background: #fffde7;
    }
    @media (max-width: 900px) {
        .cart-main, .recommend-section {
            max-width: 100%;
            margin: 24px 0 0 0;
            padding: 0 8px;
        }
        .cart-main {
            flex-direction: column;
            gap: 0;
        }
        .cart-summary {
            margin-top: 24px;
            min-width: unset;
        }
    }
    .cart-summary-margin {
        margin-top: 135px;
    }
</style>

<div class="cart-main">
    <div class="cart-left">
        <div class="cart-title cart-title-margin">Keranjang</div>
        @if($items->isEmpty())
            <div class="cart-empty-box">
                <div class="cart-empty-img">
                    <i class="fas fa-box-open" style="color:#ffd600;"></i>
                </div>
                <div class="cart-empty-content">
                    <h5>Wah, keranjang belanjamu kosong</h5>
                    <p>Yuk, isi dengan barang-barang impianmu!</p>
                    <a href="/" class="btn-green">Mulai Belanja</a>
                </div>
            </div>
        @else
            @foreach($items as $item)
                <div class="cart-empty-box" style="flex-direction:row;align-items:center;gap:18px;">
                    <img src="{{ asset('images/' . $item->product->gambar) }}" alt="{{ $item->product->nama }}" style="width:70px;height:70px;object-fit:cover;border-radius:12px;">
                    <div style="flex:1;">
                        <div style="font-weight:600;font-size:1.1rem;">{{ $item->product->nama }}</div>
                        <div style="color:#388e3c;font-weight:500;">Rp{{ number_format($item->harga_satuan,0,',','.') }} x {{ $item->kuantitas }}</div>
                        <div style="color:#757575;font-size:0.98rem;">Subtotal: Rp{{ number_format($item->harga_satuan * $item->kuantitas,0,',','.') }}</div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="cart-summary cart-summary-margin">
        <div class="cart-summary-title">Ringkasan belanja</div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
            <span style="color:#666; font-size:16px;">Total</span>
            <span style="color:#388e3c; font-size:20px; font-weight:700;">Rp{{ number_format($total,0,',','.') }}</span>
        </div>
        <button class="btn" disabled>Beli</button>
    </div>
</div>
<div class="recommend-section">
    <div class="recommend-title">Rekomendasi untukmu</div>
    <div class="recommend-grid">
        <div class="recommend-card">
            <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80" class="recommend-img" alt="car">
            <div class="recommend-info">
                <div class="recommend-title2">Honda Brio Satya</div>
                <div class="recommend-price">Rp40.000.000</div>
                <div class="recommend-rating"><i class="fas fa-star"></i> 4.7 (47)</div>
            </div>
            <button class="recommend-btn">+ Keranjang</button>
        </div>
        <div class="recommend-card">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" class="recommend-img" alt="wood">
            <div class="recommend-info">
                <div class="recommend-title2">"HATI YANG HAMPA" kayu jati</div>
                <div class="recommend-price">Rp1.500.000</div>
                <div class="recommend-rating"><i class="fas fa-star"></i> 5.0 (1)</div>
            </div>
            <button class="recommend-btn">+ Keranjang</button>
        </div>
        <div class="recommend-card">
            <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" class="recommend-img" alt="motor">
            <div class="recommend-info">
                <div class="recommend-title2">Paket Bobber Indian Style</div>
                <div class="recommend-price">Rp2.300.000</div>
                <div class="recommend-rating"><i class="fas fa-star"></i> 5.0 (1)</div>
            </div>
            <button class="recommend-btn">+ Keranjang</button>
        </div>
        <div class="recommend-card">
            <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=400&q=80" class="recommend-img" alt="shirt">
            <div class="recommend-info">
                <div class="recommend-title2">Lycus Clothing Tshirt</div>
                <div class="recommend-price">Rp75.000</div>
                <div class="recommend-rating"><i class="fas fa-star"></i> 4.9 (15)</div>
            </div>
            <button class="recommend-btn">+ Keranjang</button>
        </div>
    </div>
</div>
@section('after_content')
    @include('partials.mitra_footer')
@endsection
@endsection