@extends('layouts.app')

@section('content')
<div class="product-detail-modern-bg">
    <div class="product-detail-modern-container">
        <div class="product-detail-modern-left">
            <img src="{{ $produk['img'] }}" alt="{{ $produk['nama'] }}" class="product-detail-main-image">
            <div class="product-detail-thumbs">
                <img src="{{ $produk['img'] }}" alt="thumb1" class="selected">
                <img src="{{ $produk['img'] }}" alt="thumb2">
                <img src="{{ $produk['img'] }}" alt="thumb3">
            </div>
        </div>
        <div class="product-detail-modern-center">
            <div class="product-detail-title">{{ $produk['nama'] }}</div>
            <div class="product-detail-price">Rp{{ number_format($produk['harga'], 0, ',', '.') }}</div>
            <div class="product-detail-stock">Stok Total: <span>{{ $produk['stok'] }}</span></div>
            <div class="product-detail-info-list">
                <div><span class="label">Kategori:</span> <span class="value">{{ $produk['kategori'] }}</span></div>
                <div><span class="label">Berat Bersih:</span> <span class="value">50gr</span></div>
                <div><span class="label">Jumlah Biji:</span> <span class="value">50</span></div>
            </div>
            <div class="product-detail-desc">{{ $produk['deskripsi'] }}</div>
        </div>
        <div class="product-detail-modern-right">
            <div class="product-detail-card">
                <div class="product-detail-card-title">Atur jumlah dan catatan</div>
                <div class="product-detail-card-qty">
                    <button class="qty-btn" onclick="decrementQty(event)">-</button>
                    <input type="text" id="qtyInput" value="1" min="1" readonly style="width:40px;text-align:center;background:#fff;cursor:default;">
                    <button class="qty-btn" onclick="incrementQty(event)">+</button>
                    <span class="product-detail-card-stock">Stok Total: {{ $produk['stok'] }}</span>
                </div>
                <div id="stockWarning" style="color:#d32f2f;font-size:0.98rem;display:none;margin-bottom:8px;">Stok tidak mencukupi</div>
                <div class="product-detail-card-subtotal">
                    Subtotal
                    <span id="subtotal">Rp{{ number_format($produk['harga'], 0, ',', '.') }}</span>
                </div>
                <button class="btn-green w-100" style="margin-bottom:10px;">+ Keranjang</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.product-detail-modern-bg {
    min-height: 100vh;
    background: #f8f9fa;
    padding-top: 100px; /* dinaikkan agar tidak tenggelam appbar */
    padding-bottom: 40px;
}
.product-detail-modern-container {
    display: flex;
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 40px 32px;
}
.product-detail-modern-left {
    flex: 1.1;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.product-detail-main-image {
    width: 340px;
    height: 340px;
    object-fit: contain;
    border-radius: 16px;
    background: #f3f3f3;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.product-detail-thumbs {
    display: flex;
    gap: 10px;
    margin-bottom: 18px;
}
.product-detail-thumbs img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
    cursor: pointer;
}
.product-detail-thumbs img.selected {
    border: 2px solid #4CAF50;
}
.product-detail-modern-center {
    flex: 1.5;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    padding-top: 10px;
}
.product-detail-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
}
.product-detail-price {
    color: #388E3C;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 8px;
}
.product-detail-stock {
    color: #888;
    font-size: 1rem;
    margin-bottom: 18px;
}
.product-detail-info-list {
    margin-bottom: 18px;
}
.product-detail-info-list .label {
    color: #888;
    font-weight: 500;
    margin-right: 8px;
}
.product-detail-info-list .value {
    color: #222;
    font-weight: 500;
}
.product-detail-desc {
    margin-top: 18px;
    color: #444;
    font-size: 1.1rem;
}
.product-detail-modern-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}
.product-detail-card {
    width: 320px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    padding: 24px 20px 18px 20px;
    display: flex;
    flex-direction: column;
    align-items: stretch;
    margin-top: 0;
}
.product-detail-card-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 16px;
}
.product-detail-card-qty {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}
.qty-btn {
    background: #f3f3f3;
    border: none;
    border-radius: 6px;
    width: 32px;
    height: 32px;
    font-size: 1.2rem;
    color: #388E3C;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}
.qty-btn:hover {
    background: #E8F5E9;
}
.product-detail-card-stock {
    color: #888;
    font-size: 0.98rem;
    margin-left: 10px;
}
.product-detail-card-subtotal {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 18px;
    margin-top: 8px;
}
.btn-green {
    background: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px 32px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-green:hover {
    background: #388E3C;
}
.btn-outline {
    background: #fff;
    color: #388E3C;
    border: 2px solid #4CAF50;
    border-radius: 8px;
    padding: 12px 32px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
}
.btn-outline:hover {
    background: #E8F5E9;
    color: #222;
}
.product-detail-card-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 16px;
    font-size: 1.05rem;
    color: #888;
}
.icon-action {
    display: flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    transition: color 0.2s;
}
.icon-action:hover {
    color: #388E3C;
}
@media (max-width: 1100px) {
    .product-detail-modern-container {
        flex-direction: column;
        padding: 18px 6px;
        gap: 18px;
    }
    .product-detail-modern-right {
        align-items: stretch;
    }
    .product-detail-card {
        width: 100%;
        margin-top: 18px;
    }
}
</style>
@endpush
@push('scripts')
<script>
function incrementQty(e) {
    e.preventDefault();
    var qtyInput = document.getElementById('qtyInput');
    var stok = {{ $produk['stok'] }};
    var qty = parseInt(qtyInput.value);
    if (qty < stok) {
        qtyInput.value = qty + 1;
        document.getElementById('stockWarning').style.display = 'none';
    } else {
        document.getElementById('stockWarning').style.display = 'block';
    }
    updateSubtotal();
}
function decrementQty(e) {
    e.preventDefault();
    var qtyInput = document.getElementById('qtyInput');
    var qty = parseInt(qtyInput.value);
    if (qty > 1) {
        qtyInput.value = qty - 1;
        document.getElementById('stockWarning').style.display = 'none';
    }
    updateSubtotal();
}
function updateSubtotal() {
    var qty = parseInt(document.getElementById('qtyInput').value);
    var price = {{ $produk['harga'] }};
    document.getElementById('subtotal').innerText = 'Rp' + (qty * price).toLocaleString('id-ID');
}
</script>
@endpush 