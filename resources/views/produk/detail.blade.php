@extends('layouts.app')

@section('content')
<div class="product-detail-modern-bg">
    <div class="product-detail-modern-container">
        <div class="product-detail-modern-left">
            <div class="product-detail-main-image-wrapper">
                <img src="{{ asset('images/' . $product->gambar1) }}" alt="{{ $product->nama }}" class="product-detail-main-image">
            </div>
            <div class="product-detail-thumbs">
                <img src="{{ asset('images/' . $product->gambar1) }}" alt="thumb1" class="selected">
                @if($product->gambar2)
                    <img src="{{ asset('images/' . $product->gambar2) }}" alt="thumb2">
                @endif
                @if($product->gambar_certificate)
                    <img src="{{ asset('images/' . $product->gambar_certificate) }}" alt="certificate">
                @endif
            </div>
        </div>
        <div class="product-detail-modern-center">
            <div class="product-detail-title">{{ $product->nama }}</div>
            <div class="product-detail-price">Rp{{ number_format($product->harga_per_satuan, 0, ',', '.') }} / {{ $product->satuan }}</div>
            <div class="product-detail-stock">Stok: {{ $product->stok - $product->stok_minimal }} {{ $product->satuan }}</div>
            <div class="product-detail-info-list">
                <div><span class="label">Kategori:</span> <span class="value">{{ $product->jenis_kategori }}</span></div>
            </div>
            <div class="product-detail-desc">{{ $product->deskripsi }}</div>
        </div>
        <div class="product-detail-modern-right">
            <div class="product-detail-card">
                <div class="product-detail-card-title">Atur jumlah dan catatan</div>
                <form method="POST" action="{{ Auth::check() ? route('cart.add', $product->produk_id) : route('login') }}">
                    @csrf
                    <div class="product-detail-card-qty">
                        <input type="text" id="qtyInput" name="kuantitas" value="{{ $product->minimal_pembelian }}" min="{{ $product->minimal_pembelian }}" style="width:60px;text-align:center;background:#fff;">
                        <span style="margin-left:8px;">{{ $product->satuan }}</span>
                    </div>
                    <div id="stockWarning" style="color:#d32f2f;font-size:0.98rem;display:none;margin-bottom:8px;">Stok tidak mencukupi</div>
                    <div class="product-detail-card-subtotal">
                        Subtotal
                        <span id="subtotal">Rp{{ number_format($product->harga_per_satuan, 0, ',', '.') }}</span>
                    </div>
                    <button class="btn-green w-100" style="margin-bottom:10px;" type="submit">+ Keranjang</button>
                </form>
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
function updateSubtotal() {
    let qty = parseFloat(document.getElementById('qtyInput').value.replace(',', '.')) || 0;
    let harga = {{ $product->harga_per_satuan }};
    document.getElementById('subtotal').innerText = 'Rp' + (harga * qty).toLocaleString('id-ID');
}

const satuanProduk = @json($product->satuan);
const qtyInput = document.getElementById('qtyInput');
const minimalPembelian = {{ $product->minimal_pembelian }};

if (["Mata", "Tanaman", "Rizome"].includes(satuanProduk)) {
    qtyInput.setAttribute('type', 'number');
    qtyInput.setAttribute('step', '1');
    qtyInput.setAttribute('min', minimalPembelian);
    qtyInput.addEventListener('input', function(e) {
        // Hanya izinkan integer positif >= minimal pembelian, tapi biarkan kosong
        let val = this.value.replace(/[^0-9]/g, '');
        if (val !== "") {
            val = parseInt(val, 10);
            if (val < minimalPembelian) val = minimalPembelian;
            this.value = val;
        }
        updateSubtotal();
    });
    qtyInput.addEventListener('blur', function(e) {
        if (this.value === "") {
            this.value = minimalPembelian;
            updateSubtotal();
        }
    });
} else {
    qtyInput.setAttribute('min', minimalPembelian);
    qtyInput.addEventListener('input', function(e) {
        updateSubtotal();
    });
    qtyInput.addEventListener('blur', function(e) {
        let val = this.value.replace(',', '.');
        if (val === "" || isNaN(val)) {
            this.value = minimalPembelian;
        } else {
            val = parseFloat(val);
            if (val < minimalPembelian) val = minimalPembelian;
            this.value = val;
        }
        updateSubtotal();
    });
}
// Jika ada tombol +/-, pastikan juga memanggil updateSubtotal setelah value berubah
</script>
@endpush 
@section('after_content')
    @include('partials.mitra_footer')
@endsection