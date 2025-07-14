@extends('layouts.app')
@section('content')
<style>
.kategori-banner {
    margin: 60px 0 32px 0;
}
</style>
<div class="container py-4">
    <div class="mb-4 p-4 rounded-4 kategori-banner" style="background:linear-gradient(90deg,#4CAF50 60%,#FFF176 100%);color:#fff;box-shadow:0 4px 24px rgba(76,175,80,0.10);">
        <h1 class="fw-bold mb-0" style="font-size:2.3rem;letter-spacing:1px;">Buah-Buahan</h1>
        <div style="font-size:1.1rem;opacity:.95;">Benih buah-buahan segar untuk panen sehat di rumah Anda.</div>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="bg-white rounded-4 p-4 shadow-sm border border-2 border-warning-subtle">
                <div class="fw-bold mb-2 text-warning" style="font-size:1.1rem;">Filter</div>
                <div class="mb-2">Jenis Buah</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="melon"><label class="form-check-label" for="melon">Melon</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="semangka"><label class="form-check-label" for="semangka">Semangka</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="tomat"><label class="form-check-label" for="tomat">Tomat</label></div>
                <div class="mt-3 mb-2">Lokasi</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="jakarta"><label class="form-check-label" for="jakarta">Jakarta</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="bandung"><label class="form-check-label" for="bandung">Bandung</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="surabaya"><label class="form-check-label" for="surabaya">Surabaya</label></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="mb-3 text-success fw-semibold">Menampilkan {{ $products->count() }} produk untuk "Buah-Buahan"</div>
            @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $produk)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="{{ asset('images/' . $produk->gambar) }}" class="card-img-top rounded-top-4" alt="{{ $produk->nama }}">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">{{ $produk->nama }}</h5>
                            <div class="mb-1 text-warning fw-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                            <div class="card-text mb-2 text-secondary">{{ $produk->deskripsi }}</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div style="padding:32px 0;text-align:center;color:#888;font-size:18px;">Produk tidak ditemukan.</div>
            @endif
        </div>
    </div>
</div>
@section('after_content')
    @include('partials.mitra_footer')
@endsection
@endsection 