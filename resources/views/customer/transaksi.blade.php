@extends('layouts.app')

@section('content')
<style>
.transaksi-container {
    max-width: 1000px;
    margin: 80px auto 80px auto;
    background: #f8fafc;
    border-radius: 24px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    padding: 40px 32px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.transaksi-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 32px;
    color: #1a1a1a;
    text-align: center;
    position: relative;
}

.transaksi-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #16a34a, #22c55e);
    border-radius: 2px;
}

.transaksi-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 32px;
    align-items: center;
    background: rgba(255,255,255,0.7);
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    backdrop-filter: blur(10px);
}

.transaksi-filters input[type="text"] {
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    padding: 12px 18px;
    font-size: 1rem;
    min-width: 280px;
    background: rgba(255,255,255,0.9);
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.transaksi-filters input[type="text"]:focus {
    outline: none;
    border-color: #16a34a;
    box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    background: #fff;
}

.transaksi-filters select, .transaksi-filters button, .transaksi-filters .status-btn {
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    background: rgba(255,255,255,0.9);
    padding: 12px 20px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.transaksi-filters select {
    min-width: 180px;
}

.transaksi-filters select:focus {
    outline: none;
    border-color: #16a34a;
    box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    background: #fff;
}

.transaksi-filters a.status-btn {
    text-decoration: none;
    display: inline-block;
    color: inherit;
}

.transaksi-filters .status-btn:hover {
    background: rgba(22, 163, 74, 0.05);
    border-color: #16a34a;
    transform: translateY(-1px);
}

.transaksi-filters .status-btn.active, .transaksi-filters .status-btn:focus {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: #fff;
    border: 2px solid #16a34a;
    font-weight: 600;
    box-shadow: 0 4px 16px rgba(22, 163, 74, 0.3);
    transform: translateY(-1px);
}

.transaksi-list {
    margin-top: 24px;
}

.transaksi-card {
    background: #f8fafc;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(255,255,255,0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.transaksi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #16a34a, #22c55e, #16a34a);
    background-size: 200% 100%;
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

.transaksi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
}

.transaksi-card .transaksi-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.transaksi-card .transaksi-status {
    padding: 8px 16px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 700;
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #15803d;
    border: 2px solid #16a34a;
    margin-left: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(22, 163, 74, 0.2);
}

.transaksi-card .transaksi-status.menunggu-pembayaran {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    border-color: #d97706;
    box-shadow: 0 2px 8px rgba(217, 119, 6, 0.2);
}

.transaksi-card .transaksi-status.pembayaran-diproses {
    background: linear-gradient(135deg, #dbeafe, #93c5fd);
    color: #1e40af;
    border-color: #3b82f6;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
}

.transaksi-card .transaksi-status.menunggu-konfirmasi-pembayaran {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    border-color: #d97706;
    box-shadow: 0 2px 8px rgba(217, 119, 6, 0.2);
}

.transaksi-card .transaksi-status.pembayaran-ditolak {
    background: linear-gradient(135deg, #fecaca, #fca5a5);
    color: #dc2626;
    border-color: #dc2626;
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
}

.transaksi-card .transaksi-status.pesanan-diproses {
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
    color: #3730a3;
    border-color: #6366f1;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
}

.transaksi-card .transaksi-status.pesanan-dikirim {
    background: linear-gradient(135deg, #dbeafe, #93c5fd);
    color: #1e40af;
    border-color: #3b82f6;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
}

.transaksi-card .transaksi-status.pesanan-selesai {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #15803d;
    border-color: #16a34a;
    box-shadow: 0 2px 8px rgba(22, 163, 74, 0.2);
}

.transaksi-card .transaksi-status.pesanan-dibatalkan {
    background: linear-gradient(135deg, #fecaca, #fca5a5);
    color: #dc2626;
    border-color: #dc2626;
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
}

.transaksi-card .transaksi-product {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.4;
}

.transaksi-card .transaksi-date {
    color: #6b7280;
    font-size: 1rem;
    font-weight: 500;
    padding: 6px 12px;
    background: rgba(107, 114, 128, 0.1);
    border-radius: 8px;
}

.transaksi-card .transaksi-total {
    font-weight: 800;
    color: #16a34a;
    font-size: 1.2rem;
    text-shadow: 0 1px 2px rgba(22, 163, 74, 0.1);
}

.transaksi-empty {
    text-align: center;
    color: #6b7280;
    margin: 80px 0 60px 0;
    background: rgba(255,255,255,0.7);
    padding: 60px 40px;
    border-radius: 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}

.transaksi-empty img {
    width: 120px;
    opacity: 0.8;
    margin-bottom: 24px;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
}

.transaksi-empty .empty-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 12px;
}

.transaksi-empty .empty-desc {
    color: #6b7280;
    margin-bottom: 24px;
    font-size: 1.1rem;
}

.transaksi-empty .btn-belanja {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: #fff;
    border-radius: 12px;
    padding: 14px 32px;
    font-size: 1.1rem;
    font-weight: 700;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(22, 163, 74, 0.3);
    text-decoration: none;
    display: inline-block;
}

.transaksi-empty .btn-belanja:hover {
    background: linear-gradient(135deg, #15803d, #16a34a);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(22, 163, 74, 0.4);
}

.btn-outline-success {
    background: linear-gradient(135deg, rgba(22, 163, 74, 0.1), rgba(34, 197, 94, 0.1));
    color: #16a34a;
    border: 2px solid #16a34a;
    border-radius: 10px;
    padding: 8px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-outline-success:hover {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}

.btn-outline-warning {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.1));
    color: #d97706;
    border: 2px solid #f59e0b;
    border-radius: 10px;
    padding: 8px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-outline-warning:hover {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.btn-outline-danger {
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(239, 68, 68, 0.1));
    color: #dc2626;
    border: 2px solid #dc2626;
    border-radius: 10px;
    padding: 8px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-outline-danger:hover {
    background: linear-gradient(135deg, #dc2626, #ef4444);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.delivery-estimate {
    color: #16a34a;
    font-size: 0.95rem;
    margin-top: 8px;
    font-weight: 600;
    background: rgba(22, 163, 74, 0.1);
    padding: 4px 8px;
    border-radius: 6px;
    display: inline-block;
}

.quantity-badge {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    color: #6b7280;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    margin-left: 8px;
}

.search-highlight {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    padding: 2px 4px;
    border-radius: 4px;
    font-weight: 600;
}



.loading {
    opacity: 0.7;
    pointer-events: none;
}

@media (max-width: 768px) {
    .transaksi-container { 
        padding: 24px 16px;
        margin: 40px 16px 0 16px;
    }
    .transaksi-title { font-size: 1.6rem; }
    .transaksi-card { padding: 20px 16px; }
    .transaksi-filters {
        flex-direction: column;
        align-items: stretch;
    }
    .transaksi-filters input[type="text"] {
        min-width: 100%;
    }
    .transaksi-filters .status-btn {
        flex: 1;
        text-align: center;
    }
    .transaksi-filters select {
        min-width: 100%;
    }
}

@media (max-width: 480px) {
    .transaksi-container { 
        padding: 20px 12px;
        margin: 20px 8px 0 8px;
    }
    .transaksi-title { font-size: 1.4rem; }
    .transaksi-card { padding: 16px 12px; }
    .transaksi-card .transaksi-row {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
    }
    .transaksi-status {
        margin-left: 0 !important;
        text-align: center;
    }
}
</style>

<div class="transaksi-container">
    <div class="transaksi-title">Daftar Transaksi</div>
    

    <form method="GET" action="{{ route('transaksi') }}" id="filterForm">
        <div class="transaksi-filters">
            <input type="text" 
                   name="search" 
                   placeholder="Cari transaksimu di sini" 
                   value="{{ $search ?? '' }}" />
            
            <select name="status" onchange="this.form.submit()">
                <option value="semua" {{ ($status ?? '') === 'semua' ? 'selected' : '' }}>Semua Status</option>
                <option value="berlangsung" {{ ($status ?? '') === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                <option value="selesai" {{ ($status ?? '') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="tidak_berhasil" {{ ($status ?? '') === 'tidak_berhasil' ? 'selected' : '' }}>Tidak Berhasil</option>
                <option value="menunggu_pembayaran" {{ ($status ?? '') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="menunggu_konfirmasi" {{ ($status ?? '') === 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            </select>
            
            <a href="{{ route('transaksi') }}" class="status-btn" style="text-decoration: none; display: inline-block;">Reset Filter</a>
        </div>
    </form>
    <div class="transaksi-list">
        @if(count($transactions) === 0)
            <div class="transaksi-empty">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="empty" />
                @if($search || ($status && $status !== 'semua'))
                    <div class="empty-title">Tidak ada transaksi yang ditemukan</div>
                    <div class="empty-desc">
                        @if($search)
                            Tidak ada transaksi dengan produk "{{ $search }}"
                        @endif
                        @if($status && $status !== 'semua')
                            @if($search) dan @endif
                            status "{{ ucfirst(str_replace('_', ' ', $status)) }}"
                        @endif
                    </div>
                    <a href="{{ route('transaksi') }}" class="btn-belanja">Lihat Semua Transaksi</a>
                @else
                    <div class="empty-title">Kamu belum pernah bertransaksi</div>
                    <div class="empty-desc">Yuk, mulai belanja dan penuhi kebutuhanmu!</div>
                    <a href="/" class="btn-belanja">Mulai Belanja</a>
                @endif
            </div>
        @else
            @if($search || ($status && $status !== 'semua'))
                <div style="margin-bottom: 20px; padding: 12px 16px; background: rgba(22, 163, 74, 0.1); border-radius: 8px; color: #15803d; font-weight: 500;">
                    🔍 Menampilkan {{ count($transactions) }} transaksi
                    @if($search)
                        dengan produk "{{ $search }}"
                    @endif
                    @if($status && $status !== 'semua')
                        @if($search) dan @endif
                        status "{{ ucfirst(str_replace('_', ' ', $status)) }}"
                    @endif
                </div>
            @endif
            
            @foreach($transactions as $trx)
                <a href="{{ route('transaksi.detail', $trx->transaction_id) }}" style="text-decoration:none;color:inherit;">
                <div class="transaksi-card">
                    <div class="transaksi-row">
                        <span class="transaksi-date">{{ $trx->order_date->format('d M Y') }}</span>
                        <span class="transaksi-status {{ $trx->status_class }}">{{ $trx->display_status }}</span>
                    </div>
                    <div class="transaksi-product">
                        @php
                            $firstItem = $trx->transactionItems->first();
                            $itemCount = $trx->transactionItems->count();
                        @endphp
                        @if($firstItem)
                            <div>
                                @if($search && $firstItem->product)
                                    {!! str_ireplace($search, '<span class="search-highlight">' . $search . '</span>', $firstItem->product->product_name) !!}
                                @else
                                    {{ $firstItem->product->product_name ?? '-' }}
                                @endif
                                <span class="quantity-badge">({{ $firstItem->quantity }} barang)</span>
                                @if($itemCount > 1)
                                    <span style="color:#6b7280; font-size:0.98em; font-weight:500; margin-left:8px;">+ {{ $itemCount - 1 }} produk lainnya</span>
                                @endif
                            </div>
                        @endif
                        @if($trx->estimated_delivery_date)
                            <div class="delivery-estimate">
                                Estimasi Tiba: {{ $trx->estimated_delivery_date->translatedFormat('d M Y') }}
                            </div>
                        @endif
                    </div>
                    <div class="transaksi-row">
                        <span class="transaksi-total">Total Belanja Rp {{ number_format($trx->total_price,0,',','.') }}</span>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            @if($trx->status_order === 'menunggu_pembayaran' && !$trx->payments->count())
                                <a href="{{ route('transaksi.detail', $trx->transaction_id) }}" class="btn btn-outline-warning btn-sm" onclick="event.stopPropagation();">
                                    📤 Upload Bukti
                                </a>
                            @endif
                            @php
                                $hasPayments = $trx->payments && $trx->payments->count() > 0;
                                $allRejected = $hasPayments && $trx->payments->every(function($p) { return $p->status_payment === 'rejected'; });
                            @endphp
                            @if($allRejected)
                                <a href="{{ route('transaksi.detail', $trx->transaction_id) }}" class="btn btn-outline-danger btn-sm" onclick="event.stopPropagation();">
                                    🔁 Upload Ulang Bukti
                                </a>
                            @endif
                            @if($trx->status_order === 'selesai')
                                <a href="#" class="btn btn-outline-success btn-sm" onclick="event.stopPropagation();">Beli Lagi</a>
                            @endif
                        </div>
                    </div>
                </div>
                </a>
            @endforeach
        @endif
    </div>
</div>

<script>
// Hapus auto-submit pada event input
// Form akan submit hanya saat user tekan Enter (default behavior) atau memilih status

document.getElementById('filterForm').addEventListener('submit', function(e) {
    const searchInput = this.querySelector('input[name="search"]');
    const statusSelect = this.querySelector('select[name="status"]');
    
    // Jika search kosong dan status adalah 'semua', redirect ke halaman tanpa parameter
    if (searchInput.value.trim() === '' && statusSelect.value === 'semua') {
        window.location.href = '{{ route("transaksi") }}';
        e.preventDefault();
        return;
    }
    
    // Jika search kosong, hapus parameter search dari URL
    if (searchInput.value.trim() === '') {
        const url = new URL(window.location);
        url.searchParams.delete('search');
        window.location.href = url.toString();
        e.preventDefault();
        return;
    }
});

document.querySelector('select[name="status"]').addEventListener('change', function() {
    this.form.submit();
});

// Tambahkan event listener untuk tombol reset filter
document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan loading indicator saat form di-submit
    const form = document.getElementById('filterForm');
    form.addEventListener('submit', function() {
        // Tambahkan class loading ke button submit
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = 'Loading...';
            submitBtn.disabled = true;
        }
    });
});
</script>
@endsection