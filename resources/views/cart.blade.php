@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    body {
        background: #f8f9fa;
    }
    .cart-main {
        width: 100%;
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
        margin-bottom: 24px;
        color: #222;
        margin-top: 60px;
        margin-bottom: 32px;
    }
    .cart-item-box {
        background: #fff;
        border-radius: 18px;
        padding: 28px 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
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
        min-width: 320px;
    }
    .cart-summary-title {
        font-weight: 600;
        margin-bottom: 18px;
        font-size: 1.2rem;
    }
    .cart-summary .btn {
        width: 100%;
        border-radius: 8px;
        background: #388e3c;
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 12px;
        font-size: 1.1rem;
        margin-top: 18px;
    }
    .cart-summary .btn:disabled {
        background: #eee;
        color: #bbb;
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
    @media (max-width: 900px) {
        .cart-main {
            flex-direction: column;
            gap: 0;
            width: 100%;
            padding: 0 12px;
        }
        .cart-title {
            padding: 0 12px;
        }
        .cart-summary {
            margin-top: 24px;
            min-width: unset;
        }
        .cart-left {
            width: 100%;
        }
        .cart-summary {
            width: 100%;
        }
    }
</style>
<div class="container py-4">
    <div class="cart-title">
        Keranjang
        <span style="font-size:1.1rem;font-weight:600;color:#388e3c;margin-left:10px;">
            ({{ $items->count() }} Benih)
        </span>
    </div>
    <div class="cart-main">
        <div class="cart-left">
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
                @foreach($items as $item)
                <div class="cart-item-box">
                    <input type="checkbox" class="cart-item-checkbox" name="checked_items[]" value="{{ $item->cart_item_id }}" onchange="updateSummary()" checked>
                    <img src="{{ asset('images/' . $item->product->gambar) }}" alt="{{ $item->product->nama }}" style="width:70px;height:70px;object-fit:cover;border-radius:12px;">
                    <div style="flex:1;">
                        <div style="font-weight:600;font-size:1.1rem;">
                            <a href="/produk/{{ $item->product->produk_id }}" style="color:#222; text-decoration:none; font-weight:600;">
                                {{ $item->product->nama }}
                            </a>
                        </div>
                        <div style="color:#388e3c;font-weight:500;display:flex;align-items:center;gap:8px;">
                            Rp{{ number_format($item->harga_satuan,0,',','.') }} x
                            <input type="text" id="qtyInput{{ $item->cart_item_id }}" name="kuantitas" value="{{ $item->kuantitas }}" min="{{ $item->product->minimal_pembelian }}" style="width:48px;text-align:center;background:#fff;border:1.5px solid #bfc9d1;font-weight:600;border-radius:6px;" onchange="updateQtyDirect({{ $item->cart_item_id }}, {{ $item->product->minimal_pembelian }})">
                            <span style="margin-left:4px;">{{ $item->product->satuan }}</span>
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
@include('partials.modal_tambah_alamat')
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
    checkboxes.forEach(cb => {
        if (cb.checked) {
            let id = cb.value;
            let subtotalText = document.getElementById('subtotal'+id).innerText;
            let subtotal = parseInt(subtotalText.replace(/[^\d]/g, ''));
            total += isNaN(subtotal) ? 0 : subtotal;
            checkedCount++;
            checkedIds.push(id);
        } else {
            allChecked = false;
        }
    });
    setCheckedCartItems(checkedIds);
    document.getElementById('summaryTotal').innerText = 'Rp' + total.toLocaleString('id-ID');
    const checkoutBtn = document.getElementById('checkoutBtn');
    checkoutBtn.disabled = checkedCount === 0;
    if (checkedCount > 0) {
        checkoutBtn.classList.add('btn-active');
    } else {
        checkoutBtn.classList.remove('btn-active');
    }
    // Sinkronisasi checkbox 'Pilih Semua'
    const checkAll = document.getElementById('checkAll');
    if (checkAll) {
        checkAll.checked = allChecked && checkboxes.length > 0;
        checkAll.indeterminate = !allChecked && checkedCount > 0;
    }
}

function toggleAll(source) {
    let checkboxes = document.querySelectorAll('.cart-item-checkbox');
    checkboxes.forEach(cb => { cb.checked = source.checked; });
    updateSummary();
}
function updateQtyDirect(cartItemId, minimalPembelian) {
    let input = document.getElementById('qtyInput'+cartItemId);
    let val = input.value.replace(',', '.');
    let satuan = input.nextElementSibling ? input.nextElementSibling.innerText.trim() : '';
    let qty;
    if (["Mata", "Tanaman", "Rizome"].includes(satuan)) {
        qty = parseInt(val);
        if (isNaN(qty) || qty < minimalPembelian) qty = minimalPembelian;
        input.value = qty;
    } else {
        qty = parseFloat(val);
        if (isNaN(qty) || qty < minimalPembelian) qty = minimalPembelian;
        input.value = qty;
    }
    let formData = new FormData();
    formData.append('kuantitas', qty);
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
function submitCheckout() {
    if (document.getElementById('checkoutBtn').disabled) return;
    // Ambil semua item yang dicentang
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
    // Set nilai ke hidden input
    document.getElementById('checkedItemsInput').value = JSON.stringify(checkedItems);
    // Submit form
    document.getElementById('checkoutForm').submit();
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
    document.getElementById('checkAll')?.addEventListener('change', function() {
        toggleAll(this);
    });
});
</script>
@section('after_content')
    @include('partials.mitra_footer')
@endsection
@endsection
