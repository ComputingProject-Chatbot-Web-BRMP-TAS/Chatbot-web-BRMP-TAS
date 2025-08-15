@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: #f8f9fa;
        margin: 0;
        color: #222;
        padding-top: 0; /* Remove default padding */
    }
    
    /* Mobile-first styles */
    .cart-container {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
        background: #f8f9fa;
        min-height: 50vh;
        color: #222;
        position: relative;
    }
    
    .back-btn {
        background: none;
        border: none;
        color: #222;
        font-size: 18px;
        cursor: pointer;
        padding: 8px;
    }
    
    .page-title {
        font-size: 18px;
        font-weight: 600;
        color: #222;
    }
    
    .wishlist-btn {
        background: none;
        border: none;
        color: #222;
        font-size: 18px;
        cursor: pointer;
        padding: 8px;
    }
    
    /* Product Section */
    .product-section {
        margin: 16px 16px 16px 16px;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #e0e0e0;
    }
    
    /* Product Card */
    .product-card {
        padding: 12px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .product-card:last-child {
        border-bottom: none;
    }
    
    .product-checkbox {
        width: 18px;
        height: 18px;
        accent-color: #4CAF50;
        border-radius: 4px;
        margin-top: 4px;
    }
    
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
    }
    
    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .product-name {
        font-size: 14px;
        font-weight: 500;
        color: #222;
        line-height: 1.3;
    }
    
    .price-section {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .current-price {
        font-size: 18px;
        font-weight: 700;
        color: #f44336;
    }
    
    .quantity-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    
    .delete-btn {
        background: none;
        border: none;
        color: #999;
        font-size: 16px;
        cursor: pointer;
        padding: 4px;
    }
    
    .quantity-display {
        background: #f5f5f5;
        color: #222;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        min-width: 40px;
        text-align: center;
        border: 1px solid #e0e0e0;
    }
    
    .mobile-qty-input {
        background: #fff;
        border: 1.5px solid #bfc9d1;
        font-weight: 600;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 14px;
        text-align: center;
        width: 60px;
    }
    
    /* Bottom Checkout Bar */
    .checkout-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        padding: 16px;
        border-top: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 998; /* Lower than mobile header */
        box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
        height: 80px; /* Fixed height */
    }
    
    .select-all-section {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .select-all-checkbox {
        width: 20px;
        height: 20px;
        accent-color: #4CAF50;
        border-radius: 4px;
    }
    
    .select-all-text {
        font-size: 14px;
        color: #222;
        font-weight: 500;
    }
    
    .total-section {
        flex: 1;
        text-align: center;
        margin: 0 16px;
    }
    
    .total-price {
        font-size: 20px;
        font-weight: 700;
        color: #222;
        margin-bottom: 4px;
    }
    
    .total-discount {
        display: none;
    }
    
    .checkout-btn {
        background: #4CAF50;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }
    
    .checkout-btn:disabled {
        background: #333;
        color: #666;
        cursor: not-allowed;
    }
    
    /* Desktop styles */
    .cart-main {
        width: 100%;
        max-width: 1200px;
        margin: 60px auto 40px auto;
        display: flex;
        gap: 0px;
        align-items: flex-start;
        padding: 0 20px;
        flex-direction: column;
    }
    
    .cart-left {
        flex: 1;
        max-width: 800px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }
    
    .cart-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 24px;
        color: #222;
        margin-top: 32px;
        margin-bottom: 24px;
    }
    
    .cart-item-box {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #e0e0e0;
    }
    
    .cart-item-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #666;
    }
    
    .cart-item-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .cart-item-name {
        font-size: 16px;
        font-weight: 600;
        color: #222;
        line-height: 1.3;
    }
    
    .cart-item-price-qty {
        font-size: 14px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .cart-item-qty-input {
        width: 60px;
        padding: 4px 8px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        text-align: center;
        font-size: 14px;
    }
    
    .cart-item-subtotal {
        font-size: 16px;
        font-weight: 600;
        color: #388e3c;
    }
    
    .cart-empty-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        text-align: center;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #e0e0e0;
    }
    
    .cart-empty-img {
        font-size: 64px;
        margin-bottom: 24px;
    }
    
    .cart-empty-content h5 {
        font-size: 1.4rem;
        font-weight: 600;
        color: #222;
        margin-bottom: 12px;
    }
    
    .cart-empty-content p {
        color: #666;
        margin-bottom: 24px;
        font-size: 1rem;
    }
    
    .cart-empty-content .btn-green {
        background: #4CAF50;
        color: white;
        text-decoration: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
        transition: background 0.2s;
    }
    
    .cart-empty-content .btn-green:hover {
        background: #2e7d32;
    }
    
    .cart-summary {
        flex: 1;
        background: #fff;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        min-width: 300px;
        max-width: 350px;
        border: 1px solid #e0e0e0;
        height: fit-content;
        position: sticky;
        top: 80px;
        margin-top: 0px;
    }
    
    .cart-summary-title {
        font-weight: 600;
        margin-bottom: 24px;
        font-size: 1.2rem;
        color: #222;
    }
    
    .cart-summary .btn {
        width: 100%;
        border-radius: 8px;
        background: #388e3c;
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 16px;
        font-size: 1.1rem;
        margin-top: 24px;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .cart-summary .btn:hover {
        background: #2e7d32;
    }
    
    .cart-summary .btn:disabled {
        background: #eee;
        color: #bbb;
        cursor: not-allowed;
    }
    
    .cart-row{
        width:100%;
        margin-bottom:0px; 
        display:flex; 
        flex-direction: row;
        gap: 20px;
    }

    .btn-hapus {
        background: #fff;
        border: 1.5px solid #e57373;
        color: #e53935;
        border-radius: 8px;
        padding: 8px 16px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s, border 0.2s, color 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
    }
    
    .btn-hapus:hover {
        background: #ffebee;
        border-color: #e53935;
        color: #b71c1c;
    }
    
    .checkall-label {
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        user-select: none;
        margin-bottom: 16px;
        font-size: 1rem;
        color: #222;
    }
    
    .checkall-box {
        accent-color: #388e3c;
        width: 20px;
        height: 20px;
        border-radius: 5px;
        border: 2px solid #388e3c;
        margin-right: 4px;
    }
    
    .cart-item-checkbox {
        accent-color: #388e3c;
        width: 18px;
        height: 18px;
        border-radius: 4px;
        margin-right: 10px;
    }
    
    .btn-active {
        background: #388e3c !important;
        color: #fff !important;
        pointer-events: auto !important;
    }
    
    /* Responsive breakpoints */
        .cart-container {
            background: #f8f9fa;
            color: #222;
        }

        .product-section,
        .checkout-bar {
            display: none !important;
        }
        
        .cart-main {
            display: flex !important;
        }
        
        .cart-title {
            display: block !important;
        }
        
        .cart-item-box {
            display: flex !important;
        }
        
        .cart-empty-box {
            display: flex !important;
        }
        
        .checkall-label {
            display: flex !important;
        }
    
    @media (max-width: 1023px) {
        .cart-main,
        .cart-title,
        .cart-item-box,
        .cart-empty-box,
        .checkall-label {
            display: none !important;
        }
        
        .product-section,
        .checkout-bar {
            display: block !important;
        }
        
        .checkout-bar {
            display: flex !important;
        }
        
        /* Add bottom padding to prevent content from being hidden behind checkout bar */
        .cart-container {
            padding-bottom: 100px;
            padding-top: 65px; /* Adjusted for mobile header */
        }
    }
</style>

<div class="cart-container">

    @if(session('error'))
        <div style="background:#ffebee;border:1px solid #f44336;border-radius:8px;padding:12px;margin:16px;color:#d32f2f;font-size:0.9rem;">
            <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div style="background:#e8f5e9;border:1px solid #4caf50;border-radius:8px;padding:12px;margin:16px;color:#2e7d32;font-size:0.9rem;">
            <i class="fas fa-check-circle" style="margin-right:6px;"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Mobile Cart Items -->
    @if($items->isEmpty())
        <!-- Mobile Empty State -->
        <div class="mobile-empty-state">
            <i class="fas fa-shopping-cart"></i>
            <h3>Keranjang Kosong</h3>
            <p>Belum ada produk di keranjang belanja</p>
            <a href="/" class="btn-green">Mulai Belanja</a>
        </div>
        <style>
            .mobile-empty-state {
                position: absolute;
                top: 0;
                left: 0;
                width: 100vw;
                height: calc(100vh - 80px); /* 80px = checkout bar height */
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                color: #222;
                background: #f8f9fa;
                z-index: 998;
                padding-bottom: 80px;
            }
            .mobile-empty-state i {
                font-size: 48px;
                color: #666;
                margin-bottom: 16px;
            }
            .mobile-empty-state .btn-green {
                background: #4CAF50;
                color: white;
                padding: 12px 24px;
                border-radius: 8px;
                text-decoration: none;
                display: inline-block;
                margin-top: 16px;
                font-weight: 600;
            }
        </style>
    @else
        <!-- Mobile Product Items -->
        @foreach($items as $item)
        @php
            $availableStock = $item->product->stock - $item->product->minimum_stock;
            $isOutOfStock = $availableStock <= 0;
            $isQuantityExceedStock = $item->quantity > $availableStock;
            $isQuantityBelowMin = $item->quantity < $item->product->minimum_purchase;
        @endphp
        <div class="product-section">
            <div class="product-card" style="{{ $isOutOfStock || $isQuantityBelowMin ? 'opacity: 0.7;' : '' }}">
                <input type="checkbox" class="product-checkbox mobile-cart-checkbox" name="checked_items[]" value="{{ $item->cart_item_id }}" onchange="updateSummaryMobile()" checked {{ $isOutOfStock || $isQuantityBelowMin ? 'disabled' : '' }}>
                <img src="{{ asset('images/' . $item->product->gambar) }}" alt="{{ $item->product->product_name }}" class="product-image">
                <div class="product-info">
                    <div class="product-name">
                        {{ $item->product->product_name }}
                    </div>
                    
                    @if($isOutOfStock)
                        <div style="color:#f44336;font-weight:500;font-size:12px;">
                            <i class="fas fa-exclamation-triangle"></i> Stok habis
                        </div>
                    @elseif($isQuantityExceedStock)
                        <div style="color:#f44336;font-size:12px;">
                            <i class="fas fa-exclamation-triangle"></i> Stok tidak mencukupi (maks: {{ $availableStock }} {{ $item->product->unit }})
                        </div>
                    @elseif($isQuantityBelowMin)
                        <div style="color:#f44336;font-size:12px;">
                            <i class="fas fa-exclamation-triangle"></i> Minimal pembelian: {{ number_format($item->product->minimum_purchase, 0, ',', '') }} {{ $item->product->unit }}
                        </div>
                    @endif
                    
                    <div class="price-section">
                        <div class="current-price">Rp{{ number_format($item->price_per_unit,0,',','.') }}</div>
                    </div>
                </div>
                
                <div class="quantity-section">
                    <button class="delete-btn" onclick="deleteItem({{ $item->cart_item_id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <input type="text" 
                               class="quantity-display mobile-qty-input" 
                               value="{{ $item->quantity }}" 
                               min="{{ $item->product->minimum_purchase }}" 
                               max="{{ $availableStock }}"
                               onchange="updateQtyMobile({{ $item->cart_item_id }}, {{ $item->product->minimum_purchase }})"
                               {{ $isOutOfStock || $isQuantityBelowMin ? 'disabled' : '' }}>
                        <span style="font-size: 14px; color: #222;">{{ $item->product->unit }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif

    <!-- Desktop Cart Summary -->
    <div class="cart-main">
        <div class="cart-row" style="flex-direction: column;">
            <!-- Tambahkan konten baris di sini jika diperlukan -->
            <!-- Desktop Title -->
             <div class="cart-title">
                Keranjang
                <span style="font-size:1.1rem;font-weight:600;color:#388e3c;margin-left:10px;">
                    ({{ $items->count() }} Benih)
                </span>
            </div>
            <!-- Desktop Select All -->
            <div style="margin-bottom:0px;display:flex;align-items:flex-start;gap:12px;">
                <input type="checkbox" id="checkAll" class="checkall-box" onclick="toggleAll(this)" style="margin-top:4px;">
                <label for="checkAll" class="checkall-label">Pilih Semua</label>
            </div>
        </div>
        <div class="cart-row">
            <!-- Tambahkan konten baris di sini jika diperlukan -->
            <div class="cart-left">
                @if($items->isEmpty())
                <!-- Desktop Empty State (dipindah ke sini) -->
                <div class="cart-empty-box" id="desktop-empty-state">
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
            <!-- Desktop Cart Items -->
            @foreach($items as $item)
            @php
            $availableStock = $item->product->stock - $item->product->minimum_stock;
            $isOutOfStock = $availableStock <= 0;
            $isQuantityExceedStock = $item->quantity > $availableStock;
            $isQuantityBelowMin = $item->quantity < $item->product->minimum_purchase;
            @endphp
            <div class="cart-item-box" style="{{ $isOutOfStock || $isQuantityBelowMin ? 'opacity: 0.7;' : '' }}">
                <input type="checkbox" class="cart-item-checkbox" name="checked_items[]" value="{{ $item->cart_item_id }}" onchange="updateSummary()" checked {{ $isOutOfStock || $isQuantityBelowMin ? 'disabled' : '' }}>
                
                @if($item->product->gambar)
                <img src="{{ asset('images/' . $item->product->gambar) }}" alt="{{ $item->product->product_name }}" class="cart-item-image">
                @else
                <div class="cart-item-image">
                    <i class="fas fa-seedling"></i>
                </div>
                @endif
                
                <div class="cart-item-content">
                    <div class="cart-item-name">
                        <a href="/produk/{{ $item->product->product_id }}" style="color:#222; text-decoration:none;">
                            {{ $item->product->product_name }}
                        </a>
                    </div>
                    
                    @if($isOutOfStock)
                    <div style="color:#d32f2f;font-weight:500;font-size:0.9rem;margin-bottom:4px;">
                        <i class="fas fa-exclamation-triangle"></i> Stok habis
                    </div>
                    @elseif($isQuantityExceedStock)
                    <div style="color:#d32f2f;font-size:12px;">
                        <i class="fas fa-exclamation-triangle"></i> Stok tidak mencukupi (maks: {{ $availableStock }} {{ $item->product->unit }})
                    </div>
                    @elseif($isQuantityBelowMin)
                    <div style="color:#d32f2f;font-size:12px;">
                        <i class="fas fa-exclamation-triangle"></i> Minimal pembelian: {{ number_format($item->product->minimum_purchase, 0, ',', '') }} {{ $item->product->unit }}
                    </div>
                    @endif
                    
                    <div class="cart-item-price-qty">
                        Rp{{ number_format($item->price_per_unit,0,',','.') }} x
                        <input type="text" id="qtyInput{{ $item->cart_item_id }}" name="quantity" value="{{ $item->quantity }}" min="{{ $item->product->minimum_purchase }}" max="{{ $availableStock }}" class="cart-item-qty-input" onchange="updateQtyDirect({{ $item->cart_item_id }}, {{ $item->product->minimum_purchase }})" {{ $isOutOfStock || $isQuantityBelowMin ? 'disabled' : '' }}>
                        <span style="margin-left:4px;">{{ $item->product->unit }}</span>
                    </div>
                    
                    <div class="cart-item-subtotal">
                        Subtotal: Rp<span class="item-subtotal" id="subtotal{{ $item->cart_item_id }}">{{ number_format($item->price_per_unit * $item->quantity,0,',','.') }}</span>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('cart.delete', $item->cart_item_id) }}" style="margin-left:10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-hapus">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </form>
            </div>
            @endforeach
            @endif
        </div>
        <div class="cart-summary">
            <div class="cart-summary-title">Ringkasan belanja</div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
                <span style="color:#666; font-size:16px;">Total</span>
                <span id="summaryTotal" style="color:#388e3c; font-size:20px; font-weight:700;">Rp{{ number_format($total,0,',','.') }}</span>
            </div>
            <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}" style="display:none;">
                @csrf
                <input type="hidden" name="checked_items" id="checkedItemsInput">
            </form>
            <button class="btn" id="checkoutBtn" type="button" disabled onclick="submitCheckout()">Beli</button>
        </div>
    </div>
