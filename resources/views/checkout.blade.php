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
                <div class="mt-2" style="color:#388e3c;">
                    <i class="bi bi-shield-check"></i> Aman dengan Garansi Pembelian
                </div>
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
<!-- Modal Ganti Alamat -->
<div class="modal fade" id="modalGantiAlamat" tabindex="-1" aria-labelledby="modalGantiAlamatLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
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
                    <form method="POST" action="{{ route('checkout.set_address', $address->id) }}">
                        @csrf
                        <div class="mb-2 position-relative">
                            <div class="card @if($selectedId == $address->id) address-card-primary @else address-card-clickable @endif" style="border-radius:12px;box-shadow:0 1px 6px rgba(0,0,0,0.04);cursor:pointer;" onclick="this.closest('form').submit();">
                                <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                                    <div style="flex:1;">
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
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        @else
            <div class="text-muted">Belum ada alamat lain.</div>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection
