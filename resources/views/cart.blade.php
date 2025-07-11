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
        margin: 0 2px;
        transition: background 0.2s, color 0.2s;
        box-shadow: 0 1px 4px rgba(76,175,80,0.07);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .qty-btn:hover {
        background: #E8F5E9;
        color: #222;
    }
    .btn-hapus {
        background: #fff;
        border: 1.5px solid #e57373;
        color: #e53935;
        border-radius: 8px;
        padding: 7px 16px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s, border 0.2s, color 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-hapus:hover {
        background: #ffebee;
        border-color: #e53935;
        color: #b71c1c;
    }
    .checkall-label {
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        user-select: none;
    }
    .checkall-box {
        accent-color: #4CAF50;
        width: 20px;
        height: 20px;
        border-radius: 5px;
        border: 2px solid #4CAF50;
        margin-right: 4px;
    }
    .cart-item-checkbox {
        accent-color: #4CAF50;
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
</style>

<div class="cart-main">
    <div class="cart-left">
        <div class="cart-title cart-title-margin">
            Keranjang
             <span style="font: size 1.5em;rem;font-weight:600;color:#388e3c;margin-left:10px;">
                ({{ $items->count() }} Benih)
            </span>
        </div> 
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
            <div style="margin-bottom:12px;display:flex;align-items:center;gap:12px;">
                <input type="checkbox" id="checkAll" class="checkall-box" onclick="toggleAll(this)">
                <label for="checkAll" class="checkall-label">Pilih Semua</label>
            </div>
            <form id="cartForm" method="POST" action="{{ route('cart.checkout') }}">
                @csrf
                @foreach($items as $item)
                <div class="cart-empty-box" style="flex-direction:row;align-items:center;gap:18px;">
                    <input type="checkbox" class="cart-item-checkbox" name="checked_items[]" value="{{ $item->cart_item_id }}" onchange="updateSummary()" checked>
                    <img src="{{ asset('images/' . $item->product->gambar) }}" alt="{{ $item->product->nama }}" style="width:70px;height:70px;object-fit:cover;border-radius:12px;">
                    <div style="flex:1;">
                        <div style="font-weight:600;font-size:1.1rem;">
                            <a href="/produk/{{ $item->product->produk_id }}" style="color:#222; text-decoration:none; font-weight:600;">
                                {{ $item->product->nama }}
                            </a>
                        </div>
                        <div style="color:#388e3c;font-weight:500;">
                            Rp{{ number_format($item->harga_satuan,0,',','.') }} x 
                            <form method="POST" action="{{ route('cart.update_qty', $item->cart_item_id) }}" style="display:inline;" onsubmit="return false;">
                                @csrf
                                <button type="button" class="qty-btn" onclick="changeQty({{ $item->cart_item_id }}, -1)"><i class="fas fa-minus"></i></button>
                                <input type="text" id="qtyInput{{ $item->cart_item_id }}" name="kuantitas" value="{{ $item->kuantitas }}" min="1" readonly style="width:32px;text-align:center;background:#fff;border:none;font-weight:600;">
                                <button type="button" class="qty-btn" onclick="changeQty({{ $item->cart_item_id }}, 1)"><i class="fas fa-plus"></i></button>
                            </form>
                        </div>
                        <div style="color:#757575;font-size:0.98rem;">Subtotal: Rp<span class="item-subtotal" id="subtotal{{ $item->cart_item_id }}">{{ number_format($item->harga_satuan * $item->kuantitas,0,',','.') }}</span></div>
                    </div>
                    <form method="POST" action="{{ route('cart.delete', $item->cart_item_id) }}" style="margin-left:10px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-hapus"><i class="fas fa-trash-alt"></i> Hapus</button>
                    </form>
                </div>
                @endforeach
            </form>
        @endif
    </div>
    <div class="cart-summary cart-summary-margin">
        <div class="cart-summary-title">Ringkasan belanja</div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
            <span style="color:#666; font-size:16px;">Total</span>
            <span id="summaryTotal" style="color:#388e3c; font-size:20px; font-weight:700;">Rp{{ number_format($total,0,',','.') }}</span>
        </div>
        <button class="btn" id="checkoutBtn" disabled>Beli</button>
    </div>
</div>
<script>
function updateSummary() {
    let checkboxes = document.querySelectorAll('.cart-item-checkbox');
    let total = 0;
    let checkedCount = 0;
    checkboxes.forEach(cb => {
        if (cb.checked) {
            let id = cb.value;
            let subtotal = document.getElementById('subtotal'+id).innerText.replace(/\D/g, '');
            total += parseInt(subtotal);
            checkedCount++;
        }
    });
    document.getElementById('summaryTotal').innerText = 'Rp' + total.toLocaleString('id-ID');
    const checkoutBtn = document.getElementById('checkoutBtn');
    checkoutBtn.disabled = checkedCount === 0;
    if (checkedCount > 0) {
        checkoutBtn.classList.add('btn-active');
    } else {
        checkoutBtn.classList.remove('btn-active');
    }
}
function toggleAll(source) {
    let checkboxes = document.querySelectorAll('.cart-item-checkbox');
    checkboxes.forEach(cb => { cb.checked = source.checked; });
    updateSummary();
}
function changeQty(cartItemId, delta) {
    let input = document.getElementById('qtyInput'+cartItemId);
    let qty = parseInt(input.value);
    if (qty + delta < 1) return;
    let formData = new FormData();
    formData.append('kuantitas', qty + delta);
    formData.append('_token', '{{ csrf_token() }}');
    fetch(`{{ url('/cart/update-qty') }}/${cartItemId}`, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            input.value = data.kuantitas;
            document.getElementById('subtotal'+cartItemId).innerText = data.subtotal;
            updateSummary();
        }
    });
}
document.addEventListener('DOMContentLoaded', function() {
    updateSummary();
    document.querySelectorAll('.cart-item-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSummary);
    });
    document.getElementById('checkAll')?.addEventListener('change', function() {
        toggleAll(this);
    });
});
</script>
@section('after_content')
    @include('partials.mitra_footer')
@endsection
@endsection