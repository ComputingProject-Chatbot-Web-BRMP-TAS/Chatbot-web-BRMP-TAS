@extends('layouts.admin')

@section('content')
    <div style="padding-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-4">Kelola Transaksi</h2>

                    <!-- Filter Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Filter Transaksi</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.transactions.index') }}" class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Status Order</label>
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="menunggu_kode_billing"
                                            {{ request('status') == 'menunggu_kode_billing' ? 'selected' : '' }}>Menunggu
                                            Kode Billing</option>
                                        <option value="menunggu_pembayaran"
                                            {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu
                                            Pembayaran</option>
                                        <option value="menunggu_konfirmasi_pembayaran"
                                            {{ request('status') == 'menunggu_konfirmasi_pembayaran' ? 'selected' : '' }}>
                                            Menunggu Konfirmasi</option>
                                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>
                                            Diproses</option>
                                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                        <option value="dibatalkan"
                                            {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Status Pembayaran</label>
                                    <select name="payment_status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending"
                                            {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Menunggu
                                            Konfirmasi</option>
                                        <option value="approved"
                                            {{ request('payment_status') == 'approved' ? 'selected' : '' }}>Dikonfirmasi
                                        </option>
                                        <option value="rejected"
                                            {{ request('payment_status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                        <option value="no_payment"
                                            {{ request('payment_status') == 'no_payment' ? 'selected' : '' }}>Belum Bayar
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Tanggal Akhir</label>
                                    <input type="date" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('admin.transactions.index') }}"
                                            class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Transaksi</h5>
                            <span class="badge bg-primary">{{ $transactions->count() }} transaksi</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table">
                                        <tr>
                                            <th>No</th>
                                            <th>ID Transaksi</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Status Order</th>
                                            <th>Status Pembayaran</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $index => $transaction)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>#{{ $transaction->transaction_id }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $transaction->transactionItems->count() }}
                                                        item</small>
                                                </td>
                                                <td>
                                                    <strong>{{ $transaction->user->name ?? 'N/A' }}</strong>
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $transaction->user->email ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    <strong>Rp
                                                        {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $transaction->delivery_method ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    @if ($transaction->order_status == 'menunggu_kode_billing')
                                                        <span class="badge bg-secondary">Menunggu Kode Billing</span>
                                                    @elseif ($transaction->order_status == 'menunggu_pembayaran')
                                                        <span class="badge bg-warning">Menunggu Pembayaran</span>
                                                    @elseif($transaction->order_status == 'menunggu_konfirmasi_pembayaran')
                                                        <span class="badge bg-info">Menunggu Konfirmasi</span>
                                                    @elseif($transaction->order_status == 'diproses')
                                                        <span class="badge bg-primary">Diproses</span>
                                                    @elseif($transaction->order_status == 'selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @elseif($transaction->order_status == 'dibatalkan')
                                                        <span class="badge bg-danger">Dibatalkan</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ $transaction->order_status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $latestPayment = $transaction->payments->last();
                                                    @endphp
                                                    @if ($latestPayment)
                                                        @if ($latestPayment->payment_status == 'approved')
                                                            <span class="badge bg-success">Dikonfirmasi</span>
                                                        @elseif($latestPayment->payment_status == 'rejected')
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @elseif($latestPayment->payment_status == 'pending')
                                                            <span class="badge bg-info">Menunggu Konfirmasi</span>
                                                        @elseif($latestPayment->payment_status == 'no_payment')
                                                            <span class="badge bg-warning">Belum Bayar</span>
                                                        @endif
                                                        <br>
                                                        <small
                                                            class="text-muted">{{ $latestPayment->payment_date ? $latestPayment->payment_date->format('d/m/Y') : $latestPayment->created_at->format('d/m/Y') }}</small>
                                                    @else
                                                        <span class="badge bg-secondary">Belum Ada Kode Billing</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $transaction->order_date->format('d/m/Y H:i') }}
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $transaction->order_date->diffForHumans() }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.transactions.show', $transaction->transaction_id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                        @if ($latestPayment && $latestPayment->payment_status == 'pending')
                                                            <a href="{{ route('admin.payment.show', $latestPayment->payment_id) }}"
                                                                class="btn btn-sm btn-warning">
                                                                <i class="fas fa-credit-card"></i> Konfirmasi Pembayaran
                                                                ke-{{ $transaction->payments->where('payment_id', '<=', $latestPayment->payment_id)->count() }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                                        <p>Tidak ada transaksi ditemukan</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Form -->
    <form id="statusForm" method="POST" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" id="statusInput">
    </form>

    <script>
        function updateStatus(transactionId, status) {
            if (confirm('Apakah Anda yakin ingin mengubah status transaksi ini?')) {
                document.getElementById('statusInput').value = status;
                document.getElementById('statusForm').action = `/ADMIN-BRMP-TAS/transactions/${transactionId}/status`;
                document.getElementById('statusForm').submit();
            }
        }
    </script>
@endsection
