@extends('layouts.admin')

@section('content')
<div style="padding-top: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="mb-4">Dashboard Admin</h1>
                        <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>! Anda login sebagai <span class="badge bg-primary">admin</span>.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Produk</h5>
                                        <p class="card-text">Kelola produk benih</p>
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-light">Lihat Produk</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Transaksi</h5>
                                        <p class="card-text">Kelola transaksi</p>
                                        <a href="{{ route('admin.transactions') }}" class="btn btn-light">Lihat Transaksi</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Komplain</h5>
                                        <p class="card-text">Kelola komplain pelanggan</p>
                                        <a href="{{ route('admin.complaints.index') }}" class="btn btn-light">Lihat Komplain</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Artikel</h5>
                                        <p class="card-text">Kelola artikel</p>
                                        <a href="{{ route('admin.articles.index') }}" class="btn btn-light">Lihat Artikel</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-secondary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Penyebaran Produk</h5>
                                        <p class="card-text">Visualisasi penyebaran produk di Indonesia</p>
                                        <a href="{{ route('admin.product.distribution') }}" class="btn btn-light">Lihat Peta</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection