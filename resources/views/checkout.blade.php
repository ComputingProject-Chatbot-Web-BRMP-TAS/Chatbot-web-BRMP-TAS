@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
<style>
    body {
        background: #f8f9fa;
    }
    .checkout-main {
        width: 100%;
        margin: 40px auto 0 auto;
        display: flex;
        gap: 32px;
        align-items: flex-start;
    }
    .checkout-left {
        flex: 2;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }
    .checkout-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 24px;
        color: #222;
        margin-top: 60px;
        margin-bottom: 32px;
    }
    .checkout-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        padding: 28px 24px;
        margin-bottom: 24px;
    }
    .checkout-summary {
        flex: 1;
        background: #fff;
        border-radius: 18px;
        padding: 28px 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        min-width: 320px;
    }
    .checkout-summary-title {
        font-weight: 600;
        margin-bottom: 18px;
        font-size: 1.2rem;
    }
    .checkout-summary .btn {
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
    .checkout-summary .btn:disabled {
        background: #eee;
        color: #bbb;
    }
    .order-item-img {
        width: 48px;
        height: 48px;
        background: #eaffea;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .order-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .order-item-info {
        margin-left: 12px;
    }
    .order-item-name {
        font-weight: 600;
        font-size: 1.05rem;
        color: #222;
    }
    .order-item-price {
        color: #388e3c;
        font-size: 0.98rem;
        font-weight: 500;
    }
    .order-item-row {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    .order-item-sub {
        display: flex;
        justify-content: space-between;
        font-size: 0.98rem;
        margin-bottom: 8px;
    }
    .checkout-section-title {
        font-size: 1.15rem;
        font-weight: 600;
        margin-bottom: 12px;
        color: #388e3c;
    }
    .address-card-clickable {
        cursor: pointer;
        transition: box-shadow 0.2s, border 0.2s;
        border: 2px solid transparent;
    }
    .address-card-clickable:hover {
        box-shadow: 0 4px 16px rgba(76,175,80,0.10);
        border: 2px solid #4CAF50;
        background: #f6fff6;
    }
    .address-card-primary {
        border: 2px solid #4CAF50;
        background: #f6fff6;
    }
    @media (max-width: 900px) {
        .checkout-main {
            flex-direction: column;
            gap: 0;
            width: 100%;
            padding: 0 12px;
        }
        .checkout-summary {
            margin-top: 24px;
            min-width: unset;
        }
        .checkout-left {
            width: 100%;
        }
        .checkout-summary {
            width: 100%;
        }
    }
</style>
<div class="container py-4">
    <div class="checkout-title">Checkout</div>
    <div class="checkout-main">
        <div class="checkout-left">
            <div class="checkout-card">
                <div class="checkout-section-title">Alamat Pengiriman</div>
                @if($address)
                    <div class="fw-bold">{{ $address->address ?? '-' }}</div>
                    <div>{{ $address->recipient_name ?? '-' }}</div>
                    <div>{{ $address->recipient_phone ?? '-' }}</div>
                    @if(!empty($address->note))
                        <div class="text-muted"><small>Catatan: {{ $address->note }}</small></div>
                    @endif
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalGantiAlamat">Ganti</button>
                @else
                    <div class="text-muted">Belum ada alamat utama</div>
                    <a href="{{ route('addresses') }}" class="btn btn-sm btn-success mt-2">Tambah Alamat</a>
                @endif
            </div>
            <div class="checkout-card">
                <div class="checkout-section-title">Pengiriman</div>
                <div>Pilih metode pengiriman</div>
                <form class="mt-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="shipping_method" id="shipping_standard" value="standard" checked>
                        <label class="form-check-label" for="shipping_standard">
                            Standard
                            <div style="font-size:0.95em;color:#888;font-weight:400;">Estimasi: 2-4 hari</div>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="shipping_method" id="shipping_kargo" value="kargo">
                        <label class="form-check-label" for="shipping_kargo">
                            Kargo
                            <div style="font-size:0.95em;color:#888;font-weight:400;">Estimasi: 3-7 hari</div>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="shipping_method" id="shipping_reguler" value="reguler">
                        <label class="form-check-label" for="shipping_reguler">
                            Reguler
                            <div style="font-size:0.95em;color:#888;font-weight:400;">Estimasi: 2-5 hari</div>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="shipping_method" id="shipping_instant" value="instant">
                        <label class="form-check-label" for="shipping_instant">
                            Instant
                            <div style="font-size:0.95em;color:#888;font-weight:400;">Estimasi: &lt; 3 jam</div>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="shipping_method" id="shipping_sameday" value="sameday">
                        <label class="form-check-label" for="shipping_sameday">
                            Same Day
                            <div style="font-size:0.95em;color:#888;font-weight:400;">Estimasi: Hari yang sama</div>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="shipping_method" id="shipping_ekonomi" value="ekonomi">
                        <label class="form-check-label" for="shipping_ekonomi">
                            Ekonomi
                            <div style="font-size:0.95em;color:#888;font-weight:400;">Estimasi: 4-8 hari</div>
                        </label>
                    </div>
                </form>
                <div class="mt-2" style="color:#388e3c;">
                    <i class="bi bi-shield-check"></i> Aman dengan Garansi Pembelian
                </div>
            </div>
            <div class="checkout-card">
                <div class="checkout-section-title">Metode Pembayaran</div>
                <div>Unggah Foto Bukti Pembayaran</div>
                <form class="mt-3" enctype="multipart/form-data" method="POST" action="{{ route('payment.upload_proof') }}">
                    @csrf
                    <div class="mb-3">
                        <input class="form-control" type="file" id="buktiPembayaran" name="bukti_pembayaran" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-success">Unggah Bukti Pembayaran</button>
                </form>
            </div>
        </div>
        <div class="checkout-summary">
            <div class="checkout-summary-title">Ringkasan Pesanan</div>
            @if(count($cart) > 0)
                @foreach($cart as $item)
                <div class="order-item-row">
                    <div class="order-item-img">
                        @if($item['image'])
                            <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}">
                        @endif
                    </div>
                    <div class="order-item-info">
                        <div class="order-item-name">{{ $item['name'] }}</div>
                        <div class="order-item-price">Rp{{ number_format($item['price'],0,',','.') }}</div>
                    </div>
                </div>
                <div class="order-item-sub">
                    <span>{{ $item['qty'] }} item</span>
                    <span>Rp{{ number_format($item['subtotal'],0,',','.') }}</span>
                </div>
                @endforeach
            @else
                <div class="text-muted">Tidak ada item untuk checkout</div>
            @endif
            <div class="order-item-sub">
                <span>Pengiriman</span>
                <span class="text-muted">Di tahap selanjutnya</span>
            </div>
            <hr>
            <div class="order-item-sub" style="font-weight:700;">
                <span>Total</span>
                <span>Rp{{ number_format($total,0,',','.') }}</span>
            </div>
            <form action="{{ route('checkout.next') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn">Pilih pembayaran <i class="bi bi-chevron-right"></i></button>
            </form>
        </div>
    </div>
</div>
@include('partials.modal_tambah_alamat')
@include('partials.modal_edit_alamat')
<!-- Modal Ganti Alamat -->
<div class="modal fade" id="modalGantiAlamat" tabindex="-1" aria-labelledby="modalGantiAlamatLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="margin-top: 60px;">
      <div class="modal-header">
        <h5 class="modal-title" id="modalGantiAlamatLabel">Pilih Alamat Pengiriman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-success w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahAlamat">+ Tambah Alamat Baru</button>
        <!-- Daftar alamat, ganti dengan loop data alamat user -->
        @php
            $selectedId = session('checkout_address_id') ?? ($addresses->firstWhere('is_primary', 1)->id ?? null);
        @endphp
        @if(isset($addresses) && count($addresses) > 0)
            <div class="mt-2 w-100">
                @foreach($addresses as $address)
                    <div class="mb-2 position-relative">
                        <div class="card @if($selectedId == $address->id) address-card-primary @else address-card-clickable @endif" style="border-radius:12px;box-shadow:0 1px 6px rgba(0,0,0,0.04);cursor:pointer;">
                            <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                                <div style="flex:1;">
                                    <form id="formPilihAlamat{{ $address->id }}" method="POST" action="{{ route('checkout.set_address', $address->id) }}">
                                        @csrf
                                        <div onclick="document.getElementById('formPilihAlamat{{ $address->id }}').submit();" style="cursor:pointer;">
                                            @if($address->is_primary)
                                                <span class="badge bg-success mb-2">Utama</span><br>
                                            @endif
                                            <div class="fw-bold" style="font-size:1.1em;">{{ $address->label ?? 'Alamat' }}</div>
                                            <div style="color:#555;font-size:0.98em;">{{ $address->address }}</div>
                                            @if($address->latitude && $address->longitude)
                                                <div style="color:#888;font-size:0.93em;">({{ $address->latitude }}, {{ $address->longitude }})</div>
                                            @endif
                                            @if($address->note)
                                                <div style="color:#888;font-size:0.93em;">Catatan: {{ $address->note }}</div>
                                            @endif
                                            <div style="color:#888;font-size:0.93em;">Penerima: {{ $address->recipient_name }} ({{ $address->recipient_phone }})</div>
                                        </div>
                                    </form>
                                </div>
                                <div class="d-flex gap-1 align-items-start">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="editAlamat(event)"
                                        data-id="{{ $address->id }}"
                                        data-label="{{ $address->label }}"
                                        data-address="{{ $address->address }}"
                                        data-latitude="{{ $address->latitude }}"
                                        data-longitude="{{ $address->longitude }}"
                                        data-note="{{ $address->note }}"
                                        data-recipient_name="{{ $address->recipient_name }}"
                                        data-recipient_phone="{{ $address->recipient_phone }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditAlamat">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    @if(!$address->is_primary)
                                        <form method="POST" action="{{ route('addresses.destroy', $address) }}" onsubmit="return confirm('Hapus alamat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-muted">Belum ada alamat lain.</div>
        @endif
      </div>
    </div>
  </div>
</div>

<script>
// Buat instance modalEditAlamat secara global hanya sekali
window.modalEditAlamatInstance = null;

document.addEventListener('DOMContentLoaded', function() {
    var modalEditAlamatEl = document.getElementById('modalEditAlamat');
    if (modalEditAlamatEl) {
        window.modalEditAlamatInstance = new bootstrap.Modal(modalEditAlamatEl);
        // Reset ke step 2 saat modal ditutup (opsional, jika ingin reset tampilan)
        modalEditAlamatEl.addEventListener('hidden.bs.modal', function () {
            document.getElementById('editStep1Alamat').style.display = 'none';
            document.getElementById('editStep2Alamat').style.display = 'block';
        });
    }
});

function editAlamat(e) {
    e.stopPropagation();
    var btn = event.currentTarget;
    document.getElementById('editLabelInput').value = btn.getAttribute('data-label') || '';
    document.getElementById('editAlamatTerpilihInput').value = btn.getAttribute('data-address') || '';
    document.getElementById('editNoteInput').value = btn.getAttribute('data-note') || '';
    document.getElementById('editRecipientNameInput').value = btn.getAttribute('data-recipient_name') || '';
    document.getElementById('editRecipientPhoneInput').value = btn.getAttribute('data-recipient_phone') || '';
    document.getElementById('editLatitudeInput').value = btn.getAttribute('data-latitude') || '';
    document.getElementById('editLongitudeInput').value = btn.getAttribute('data-longitude') || '';
    document.getElementById('editAlamatTerpilih').innerText = btn.getAttribute('data-address') || 'Pilih lokasi di peta';
    document.getElementById('formEditAlamat').action = '/addresses/' + btn.getAttribute('data-id');
    document.getElementById('editStep1Alamat').style.display = 'none';
    document.getElementById('editStep2Alamat').style.display = 'block';
    // Tutup modal ganti alamat sebelum buka modal edit
    var modalGanti = bootstrap.Modal.getInstance(document.getElementById('modalGantiAlamat'));
    if (modalGanti) modalGanti.hide();
    if (window.modalEditAlamatInstance) {
        window.modalEditAlamatInstance.show();
    }
}
</script>
@endsection