</div>

    <!-- Mobile Checkout Bar -->
    <div class="checkout-bar">
        <div class="select-all-section">
            <input type="checkbox" id="checkAllMobile" class="select-all-checkbox" onchange="toggleAllMobile(this)">
            <span class="select-all-text">Pilih Semua</span>
        </div>
        <div class="total-section">
            <div class="total-price" id="mobileTotalPrice">Rp{{ number_format($total,0,',','.') }}</div>
        </div>
        <button class="checkout-btn" id="mobileCheckoutBtn" onclick="submitCheckoutMobile()">
            Beli ({{ $items->count() }})
        </button>
    </div>
</div>

@include('customer.partials.modal_tambah_alamat')

<script>
// Helper untuk localStorage
function getCheckedCartItems() {
    try {
        return JSON.parse(localStorage.getItem('checkedCartItems') || '[]');
    } catch (e) {
        return [];
    }
}

function setCheckedCartItems(ids) {
    localStorage.setItem('checkedCartItems', JSON.stringify(ids));
}

function updateSummary() {
    let checkboxes = document.querySelectorAll('.cart-item-checkbox');
    let total = 0;
    let checkedCount = 0;
    let allChecked = true;
    let checkedIds = [];
    let hasInvalidItems = false;
    
    checkboxes.forEach(cb => {
        if (cb.checked) {
            let id = cb.value;
            let subtotalText = document.getElementById('subtotal'+id)?.innerText;
            if (subtotalText) {
                let subtotal = parseInt(subtotalText.replace(/[^\d]/g, ''));
                total += isNaN(subtotal) ? 0 : subtotal;
            }
            checkedCount++;
            checkedIds.push(id);
            
            if (cb.disabled) {
                hasInvalidItems = true;
            }
        } else {
            allChecked = false;
        }
    });
    
    setCheckedCartItems(checkedIds);
    
    // Update both desktop and mobile totals
    const summaryTotal = document.getElementById('summaryTotal');
    const mobileTotalPrice = document.getElementById('mobileTotalPrice');
    
    if (summaryTotal) {
        summaryTotal.innerText = 'Rp' + total.toLocaleString('id-ID');
    }
    if (mobileTotalPrice) {
        mobileTotalPrice.innerText = 'Rp' + total.toLocaleString('id-ID');
    }
    
    const checkoutBtn = document.getElementById('checkoutBtn');
    const mobileCheckoutBtn = document.getElementById('mobileCheckoutBtn');
    
    if (checkoutBtn) {
        checkoutBtn.disabled = checkedCount === 0 || hasInvalidItems;
        if (checkedCount > 0 && !hasInvalidItems) {
            checkoutBtn.classList.add('btn-active');
        } else {
            checkoutBtn.classList.remove('btn-active');
        }
    }
    
    if (mobileCheckoutBtn) {
        mobileCheckoutBtn.disabled = checkedCount === 0 || hasInvalidItems;
        mobileCheckoutBtn.textContent = `Beli (${checkedCount})`;
    }
    
    // Sinkronisasi checkbox 'Pilih Semua'
    const checkAll = document.getElementById('checkAll');
    const checkAllMobile = document.getElementById('checkAllMobile');
    
    if (checkAll) {
        checkAll.checked = allChecked && checkboxes.length > 0;
        checkAll.indeterminate = !allChecked && checkedCount > 0;
    }
    
    if (checkAllMobile) {
        checkAllMobile.checked = allChecked && checkboxes.length > 0;
        checkAllMobile.indeterminate = !allChecked && checkedCount > 0;
    }
}

