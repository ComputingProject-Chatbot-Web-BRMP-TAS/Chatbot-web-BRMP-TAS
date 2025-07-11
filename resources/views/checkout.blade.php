@extends('layouts.app')

@section('content')
<div class="container py-4 mt-5" style="max-width: 1100px; margin-top: 40px;">
    <div class="row">
        <div class="col-md-7">
            <h3 class="fw-bold mb-3">Alamat</h3>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="fw-semibold">{{ $address->recipient_name ?? '-' }}</div>
                    <div>{{ $address->phone ?? '-' }}</div>
                    <div class="text-muted">{{ $address->full_address ?? '-' }}</div>
                </div>
            </div>
            <h3 class="fw-bold mb-3">Pengiriman</h3>
            <div class="card mb-4">
                <div class="card-body">
                    Pilih metode pengiriman
                </div>
            </div>
            <div class="mb-3" style="color:#388e3c;">
                <i class="bi bi-shield-check"></i> Aman dengan Garansi Pembelian
            </div>
            <form action="{{ route('checkout.next') }}" method="POST">
                @csrf
                <button type="submit" class="btn w-100" style="background:#f4f5f6; color:#222; font-weight:700; font-size:1.1rem;">Pilih pembayaran <i class="bi bi-chevron-right"></i></button>
            </form>
        </div>
        <div class="col-md-5">
            <div class="fw-bold" style="font-size:1.2rem;">Order</div>
            @foreach($cart as $item)
            <div class="d-flex align-items-center mt-2 mb-2">
                <div style="width:48px;height:48px;background:#eaffea;border-radius:8px;overflow:hidden;"></div>
                <div class="ms-2">
                    <div class="fw-semibold">{{ $item['name'] }}</div>
                    <div class="text-muted" style="font-size:0.95rem;">Rp{{ number_format($item['price'],0,',','.') }}</div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <span>{{ $item['qty'] }} item</span>
                <span>Rp{{ number_format($item['price'] * $item['qty'],0,',','.') }}</span>
            </div>
            @endforeach
            <div class="d-flex justify-content-between">
                <span>Pengiriman</span>
                <span class="text-muted">Di tahap selanjutnya</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
                <span>Total</span>
                <span>Rp{{ number_format($total,0,',','.') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
