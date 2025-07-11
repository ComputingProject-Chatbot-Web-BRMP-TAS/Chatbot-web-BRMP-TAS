@extends('layouts.app')

@section('content')
<div class="container py-4 mt-5" style="max-width: 1200px; margin-top: 40px;">
    <div class="row">
        <!-- LEFT: Payment Info -->
        <div class="col-md-7">
            <div class="text-center mb-5">
                <div class="mb-2" style="font-size:1.1rem;letter-spacing:1px;">
                    BAYAR SEBELUM {{ $deadline ?? '11 JULI 2025 PUKUL 22:46' }}
                </div>
                <div class="fw-bold" style="font-size:2.8rem;letter-spacing:2px;">
                    IDR {{ number_format($grand_total ?? 75725, 0, ',', '.') }}
                </div>
            </div>
            <div>
                <div class="mb-2 fw-bold" style="font-size:1.1rem;">METODE PEMBAYARAN</div>
                <div class="card p-3 mb-4" style="border-radius:12px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-qr-code fs-4 me-2"></i>
                            <span class="fw-semibold">Pembayaran QR</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-2">QRIS</span>
                            <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#qrCollapse">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="qrCollapse">
                        <div class="pt-3">
                            <!-- QRIS details or QR code here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- RIGHT: Order Summary -->
        <div class="col-md-5">
            <div class="card p-4" style="border-radius:12px;">
                <div class="fw-bold mb-2" style="font-size:1.2rem;">Ringkasan Pesanan</div>
                <div class="mb-2" style="font-size:0.98rem;">
                    <span class="text-muted">Transaksi #:</span> <b>{{ $transaction_number ?? '71996' }}</b>
                </div>
                <div class="mb-3" style="font-size:0.98rem;">
                    <i class="bi bi-clock"></i>
                    <span class="text-muted">Bayar sebelum</span>
                    <b>{{ $deadline ?? '11 Juli 2025 pukul 22:46' }}</b>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <div>
                        <b>{{ $product_name ?? 'Cardigan' }}</b>
                        <div style="font-size:0.95rem;">1 × IDR {{ number_format($product_price ?? 25000, 0, ',', '.') }}</div>
                    </div>
                    <div class="fw-bold">IDR {{ number_format($product_price ?? 25000, 0, ',', '.') }}</div>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-bold">IDR {{ number_format($subtotal ?? 25000, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Shipping</span>
                    <span>IDR {{ number_format($shipping ?? 50600, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Asuransi Pengiriman</span>
                    <span>IDR {{ number_format($insurance ?? 125, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-bold">Total Biaya</span>
                    <span class="fw-bold">IDR {{ number_format($total_biaya ?? 50725, 0, ',', '.') }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between" style="font-size:1.2rem;">
                    <span class="fw-bold">Jumlah Total</span>
                    <span class="fw-bold">IDR {{ number_format($grand_total ?? 75725, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