function toggleAll(source) {
    let checkboxes = document.querySelectorAll('.cart-item-checkbox');
    checkboxes.forEach(cb => { cb.checked = source.checked; });
    updateSummary();
}

function updateSummaryMobile() {
    let checkboxes = document.querySelectorAll('.mobile-cart-checkbox');
    let total = 0;
    let checkedCount = 0;
    let allChecked = true;
    let checkedIds = [];
    let hasInvalidItems = false;
    
    checkboxes.forEach(cb => {
        if (cb.checked) {
            let id = cb.value;
            // Untuk mobile, kita hitung berdasarkan harga per unit dan quantity yang sebenarnya
            let pricePerUnit = 50000; // Harga per unit
            let quantityInput = document.querySelector(`.mobile-qty-input[onchange*="${id}"]`);
            let quantity = quantityInput ? parseFloat(quantityInput.value) || 1 : 1;
            let subtotal = pricePerUnit * quantity;
            total += subtotal;
            checkedCount++;
            checkedIds.push(id);
            
            if (cb.disabled) {
                hasInvalidItems = true;
            }
        } else {
            allChecked = false;
        }
    });
    
    // Update mobile total
    const mobileTotalPrice = document.getElementById('mobileTotalPrice');
    if (mobileTotalPrice) {
        mobileTotalPrice.innerText = 'Rp' + total.toLocaleString('id-ID');
    }
    
    const mobileCheckoutBtn = document.getElementById('mobileCheckoutBtn');
    if (mobileCheckoutBtn) {
        mobileCheckoutBtn.disabled = checkedCount === 0 || hasInvalidItems;
        mobileCheckoutBtn.textContent = `Beli (${checkedCount})`;
    }
    
    // Sinkronisasi checkbox 'Pilih Semua' mobile
    const checkAllMobile = document.getElementById('checkAllMobile');
    if (checkAllMobile) {
        checkAllMobile.checked = allChecked && checkboxes.length > 0;
        checkAllMobile.indeterminate = !allChecked && checkedCount > 0;
    }
}

