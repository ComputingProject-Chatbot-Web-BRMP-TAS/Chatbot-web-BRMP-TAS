@extends('layouts.app')

@section('content')
    <style>
        .transaksi-container {
            max-width: 1000px;
            margin: 40px auto 40px auto;
            background: #f8fafc;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            padding: 40px 32px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .transaksi-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 32px;
            color: #1a1a1a;
            text-align: center;
            position: relative;
        }

        .transaksi-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 32px;
            align-items: center;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #4CAF50;
        }

        .transaksi-filters input[type="text"] {
            flex: 2;
            padding: 12px 16px;
            border: 1px solid #4CAF50;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .transaksi-filters select {
            padding: 12px 16px;
            border: 1px solid #4CAF50;
            border-radius: 8px;
            font-size: 1rem;
            background: #fff;
            color: #1a1a1a;
            transition: all 0.3s ease;
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }


        .transaksi-card:hover {
            transform: translateY(-4px);
        }

        .transaksi-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .transaksi-row-item {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: nowrap;
        }

        .transaksi-status {
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

        .transaksi-product {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.4;
        }

        .transaksi-date {
            color: #6b7280;
            font-size: 1rem;
            font-weight: 500;
            padding: 6px 12px;
            background: rgba(107, 114, 128, 0.1);
            border-radius: 8px;
        }

        .transaksi-total {
            font-weight: 800;
            color: #16a34a;
            font-size: 1.2rem;
            text-shadow: 0 1px 2px rgba(22, 163, 74, 0.1);
        }

        .transaksi-empty {
            text-align: center;
            color: #6b7280;
            margin: 80px 0 60px 0;
            background: rgba(255, 255, 255, 0.7);
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        }

        .transaksi-empty img {
            width: 120px;
            opacity: 0.8;
            margin-bottom: 24px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }

        .empty-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
        }

        .empty-desc {
            color: #6b7280;
            margin-bottom: 24px;
            font-size: 1.1rem;
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
            font-size: 0.95em;
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
            font-size: 0.9em;
            font-weight: 500;
        }

        .search-highlight {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: 600;
        }

        .transaksi-item-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #666;
            margin-top: 10px;
            margin-right: 10px;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        @media (max-width: 1023px) {

            .mobile-back-btn {
                display: flex !important;
            }

            .mobile-transaksi-title {
                display: flex !important;
            }

            .mobile-search-container {
                display: none !important;
            }

            .transaksi-container {
                margin-top: 0px;
                padding: 10px;
                box-shadow: none;
                background: none;
            }

            .transaksi-date {
                font-size: 12px;
                padding: 6px;
            }

            .transaksi-status {
                font-size: 12px;
                padding: 6px;
            }

            .transaksi-title {
                display: none;
            }

            .transaksi-card {
                padding: 12px;
                margin-bottom: 10px
            }

            .transaksi-product {
                font-size: 12px;
            }

            .transaksi-filters {
                flex-direction: column;
                align-items: stretch;
                padding: 12px;
                margin-bottom: 15px;
            }

            .transaksi-filters input[type="text"] {
                width: 100%;
            }

            .transaksi-filters select {
                padding: 12px;
                font-size: 14px;
            }

            .transaksi-total {
                font-size: 1em;
            }
        }
    </style>

    <div class="transaksi-container">
        <div class="transaksi-title">Daftar Transaksi</div>


        <form method="GET" action="{{ route('transaksi') }}" id="filterForm">
            <div class="transaksi-filters">
                <input type="text" name="search" placeholder="Cari transaksimu di sini" value="{{ $search ?? '' }}" />
                <div style="display: flex; gap: 12px; flex-direction:row; width: 100%;">
                    <select name="status" onchange="this.form.submit()">
                        <option value="semua" {{ ($status ?? '') === 'semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="berlangsung" {{ ($status ?? '') === 'berlangsung' ? 'selected' : '' }}>Berlangsung
                        </option>
                        <option value="selesai" {{ ($status ?? '') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ ($status ?? '') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                        <option value="menunggu_pembayaran"
                            {{ ($status ?? '') === 'menunggu_pembayaran' ? 'selected' : '' }}>
                            Menunggu Pembayaran</option>
                        <option value="menunggu_konfirmasi"
                            {{ ($status ?? '') === 'menunggu_konfirmasi' ? 'selected' : '' }}>
                            Menunggu Konfirmasi</option>
                        <option value="menunggu_kode_billing"
                            {{ ($status ?? '') === 'menunggu_kode_billing' ? 'selected' : '' }}>Menunggu Kode Billing
                        </option>
                    </select>

                    <button type="button" onclick="window.location.href='{{ route('transaksi') }}'" class="btn-green"
                        style="width:85px;">Reset</button>
                </div>
            </div>
        </form>
        <div class="transaksi-list">
            @if (count($transactions) === 0)
                <div class="transaksi-empty">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="empty" />
                    @if ($search || ($status && $status !== 'semua'))
                        <div class="empty-title">Tidak ada transaksi yang ditemukan</div>
                        <div class="empty-desc">
                            @if ($search)
                                Tidak ada transaksi dengan produk "{{ $search }}"
                            @endif
                            @if ($status && $status !== 'semua')
                                @if ($search)
                                    dan
                                @endif
                                status "{{ ucfirst(str_replace('_', ' ', $status)) }}"
                            @endif
                        </div>
                        <button onclick="window.location.href='{{ route('transaksi') }}'" class="btn-green px-3">Lihat
                            Semua Transaksi</button>
                    @else
                        <div class="empty-title">Kamu belum pernah bertransaksi</div>
                        <div class="empty-desc">Yuk, mulai belanja dan penuhi kebutuhanmu!</div>
                        <button onclick="window.location.href='/'" class="btn-green px-3">Mulai Belanja</button>
                    @endif
                </div>
            @else
                @if ($search || ($status && $status !== 'semua'))
                    <div
                        style="margin-bottom: 20px; padding: 12px 16px; background: rgba(22, 163, 74, 0.1); border-radius: 8px; color: #15803d; font-weight: 500;">
                        🔍 Menampilkan {{ count($transactions) }} transaksi
                        @if ($search)
                            dengan produk "{{ $search }}"
                        @endif
                        @if ($status && $status !== 'semua')
                            @if ($search)
                                dan
                            @endif
                            status "{{ ucfirst(str_replace('_', ' ', $status)) }}"
                        @endif
                    </div>
                @endif

                @foreach ($transactions as $trx)
                    <a href="{{ route('transaksi.detail', $trx->transaction_id) }}"
                        style="text-decoration:none;color:inherit;">
                        <div class="transaksi-card">
                            <div class="transaksi-row">
                                <span class="transaksi-date">{{ $trx->order_date->format('d M Y') }}</span>
                                <span class="transaksi-status {{ $trx->status_class }}">{{ $trx->display_status }}</span>
                            </div>

                            <div class="transaksi-row-item">
                                @php
                                    $firstItem = $trx->transactionItems->first();
                                    $itemCount = $trx->transactionItems->count();
                                @endphp
                                @if ($firstItem)
                                    @if ($firstItem->product->image1)
                                        <img src="{{ asset('storage/products/' . $firstItem->product->image1) }}"
                                            alt="{{ $firstItem->product->product_name }}" class="transaksi-item-image">
                                    @else
                                        <div class="transaksi-item-image">
                                            <i class="fas fa-seedling"></i>
                                        </div>
                                    @endif
                                    <div class="transaksi-product">
                                        <div>
                                            @if ($search && $firstItem->product)
                                                {!! str_ireplace(
                                                    $search,
                                                    '<span class="search-highlight">' . $search . '</span>',
                                                    $firstItem->product->product_name,
                                                ) !!}
                                            @else
                                                {{ $firstItem->product->product_name ?? '-' }}
                                            @endif
                                            <span class="quantity-badge">({{ $firstItem->quantity }}
                                                {{ $firstItem->product->unit }})</span>
                                            @if ($itemCount > 1)
                                                <span style="color:#6b7280; font-size:0.98em; font-weight:500;">+
                                                    {{ $itemCount - 1 }} produk lainnya</span>
                                            @endif
                                        </div>
                                @endif
                                @if ($trx->estimated_delivery_date)
                                    <div class="delivery-estimate">
                                        Estimasi Tiba: {{ $trx->estimated_delivery_date->translatedFormat('d M Y') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="transaksi-row">
                            <span class="transaksi-total">Total Belanja Rp
                                {{ number_format($trx->total_price, 0, ',', '.') }}</span>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                @if ($trx->order_status === 'menunggu_pembayaran' && !$trx->payments->count())
                                    <a href="{{ route('transaksi.detail', $trx->transaction_id) }}"
                                        class="btn btn-outline-warning btn-sm" onclick="event.stopPropagation();">
                                        📤 Upload Bukti
                                    </a>
                                @endif
                                @php
                                    $hasPayments = $trx->payments && $trx->payments->count() > 0;
                                    $allRejected =
                                        $hasPayments &&
                                        $trx->payments->every(function ($p) {
                                            return $p->payment_status === 'rejected';
                                        });
                                    $hasRejectedPayment =
                                        $hasPayments &&
                                        $trx->payments->where('payment_status', 'rejected')->count() > 0;
                                @endphp

                                @if ($hasRejectedPayment)
                                    <a href="{{ route('transaksi.detail', $trx->transaction_id) }}"
                                        class="btn btn-outline-warning btn-sm" onclick="event.stopPropagation();">
                                        ⚠️ Lihat Detail
                                    </a>
                                @endif
                                @if ($trx->order_status === 'selesai')
                                    <a href="#" class="btn btn-outline-success btn-sm"
                                        onclick="event.stopPropagation();">Beli Lagi</a>
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
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="search"]');
            const statusSelect = this.querySelector('select[name="status"]');

            // Jika search kosong dan status adalah 'semua', redirect ke halaman tanpa parameter
            if (searchInput.value.trim() === '' && statusSelect.value === 'semua') {
                window.location.href = '{{ route('transaksi') }}';
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
