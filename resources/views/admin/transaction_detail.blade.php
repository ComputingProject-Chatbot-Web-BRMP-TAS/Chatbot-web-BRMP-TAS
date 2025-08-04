@extends('layouts.admin')

@section('content')
<div style="padding-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Detail Transaksi #{{ $transaction->transaction_id }}</h2>
                    <a href="{{ route('admin.transactions') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <!-- Informasi Transaksi -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Transaksi</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>ID Transaksi:</strong></td>
                                                <td>#{{ $transaction->transaction_id }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Order:</strong></td>
                                                <td>{{ $transaction->order_date->format('d M Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    @if($transaction->order_status == 'menunggu_pembayaran')
                                                        <span class="badge bg-warning">Menunggu Pembayaran</span>
                                                    @elseif($transaction->order_status == 'menunggu_konfirmasi_pembayaran')
                                                        <span class="badge bg-info">Menunggu Konfirmasi</span>
                                                    @elseif($transaction->order_status == 'diproses')
                                                        <span class="badge bg-primary">Diproses</span>
                                                    @elseif($transaction->order_status == 'dikirim')
                                                        <span class="badge bg-info">Dikirim</span>
                                                    @elseif($transaction->order_status == 'selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @elseif($transaction->order_status == 'dibatalkan')
                                                        <span class="badge bg-danger">Dibatalkan</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $transaction->order_status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Metode Pengiriman:</strong></td>
                                                <td>{{ $transaction->delivery_method ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Harga:</strong></td>
                                                <td><strong class="text-primary">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Customer:</strong></td>
                                                <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $transaction->user->email ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Telepon:</strong></td>
                                                <td>{{ $transaction->user->phone ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Penerima:</strong></td>
                                                <td>{{ $transaction->recipient_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Telepon Penerima:</strong></td>
                                                <td>{{ $transaction->recipient_phone ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat Pengiriman -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Alamat Pengiriman</h5>
                            </div>
                            <div class="card-body">
                                @if($transaction->shippingAddress)
                                    <p><strong>{{ $transaction->shippingAddress->recipient_name }}</strong></p>
                                    <p>{{ $transaction->shippingAddress->address }}</p>
                                    <p>Telp: {{ $transaction->shippingAddress->recipient_phone }}</p>
                                    @if($transaction->shippingAddress->note)
                                        <p><small class="text-muted">Catatan: {{ $transaction->shippingAddress->note }}</small></p>
                                    @endif
                                @else
                                    <p>{{ $transaction->shipping_address ?? 'N/A' }}</p>
                                    @if($transaction->shipping_note)
                                        <p><small class="text-muted">Catatan: {{ $transaction->shipping_note }}</small></p>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Item Transaksi -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Item Pesanan ({{ $transaction->transactionItems->count() }} item)</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->transactionItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product && $item->product->image1)
                                                            <img src="{{ asset('storage/' . $item->product->image1) }}" 
                                                                 alt="{{ $item->product->product_name }}" 
                                                                 class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <strong>{{ $item->product->product_name ?? 'Produk tidak ditemukan' }}</strong>
                                                            <br>
                                                            <small class="text-muted">{{ $item->product->plantType->plant_type_name ?? 'N/A' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                                <td>{{ $item->quantity }} {{ $item->product->unit ?? '' }}</td>
                                                <td><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-md-4">
                        <!-- Status Update -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Update Status</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.transaction.status.update', $transaction->transaction_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Status Baru</label>
                                        <select name="status" class="form-select" required>
                                            <option value="menunggu_pembayaran" {{ $transaction->order_status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                            <option value="menunggu_konfirmasi_pembayaran" {{ $transaction->order_status == 'menunggu_konfirmasi_pembayaran' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                            <option value="diproses" {{ $transaction->order_status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="dikirim" {{ $transaction->order_status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                            <option value="selesai" {{ $transaction->order_status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="dibatalkan" {{ $transaction->order_status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-save"></i> Update Status
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Informasi Pembayaran -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                @if($transaction->payments->count() > 0)
                                    @foreach($transaction->payments as $index => $payment)
                                    <div class="border-bottom pb-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <strong>Pembayaran ke-{{ $index + 1 }}</strong>
                                            <span class="badge bg-{{ $payment->payment_status == 'approved' ? 'success' : ($payment->payment_status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </div>
                                        <p class="mb-1"><small>Jumlah: Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}</small></p>
                                        <p class="mb-1"><small>Tanggal: {{ $payment->payment_date ? $payment->payment_date->format('d M Y H:i') : $payment->created_at->format('d M Y H:i') }}</small></p>
                                        
                                        @if($payment->rejection_reason)
                                            <div class="alert alert-danger mt-2">
                                                <strong>Alasan Penolakan:</strong><br>
                                                {{ $payment->rejection_reason }}
                                            </div>
                                        @endif
                                        
                                        @if($payment->photo_proof_payment)
                                            <div class="mt-2">
                                                <strong>Bukti Pembayaran:</strong>
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/bukti_pembayaran/' . $payment->photo_proof_payment) }}" 
                                                         alt="Bukti Pembayaran" 
                                                         class="img-fluid rounded" 
                                                         style="max-width: 100%; max-height: 300px; object-fit: contain;">
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Payment Action Buttons -->
                                        @if($payment->payment_status == 'pending')
                                            <div class="mt-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <form method="POST" action="{{ route('admin.payment.approve', $payment->payment_id) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm w-100" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                                <i class="fas fa-check"></i> Konfirmasi
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $payment->payment_id }}">
                                                            <i class="fas fa-times"></i> Tolak
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $payment->payment_id }}" tabindex="-1">
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
                                    @endforeach
                                @else
                                    <p class="text-muted">Belum ada pembayaran</p>
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
                                        <!-- Step 1: Order Created -->
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-shopping-cart text-primary" style="font-size: 1.5rem;"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">Pesanan Dibuat</h6>
                                                <small class="text-muted">{{ $transaction->order_date->format('d M Y H:i') }}</small>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-check-circle text-success"></i>
                                            </div>
                                        </div>

                                        <!-- Step 2: Payment Status -->
                                        @if($transaction->payments->count() > 0)
                                            @php $latestPayment = $transaction->payments->last(); @endphp
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-credit-card text-{{ $latestPayment->payment_status == 'approved' ? 'success' : ($latestPayment->payment_status == 'rejected' ? 'danger' : 'warning') }}" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">Bukti Pembayaran Diupload</h6>
                                                    <small class="text-muted">{{ $latestPayment->payment_date ? $latestPayment->payment_date->format('d M Y H:i') : $latestPayment->created_at->format('d M Y H:i') }}</small>
                                                    <br>
                                                    <small class="text-{{ $latestPayment->payment_status == 'approved' ? 'success' : ($latestPayment->payment_status == 'rejected' ? 'danger' : 'warning') }}">
                                                        Status: {{ ucfirst($latestPayment->payment_status) }}
                                                    </small>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    @if($latestPayment->payment_status == 'pending')
                                                        <i class="fas fa-clock text-warning"></i>
                                                    @elseif($latestPayment->payment_status == 'approved')
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    @elseif($latestPayment->payment_status == 'rejected')
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Step 3: Order Processing (if approved) -->
                                            @if($latestPayment->payment_status == 'approved')
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-cog text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">Pesanan Diproses</h6>
                                                    <small class="text-muted">Status transaksi: {{ ucfirst(str_replace('_', ' ', $transaction->order_status)) }}</small>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-check-circle text-success"></i>
                                                </div>
                                            </div>
                                            @endif
                                        @else
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-credit-card text-muted" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0 text-muted">Bukti Pembayaran Diupload</h6>
                                                    <small class="text-muted">Belum ada pembayaran</small>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-clock text-muted"></i>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Tambahan</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Tujuan Pembelian:</strong></td>
                                        <td>{{ $transaction->purchase_purpose ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tempat Tanam - Provinsi:</strong></td>
                                        <td>{{ $transaction->province->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tempat Tanam - Kota/Kabupaten:</strong></td>
                                        <td>{{ $transaction->regency->name ?? 'N/A' }}</td>
                                    </tr>
                                    @if($transaction->estimated_delivery_date)
                                    <tr>
                                        <td><strong>Estimasi Kirim:</strong></td>
                                        <td>{{ $transaction->estimated_delivery_date->format('d M Y') }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diupdate:</strong></td>
                                        <td>{{ $transaction->updated_at->format('d M Y H:i') }}</td>
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
@endsection 