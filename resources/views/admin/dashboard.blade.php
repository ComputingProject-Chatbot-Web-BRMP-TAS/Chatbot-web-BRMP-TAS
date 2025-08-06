@extends('layouts.admin')

@section('content')
<div style="padding-top: 80px;">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="mb-2">Dashboard Admin</h1>
                        <p class="text-muted mb-0">Selamat datang, <strong>{{ auth()->user()->name }}</strong>! Anda login sebagai <span class="badge bg-primary">admin</span>.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Menu -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Menu Utama</h5>
                        <div class="row g-3">
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                                    <div class="card bg-primary text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-seedling fa-2x mb-2"></i>
                                            <h6 class="card-title">Produk</h6>
                                            <small>Kelola produk benih</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('admin.transactions') }}" class="text-decoration-none">
                                    <div class="card bg-success text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                            <h6 class="card-title">Transaksi</h6>
                                            <small>Kelola transaksi</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('admin.complaints.index') }}" class="text-decoration-none">
                                    <div class="card bg-warning text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                            <h6 class="card-title">Komplain</h6>
                                            <small>Kelola komplain</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('admin.articles.index') }}" class="text-decoration-none">
                                    <div class="card bg-info text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-newspaper fa-2x mb-2"></i>
                                            <h6 class="card-title">Artikel</h6>
                                            <small>Kelola artikel</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('admin.product.distribution') }}" class="text-decoration-none">
                                    <div class="card bg-secondary text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-map-marked-alt fa-2x mb-2"></i>
                                            <h6 class="card-title">Penyebaran</h6>
                                            <small>Visualisasi peta</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">Statistik Hari Ini</h5>
            </div>
        </div>
        
        <div class="row g-3 mb-4">
            <!-- New Orders Today -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pesanan Baru Hari Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['new_orders_today'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.transactions') }}?status=menunggu_konfirmasi_pembayaran" class="text-decoration-none">
                    <div class="card border-left-warning shadow-sm h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Butuh Konfirmasi Pembayaran
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['orders_need_payment_confirmation'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Completed Orders -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-left-success shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pesanan Selesai
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed_orders'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-left-info shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Pendapatan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Statistics -->
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Produk
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-seedling fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border-left-success shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Transaksi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_transactions'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border-left-warning shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Komplain
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_complaints'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border-left-info shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Artikel
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_articles'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
.text-xs {
    font-size: 0.7rem;
}
.text-gray-300 {
    color: #dddfeb !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease-in-out;
}
</style>
@endsection