@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
<div class="product-detail-modern-bg">
    <div class="product-detail-modern-container">
        <div class="product-detail-modern-left">
            <div class="product-detail-main-image-wrapper">
                <img src="{{ asset('images/' . $product->image1) }}" alt="{{ $product->product_name }}" class="product-detail-main-image">
            </div>
            <div class="product-detail-thumbs">
                <img src="{{ asset('images/' . $product->image1) }}" alt="thumb1" class="selected">
                @if($product->image2)
                    <img src="{{ asset('images/' . $product->image2) }}" alt="thumb2">
                @endif
                @if($product->image_certificate)
                    <img src="{{ asset('images/' . $product->image_certificate) }}" alt="certificate">
                @endif
            </div>
        </div>
        <div class="product-detail-modern-center">
            <div class="product-detail-title">{{ $product->product_name }}</div>
            <div class="product-detail-price">Rp{{ number_format($product->price_per_unit, 0, ',', '.') }} / {{ $product->unit }}</div>
            @php
                $availableStock = $product->stock - $product->minimum_stock;
                $isOutOfStock = $availableStock <= 0;
            @endphp
            <div class="product-detail-stock {{ $isOutOfStock ? 'text-danger' : '' }}">
                Stok: {{ $availableStock }} {{ $product->unit }}
                @if($isOutOfStock)
                    <span style="color: #d32f2f; font-weight: 500;">(Stok Habis)</span>
                @endif
            </div>
            <div class="product-detail-desc">{{ $product->description }}</div>
        </div>
        <div class="product-detail-modern-right">
            @if(session('error'))
                <div style="background:#ffebee;border:1px solid #f44336;border-radius:8px;padding:12px;margin-bottom:16px;color:#d32f2f;font-size:0.9rem;">
                    <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div style="background:#e8f5e9;border:1px solid #4caf50;border-radius:8px;padding:12px;margin-bottom:16px;color:#2e7d32;font-size:0.9rem;">
                    <i class="fas fa-check-circle" style="margin-right:6px;"></i>
                    {{ session('success') }}
                </div>
            @endif
            <div class="product-detail-card">
                <div class="product-detail-card-title">Atur jumlah dan catatan</div>
                @if($isOutOfStock)
                    <div style="text-align: center; padding: 20px; color: #d32f2f; font-weight: 500;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 24px; margin-bottom: 8px;"></i>
                        <div>Produk tidak tersedia</div>
                        <div style="font-size: 0.9rem; margin-top: 4px; color: #666;">Stok telah habis</div>
                    </div>
                @else
                    <form method="POST" action="{{ Auth::check() ? route('cart.add', $product->product_id) : route('login') }}" id="addToCartForm">
                        @csrf
                        <div class="product-detail-card-qty">
                            <input type="text" id="qtyInput" name="quantity" value="" placeholder="0" min="{{ $product->minimum_purchase }}" max="{{ $availableStock }}" style="width:60px;text-align:center;background:#fff;">
                            <span style="margin-left:8px;">{{ $product->unit }}</span>
                            <span style="margin-left:8px;color:#d32f2f;font-size:0.9rem;">*Minimal Pembelian {{ number_format($product->minimum_purchase, 0, ',', '') }}{{ $product->unit }}</span>
                        </div>
                        <div id="stockWarning" style="color:#d32f2f;font-size:0.98rem;display:none;margin-bottom:8px;">
                            <i class="fas fa-exclamation-triangle" style="margin-right:4px;"></i>
                            Stok tidak mencukupi
                        </div>
                        <div id="minPurchaseWarning" style="color:#d32f2f;font-size:0.98rem;display:none;margin-bottom:8px;">
                            <i class="fas fa-exclamation-triangle" style="margin-right:4px;"></i>
                            Minimal pembelian tidak terpenuhi
                        </div>
                        <div class="product-detail-card-subtotal">
                            Subtotal
                            <span id="subtotal">Rp0</span>
                        </div>
                        <button class="btn-green w-100" style="margin-bottom:10px;opacity:0.6;cursor:not-allowed;background:#ccc !important;color:#666 !important;" type="submit" id="addToCartBtn" disabled>+ Keranjang</button>
                    </form>
                @endif
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
.product-detail-main-image-wrapper {
    width: 340px;
    height: 340px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f3f3f3;
    border-radius: 16px;
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
@if(!$isOutOfStock)
function updateSubtotal() {
    let qty = parseFloat(document.getElementById('qtyInput').value.replace(',', '.')) || 0;
    let harga = {{ $product->price_per_unit }};
    let availableStock = {{ $availableStock }};
    let minimumPurchase = {{ $product->minimum_purchase }};
    
    // Reset semua warning
    document.getElementById('stockWarning').style.display = 'none';
    document.getElementById('minPurchaseWarning').style.display = 'none';
    
    // Jika quantity kosong atau 0
    if (qty === 0 || document.getElementById('qtyInput').value.trim() === '') {
        document.getElementById('subtotal').innerText = 'Rp0';
        const addToCartBtn = document.getElementById('addToCartBtn');
        addToCartBtn.disabled = true;
        addToCartBtn.style.opacity = '0.6';
        addToCartBtn.style.cursor = 'not-allowed';
        return;
    }
    
    // Validasi minimal pembelian
    if (qty < minimumPurchase) {
        document.getElementById('minPurchaseWarning').style.display = 'block';
        document.getElementById('minPurchaseWarning').innerText = 'Minimal pembelian: ' + {{ number_format($product->minimum_purchase, 0, ',', '') }} + ' {{ $product->unit }}';
        // Jangan otomatis set ke minimal pembelian, biarkan user input manual
        // qty = minimumPurchase;
        // document.getElementById('qtyInput').value = qty;
    }
    
    // Validasi stok
    if (qty > availableStock) {
        document.getElementById('stockWarning').style.display = 'block';
        document.getElementById('stockWarning').innerText = 'Stok tidak mencukupi. Maksimal: ' + availableStock + ' {{ $product->unit }}';
        qty = availableStock;
        document.getElementById('qtyInput').value = qty;
    }
    
    document.getElementById('subtotal').innerText = 'Rp' + (harga * qty).toLocaleString('id-ID');
    
    // Disable/enable tombol berdasarkan validasi
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (qty < minimumPurchase || qty > availableStock || qty === 0) {
        addToCartBtn.disabled = true;
        addToCartBtn.style.opacity = '0.6';
        addToCartBtn.style.cursor = 'not-allowed';
        addToCartBtn.style.background = '#ccc';
        addToCartBtn.style.color = '#666';
    } else {
        addToCartBtn.disabled = false;
        addToCartBtn.style.opacity = '1';
        addToCartBtn.style.cursor = 'pointer';
        addToCartBtn.style.background = '#388e3c';
        addToCartBtn.style.color = '#fff';
    }
}

const unitProduk = @json($product->unit);
const qtyInput = document.getElementById('qtyInput');
const minimumPurchase = {{ $product->minimum_purchase }};
const availableStock = {{ $availableStock }};

if (["Mata", "Tanaman", "Rizome"].includes(unitProduk)) {
    qtyInput.setAttribute('type', 'number');
    qtyInput.setAttribute('step', '1');
    qtyInput.setAttribute('min', minimumPurchase);
    qtyInput.setAttribute('max', availableStock);
    qtyInput.addEventListener('input', function(e) {
        let val = this.value;
        if (val !== "") {
            val = parseInt(val, 10);
            if (isNaN(val)) {
                this.value = "";
            } else if (val > availableStock) {
                val = availableStock;
                this.value = val;
            }
        }
        updateSubtotal();
    });
    qtyInput.addEventListener('blur', function(e) {
        if (this.value === "" || isNaN(this.value)) {
            this.value = "";
            updateSubtotal();
        }
    });
} else {
    qtyInput.setAttribute('min', minimumPurchase);
    qtyInput.setAttribute('max', availableStock);
    qtyInput.addEventListener('input', function(e) {
        updateSubtotal();
    });
    qtyInput.addEventListener('blur', function(e) {
        let val = this.value.replace(',', '.');
        if (val === "" || isNaN(val)) {
            this.value = "";
        } else {
            val = parseFloat(val);
            if (val > availableStock) {
                val = availableStock;
                this.value = val;
            }
        }
        updateSubtotal();
    });
}

// Inisialisasi subtotal saat halaman dimuat
updateSubtotal();

// Validasi form submission
document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    let qty = parseFloat(document.getElementById('qtyInput').value.replace(',', '.')) || 0;
    let minimumPurchase = {{ $product->minimum_purchase }};
    let availableStock = {{ $availableStock }};
    
    if (qty === 0 || document.getElementById('qtyInput').value.trim() === '') {
        e.preventDefault();
        alert('Silakan masukkan jumlah yang ingin dibeli');
        return false;
    }
    
    if (qty < minimumPurchase) {
        e.preventDefault();
        alert('Minimal pembelian: ' + {{ number_format($product->minimum_purchase, 0, ',', '') }} + ' {{ $product->unit }}');
        return false;
    }
    
    if (qty > availableStock) {
        e.preventDefault();
        alert('Stok tidak mencukupi. Maksimal: ' + availableStock + ' {{ $product->unit }}');
        return false;
    }
});
@endif
</script>
@endpush 
@section('after_content')
    @include('customer.partials.mitra_footer')
@endsection