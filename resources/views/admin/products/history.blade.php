@extends('layouts.admin')

@section('content')
<div style="padding-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Riwayat Perubahan Produk</h2>
                    <div>
                        <a href="{{ route('admin.products.show', $product->product_id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Detail Produk
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Produk</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nama Produk:</strong> {{ $product->product_name }}<br>
                                <strong>Kategori:</strong> {{ $product->plantType->plant_type_name ?? 'N/A' }}<br>
                                <strong>Status Saat Ini:</strong> 
                                @if($product->stock > $product->minimum_stock)
                                    <span class="badge bg-success">Tersedia</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning">Stok Menipis</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <strong>Stok Saat Ini:</strong> {{ $product->stock }} {{ $product->unit }}<br>
                                <strong>Harga Saat Ini:</strong> Rp {{ number_format($product->price_per_unit, 0, ',', '.') }}<br>
                                <strong>Total Perubahan:</strong> {{ $product->histories->count() }} kali
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Timeline Perubahan</h5>
                    </div>
                    <div class="card-body">
                        @if($product->histories->count() > 0)
                            <div class="timeline">
                                @foreach($product->histories as $index => $history)
                                    <div class="timeline-item">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">Snapshot #{{ $product->histories->count() - $index }}</h6>
                                                    <small class="text-muted">{{ $history->recorded_at->format('d/m/Y H:i:s') }}</small>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Informasi Dasar</h6>
                                                            <table class="table table-sm">
                                                                <tr>
                                                                    <td><strong>Nama Produk:</strong></td>
                                                                    <td>{{ $history->product_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Kategori:</strong></td>
                                                                    <td>{{ $history->plant_type_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Deskripsi:</strong></td>
                                                                    <td>{{ Str::limit($history->description, 100) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Stok:</strong></td>
                                                                    <td>{{ $history->stock }} {{ $history->unit }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Stok Minimum:</strong></td>
                                                                    <td>{{ $history->minimum_stock }} {{ $history->unit }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Informasi Harga & Sertifikat</h6>
                                                            <table class="table table-sm">
                                                                <tr>
                                                                    <td><strong>Satuan:</strong></td>
                                                                    <td>{{ $history->unit }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Harga per Unit:</strong></td>
                                                                    <td>Rp {{ number_format($history->price_per_unit, 0, ',', '.') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Min. Pembelian:</strong></td>
                                                                    <td>{{ $history->minimum_purchase }} {{ $history->unit }}</td>
                                                                </tr>
                                                                @if($history->certificate_number)
                                                                <tr>
                                                                    <td><strong>No. Sertifikat:</strong></td>
                                                                    <td>{{ $history->certificate_number }}</td>
                                                                </tr>
                                                                @endif
                                                                @if($history->certificate_class)
                                                                <tr>
                                                                    <td><strong>Kelas Sertifikat:</strong></td>
                                                                    <td>{{ $history->certificate_class }}</td>
                                                                </tr>
                                                                @endif
                                                                @if($history->valid_from)
                                                                <tr>
                                                                    <td><strong>Berlaku Dari:</strong></td>
                                                                    <td>{{ \Carbon\Carbon::parse($history->valid_from)->format('d/m/Y') }}</td>
                                                                </tr>
                                                                @endif
                                                                @if($history->valid_until)
                                                                <tr>
                                                                    <td><strong>Berlaku Sampai:</strong></td>
                                                                    <td>{{ \Carbon\Carbon::parse($history->valid_until)->format('d/m/Y') }}</td>
                                                                </tr>
                                                                @endif
                                                            </table>
                                                        </div>
                                                    </div>

                                                    @if($history->image1 || $history->image2 || $history->image_certificate)
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <h6>Gambar pada Saat Itu</h6>
                                                            <div class="row">
                                                                @if($history->image1)
                                                                <div class="col-md-4">
                                                                    <img src="{{ asset('storage/' . $history->image1) }}" 
                                                                         alt="Gambar Utama" class="img-thumbnail" style="max-height: 100px;">
                                                                    <small class="d-block text-center">Gambar Utama</small>
                                                                </div>
                                                                @endif
                                                                @if($history->image2)
                                                                <div class="col-md-4">
                                                                    <img src="{{ asset('storage/' . $history->image2) }}" 
                                                                         alt="Gambar Tambahan" class="img-thumbnail" style="max-height: 100px;">
                                                                    <small class="d-block text-center">Gambar Tambahan</small>
                                                                </div>
                                                                @endif
                                                                @if($history->image_certificate)
                                                                <div class="col-md-4">
                                                                    <img src="{{ asset('storage/' . $history->image_certificate) }}" 
                                                                         alt="Gambar Sertifikat" class="img-thumbnail" style="max-height: 100px;">
                                                                    <small class="d-block text-center">Gambar Sertifikat</small>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada riwayat perubahan</h5>
                                <p class="text-muted">Riwayat perubahan akan muncul setelah produk pertama kali dibuat atau diupdate.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 20px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #007bff;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
}

.timeline-content {
    margin-left: 20px;
}
</style>
@endsection 