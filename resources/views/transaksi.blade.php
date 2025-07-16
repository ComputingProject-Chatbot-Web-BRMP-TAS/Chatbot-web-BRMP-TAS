@extends('layouts.app')

@section('content')
<style>
.transaksi-container {
    max-width: 900px;
    margin: 80px auto 0 auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    padding: 32px 24px;
}
.transaksi-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 24px;
    color: #222;
}
.transaksi-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
    align-items: center;
}
.transaksi-filters input[type="text"] {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 8px 14px;
    font-size: 1rem;
    min-width: 220px;
}
.transaksi-filters select, .transaksi-filters button, .transaksi-filters .status-btn {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    background: #fff;
    padding: 8px 16px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
}
.transaksi-filters .status-btn.active, .transaksi-filters .status-btn:focus {
    background: #eaffea;
    color: #176a3a;
    border: 1.5px solid #176a3a;
    font-weight: 600;
}
.transaksi-list {
    margin-top: 18px;
}
.transaksi-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px 18px;
    margin-bottom: 18px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.04);
}
.transaksi-card .transaksi-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.transaksi-card .transaksi-status {
    padding: 4px 14px;
    border-radius: 8px;
    font-size: 0.98rem;
    font-weight: 600;
    background: #eaffea;
    color: #176a3a;
    border: 1.5px solid #176a3a;
    margin-left: 8px;
}
.transaksi-card .transaksi-status.berlangsung {
    background: #fffbe6;
    color: #bfa100;
    border-color: #bfa100;
}
.transaksi-card .transaksi-status.tidak-berhasil {
    background: #ffeaea;
    color: #d32f2f;
    border-color: #d32f2f;
}
.transaksi-card .transaksi-status.berhasil {
    background: #eaffea;
    color: #176a3a;
    border-color: #176a3a;
}
.transaksi-card .transaksi-product {
    font-size: 1.1rem;
    font-weight: 600;
    color: #222;
}
.transaksi-card .transaksi-date {
    color: #888;
    font-size: 0.98rem;
}
.transaksi-card .transaksi-total {
    font-weight: 700;
    color: #176a3a;
    font-size: 1.08rem;
}
.transaksi-empty {
    text-align: center;
    color: #888;
    margin: 60px 0 40px 0;
}
.transaksi-empty img {
    width: 90px;
    opacity: 0.7;
    margin-bottom: 18px;
}
.transaksi-empty .empty-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #222;
    margin-bottom: 8px;
}
.transaksi-empty .empty-desc {
    color: #888;
    margin-bottom: 18px;
}
.transaksi-empty .btn-belanja {
    background: #176a3a;
    color: #fff;
    border-radius: 8px;
    padding: 10px 28px;
    font-size: 1.08rem;
    font-weight: 600;
    border: none;
    transition: background 0.2s;
}
.transaksi-empty .btn-belanja:hover {
    background: #14592f;
}
@media (max-width: 600px) {
    .transaksi-container { padding: 16px 4px; }
    .transaksi-title { font-size: 1.2rem; }
    .transaksi-card { padding: 14px 8px; }
}
</style>
<div class="transaksi-container">
    <div class="transaksi-title">Daftar Transaksi</div>
    <div class="transaksi-filters">
        <input type="text" placeholder="Cari transaksimu di sini" />
        <select>
            <option>Semua Produk</option>
        </select>
        <button class="status-btn active">Semua</button>
        <button class="status-btn">Berlangsung</button>
        <button class="status-btn">Selesai</button>
        <button class="status-btn">Tidak Berhasil</button>
        <button class="status-btn">Reset Filter</button>
    </div>
    <div class="transaksi-list">
        @if(count($transactions) === 0)
            <div class="transaksi-empty">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="empty" />
                <div class="empty-title">Kamu belum pernah bertransaksi</div>
                <div class="empty-desc">Yuk, mulai belanja dan penuhi kebutuhanmu!</div>
                <a href="/" class="btn-belanja">Mulai Belanja</a>
            </div>
        @else
            @foreach($transactions as $trx)
                <a href="{{ route('transaksi.detail', $trx->transaksi_id) }}" style="text-decoration:none;color:inherit;">
                <div class="transaksi-card">
                    <div class="transaksi-row">
                        <span class="transaksi-date">{{ \Carbon\Carbon::parse($trx->order_date)->format('d M Y') }}</span>
                        <span class="transaksi-status {{ strtolower(str_replace(' ', '-', $trx->status)) }}">{{ $trx->status }}</span>
                    </div>
                    <div class="transaksi-product">
                        @foreach($trx->transactionItems as $item)
                            <div>
                                {{ $item->product->nama ?? '-' }} <span style="color:#888;font-size:0.98em;">({{ $item->quantity }} barang)</span>
                            </div>
                        @endforeach
                        @if($trx->estimated_delivery_date)
                            <div style="color:#388e3c;font-size:0.98em;margin-top:2px;">
                                Estimasi Tiba: {{ \Carbon\Carbon::parse($trx->estimated_delivery_date)->translatedFormat('d M Y') }}
                            </div>
                        @endif
                    </div>
                    <div class="transaksi-row">
                        <span>{{ $trx->transactionItems->sum('quantity') }} barang</span>
                        <span class="transaksi-total">Total Belanja Rp {{ number_format($trx->total_harga,0,',','.') }}</span>
                        <a href="#" class="btn btn-outline-success btn-sm" style="border-radius:7px;font-weight:600;" onclick="event.stopPropagation();">Beli Lagi</a>
                    </div>
                </div>
                </a>
            @endforeach
        @endif
    </div>
</div>
@endsection 