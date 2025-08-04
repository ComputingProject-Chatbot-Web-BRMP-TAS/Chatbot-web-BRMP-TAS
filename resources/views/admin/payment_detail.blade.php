@extends('layouts.admin')

@section('content')
<div style="padding-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Detail Pembayaran ke-{{ $payment->transaction->payments->where('payment_id', '<=', $payment->payment_id)->count() }}</h2>
                    <a href="{{ route('admin.transaction.detail', $payment->transaction->transaction_id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Transaksi
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <!-- Informasi Pembayaran -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Pembayaran ke:</strong></td>
                                                <td>{{ $payment->transaction->payments->where('payment_id', '<=', $payment->payment_id)->count() }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    @if($payment->payment_status == 'approved')
                                                        <span class="badge bg-success">Dikonfirmasi</span>
                                                    @elseif($payment->payment_status == 'rejected')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jumlah:</strong></td>
                                                <td><strong class="text-primary">Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Pembayaran:</strong></td>
                                                <td>{{ $payment->payment_date ? $payment->payment_date->format('d M Y H:i') : $payment->created_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Customer:</strong></td>
                                                <td>{{ $payment->transaction->user->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $payment->transaction->user->email ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>ID Transaksi:</strong></td>
                                                <td>#{{ $payment->transaction->transaction_id }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Transaksi:</strong></td>
                                                <td>Rp {{ number_format($payment->transaction->total_price, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if($payment->rejection_reason)
                                    <div class="alert alert-danger mt-3">
                                        <strong>Alasan Penolakan:</strong><br>
                                        {{ $payment->rejection_reason }}
                                    </div>
                                @endif

                                @if($payment->photo_proof_payment)
                                    <div class="mt-3">
                                        <h6>Bukti Pembayaran:</h6>
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/bukti_pembayaran/' . $payment->photo_proof_payment) }}" 
                                                 alt="Bukti Pembayaran" 
                                                 class="img-fluid rounded" 
                                                 style="max-width: 100%; max-height: 300px; object-fit: contain;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Flow Status -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Status Alur Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-shopping-cart text-primary" style="font-size: 1.5rem;"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">Pesanan Dibuat</h6>
                                                <small class="text-muted">{{ $payment->transaction->order_date->format('d M Y H:i') }}</small>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-check-circle text-success"></i>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-credit-card text-warning" style="font-size: 1.5rem;"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">Bukti Pembayaran Diupload</h6>
                                                <small class="text-muted">{{ $payment->payment_date ? $payment->payment_date->format('d M Y H:i') : $payment->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                            <div class="flex-shrink-0">
                                                @if($payment->payment_status == 'pending')
                                                    <i class="fas fa-clock text-warning"></i>
                                                @elseif($payment->payment_status == 'approved')
                                                    <i class="fas fa-check-circle text-success"></i>
                                                @elseif($payment->payment_status == 'rejected')
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </div>
                                        </div>

                                        @if($payment->payment_status == 'approved')
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-cog text-primary" style="font-size: 1.5rem;"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">Pesanan Diproses</h6>
                                                <small class="text-muted">Status transaksi: {{ $payment->transaction->order_status }}</small>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-check-circle text-success"></i>
                                            </div>
                                        </div>
                                        @endif

                                        @if($payment->payment_status == 'rejected')
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-exclamation-triangle text-danger" style="font-size: 1.5rem;"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">Pembayaran Ditolak</h6>
                                                <small class="text-muted">Customer perlu upload ulang bukti pembayaran</small>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-times-circle text-danger"></i>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @if($payment->payment_status == 'pending')
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Aksi Pembayaran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form method="POST" action="{{ route('admin.payment.approve', $payment->payment_id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success w-100" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                    <i class="fas fa-check"></i> Konfirmasi Pembayaran
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                <i class="fas fa-times"></i> Tolak Pembayaran
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <!-- Informasi Transaksi -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Transaksi</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Status Transaksi:</strong></td>
                                        <td>
                                            @if($payment->transaction->order_status == 'menunggu_pembayaran')
                                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                                            @elseif($payment->transaction->order_status == 'menunggu_konfirmasi_pembayaran')
                                                <span class="badge bg-info">Menunggu Konfirmasi</span>
                                            @elseif($payment->transaction->order_status == 'diproses')
                                                <span class="badge bg-primary">Diproses</span>
                                            @elseif($payment->transaction->order_status == 'dikirim')
                                                <span class="badge bg-info">Dikirim</span>
                                            @elseif($payment->transaction->order_status == 'selesai')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($payment->transaction->order_status == 'dibatalkan')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status Pembayaran:</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $payment->payment_status == 'approved' ? 'success' : ($payment->payment_status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ $payment->transaction->payment_status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Order:</strong></td>
                                        <td>{{ $payment->transaction->order_date->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Penerima:</strong></td>
                                        <td>{{ $payment->transaction->recipient_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat:</strong></td>
                                        <td>{{ $payment->transaction->shipping_address ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.payment.reject', $payment->payment_id) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Berikan alasan mengapa pembayaran ditolak..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 