function toggleAllMobile(source) {
    let checkboxes = document.querySelectorAll('.mobile-cart-checkbox');
    checkboxes.forEach(cb => { cb.checked = source.checked; });
    updateSummaryMobile();
}



function deleteItem(cartItemId) {
    if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
        fetch(`{{ url('/cart/delete') }}/${cartItemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus item');
        });
    }
}





function updateQtyMobile(cartItemId, minimalPembelian) {
    let input = document.querySelector(`.mobile-qty-input[onchange*="${cartItemId}"]`);
    if (!input) return;
    
    let val = input.value.replace(',', '.');
    let qty;
    
    // Untuk mobile, kita gunakan logic yang sama dengan desktop
    qty = parseFloat(val);
    if (isNaN(qty) || qty < minimalPembelian) {
        qty = minimalPembelian;
        input.value = qty;
        alert('Minimal pembelian: ' + minimalPembelian.toLocaleString('id-ID'));
    }
    
    let formData = new FormData();
    formData.append('quantity', qty);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch(`{{ url('/cart/update-qty') }}/${cartItemId}`, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            input.value = data.quantity;
            updateSummaryMobile();
        } else {
            alert(data.message || 'Terjadi kesalahan saat mengupdate quantity');
            input.value = minimalPembelian;
            updateSummaryMobile();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate quantity');
        input.value = minimalPembelian;
        updateSummaryMobile();
    });
}

function updateQtyDirect(cartItemId, minimalPembelian) {
    let input = document.getElementById('qtyInput'+cartItemId);
    if (!input) return;
    
    let val = input.value.replace(',', '.');
    let unit = input.nextElementSibling ? input.nextElementSibling.innerText.trim() : '';
    let qty;
    
    if (["Mata", "Tanaman", "Rizome"].includes(unit)) {
        qty = parseInt(val);
        if (isNaN(qty) || qty < minimalPembelian) {
            qty = minimalPembelian;
            input.value = qty;
            alert('Minimal pembelian: ' + minimalPembelian.toLocaleString('id-ID') + ' ' + unit);
        }
    } else {
        qty = parseFloat(val);
        if (isNaN(qty) || qty < minimalPembelian) {
            qty = minimalPembelian;
            input.value = qty;
            alert('Minimal pembelian: ' + minimalPembelian.toLocaleString('id-ID') + ' ' + unit);
        }
    }
    
    let formData = new FormData();
    formData.append('quantity', qty);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch(`{{ url('/cart/update-qty') }}/${cartItemId}`, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            input.value = data.quantity;
            document.getElementById('subtotal'+cartItemId).innerText = data.subtotal;
            updateSummary();
        } else {
            alert(data.message || 'Terjadi kesalahan saat mengupdate quantity');
            input.value = minimalPembelian;
            updateSummary();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate quantity');
        input.value = minimalPembelian;
        updateSummary();
    });
}

function submitCheckout() {
    if (document.getElementById('checkoutBtn')?.disabled) return;
    
    let checkedItems = Array.from(document.querySelectorAll('.cart-item-checkbox:checked')).map(cb => cb.value);
    if (checkedItems.length === 0) {
        alert('Pilih minimal satu barang untuk checkout');
        return;
    }
    
    let hasAddress = @json($hasAddress);
    if (!hasAddress) {
        var modal = new bootstrap.Modal(document.getElementById('modalTambahAlamat'));
        modal.show();
        return;
    }
    
    document.getElementById('checkedItemsInput').value = JSON.stringify(checkedItems);
    document.getElementById('checkoutForm').submit();
}

function submitCheckoutMobile() {
    let checkedItems = Array.from(document.querySelectorAll('.mobile-cart-checkbox:checked')).map(cb => cb.value);
    if (checkedItems.length === 0) {
        alert('Pilih minimal satu barang untuk checkout');
        return;
    }
    
    let hasAddress = @json($hasAddress);
    if (!hasAddress) {
        var modal = new bootstrap.Modal(document.getElementById('modalTambahAlamat'));
        modal.show();
        return;
    }
    
    // Create and submit form for mobile
    let form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("checkout.process") }}';
    
    let csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    
    let itemsInput = document.createElement('input');
    itemsInput.type = 'hidden';
    itemsInput.name = 'checked_items';
    itemsInput.value = JSON.stringify(checkedItems);
    
    form.appendChild(csrfInput);
    form.appendChild(itemsInput);
    document.body.appendChild(form);
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    // Set status checkbox sesuai localStorage
    let checkedIds = getCheckedCartItems();
    let checkboxes = document.querySelectorAll('.cart-item-checkbox');
    if (checkedIds.length > 0) {
        checkboxes.forEach(cb => {
            cb.checked = checkedIds.includes(cb.value);
        });
    }
    
    updateSummary();
    
         checkboxes.forEach(cb => {
         cb.addEventListener('change', updateSummary);
     });
     
     // Event listener untuk checkbox mobile
     let mobileCheckboxes = document.querySelectorAll('.mobile-cart-checkbox');
     mobileCheckboxes.forEach(cb => {
         cb.addEventListener('change', updateSummaryMobile);
     });
    
    document.getElementById('checkAll')?.addEventListener('change', function() {
        toggleAll(this);
    });
    
    document.getElementById('checkAllMobile')?.addEventListener('change', function() {
        toggleAllMobile(this);
    });
});
</script>

@section('after_content')
    @include('customer.partials.mitra_footer')
@endsection
@endsection 