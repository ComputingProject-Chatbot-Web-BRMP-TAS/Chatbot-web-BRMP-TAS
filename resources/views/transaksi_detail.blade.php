@extends('layouts.app')

@section('content')
<style>
.transaksi-detail-container {
    max-width: 700px;
    margin: 100px auto 0 auto; /* Tambah margin-top agar tidak mepet Appbar */
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    padding: 32px 24px;
}
.transaksi-detail-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 18px;
    color: #222;
}
.transaksi-detail-info {
    margin-bottom: 18px;
    font-size: 1.08rem;
}
.transaksi-detail-status {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 8px;
    font-size: 0.98rem;
    font-weight: 600;
    background: #eaffea;
    color: #176a3a;
    border: 1.5px solid #176a3a;
    margin-left: 8px;
}
.transaksi-detail-table {
    width: 100%;
    margin-bottom: 18px;
    border-collapse: collapse;
}
.transaksi-detail-table th, .transaksi-detail-table td {
    padding: 10px 8px;
    border-bottom: 1px solid #f0f0f0;
    text-align: left;
}
.transaksi-detail-table th {
    background: #f8f9fa;
    font-weight: 600;
}
.transaksi-detail-total {
    font-weight: 700;
    color: #176a3a;
    font-size: 1.1rem;
    text-align: right;
    margin-top: 10px;
}
.transaksi-detail-payment {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 16px 18px;
    margin-top: 18px;
}
.transaksi-detail-payment img {
    max-width: 180px;
    border-radius: 8px;
    margin-top: 8px;
}
</style>
<div class="transaksi-detail-container">
    <a href="{{ route('transaksi') }}" class="btn btn-outline-success mb-3" style="border-radius:8px;font-weight:600;">
        &larr; Kembali ke Daftar Transaksi
    </a>
    <div class="transaksi-detail-title">Detail Transaksi #{{ $transaction->transaksi_id }}</div>
    <div class="transaksi-detail-info">
        <span><b>Tanggal:</b> {{ \Carbon\Carbon::parse($transaction->order_date)->format('d M Y H:i') }}</span>
        <span class="transaksi-detail-status">{{ $transaction->status }}</span>
    </div>
    <div class="mb-2"><b>Metode Pengiriman:</b> {{ $transaction->delivery_method }}</div>
    @if($transaction->estimated_delivery_date)
        <div class="mb-2"><b>Estimasi Tiba:</b> {{ \Carbon\Carbon::parse($transaction->estimated_delivery_date)->translatedFormat('d M Y') }}</div>
    @endif
    <table class="transaksi-detail-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->transactionItems as $item)
            <tr>
                <td>{{ $item->product->nama ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>IDR {{ number_format($item->unit_price,0,',','.') }}</td>
                <td>IDR {{ number_format($item->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="transaksi-detail-total">
        Total Belanja: IDR {{ number_format($transaction->total_harga,0,',','.') }}
    </div>
    <div class="transaksi-detail-payment">
        <div><b>Pembayaran</b></div>
        @if($transaction->payments && count($transaction->payments) > 0)
            @php $payment = $transaction->payments->first(); @endphp
            <div>Tanggal: {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y H:i') }}</div>
            <div>Jumlah: IDR {{ number_format($payment->amount_paid,0,',','.') }}</div>
            <div>Status: <span style="font-weight:600;">{{ $payment->status }}</span></div>
            @if($payment->photo_proof_payment)
                <div>Bukti Transfer:</div>
                <img src="{{ asset('storage/bukti_pembayaran/'.$payment->photo_proof_payment) }}" alt="Bukti Pembayaran">
            @endif
        @else
            <div>Belum ada pembayaran.</div>
        @endif
    </div>
</div>
@endsection 