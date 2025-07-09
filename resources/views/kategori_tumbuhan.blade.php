@extends('layouts.app')
@section('content')
<style>
.kategori-banner {
    margin: 60px 0 32px 0;
}
</style>
<div class="container py-4">
    <div class="mb-4 p-4 rounded-4 kategori-banner" style="background:linear-gradient(90deg,#4CAF50 60%,#FFF176 100%);color:#fff;box-shadow:0 4px 24px rgba(76,175,80,0.10);">
        <h1 class="fw-bold mb-0" style="font-size:2.3rem;letter-spacing:1px;">Tumbuhan</h1>
        <div style="font-size:1.1rem;opacity:.95;">Temukan berbagai benih tumbuhan terbaik untuk kebun dan rumah Anda.</div>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="bg-white rounded-4 p-4 shadow-sm border border-2 border-warning-subtle">
                <div class="fw-bold mb-2 text-warning" style="font-size:1.1rem;">Filter</div>
                <div class="mb-2">Jenis Tumbuhan</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="sayuran"><label class="form-check-label" for="sayuran">Sayuran</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="buah"><label class="form-check-label" for="buah">Buah</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="herbal"><label class="form-check-label" for="herbal">Herbal</label></div>
                <div class="mt-3 mb-2">Lokasi</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="jakarta"><label class="form-check-label" for="jakarta">Jakarta</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="bandung"><label class="form-check-label" for="bandung">Bandung</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="surabaya"><label class="form-check-label" for="surabaya">Surabaya</label></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="mb-3 text-success fw-semibold">Menampilkan 5 produk untuk "Tumbuhan"</div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/7/6/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Cabai Rawit">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Cabai Rawit</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 15.000</div>
                            <div class="card-text mb-2 text-secondary">Isi 50 butir, cocok untuk pekarangan rumah.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/12/1/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Tomat">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Tomat</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 12.000</div>
                            <div class="card-text mb-2 text-secondary">Tahan penyakit, hasil melimpah.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/10/10/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Kangkung">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Kangkung</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 8.000</div>
                            <div class="card-text mb-2 text-secondary">Cepat panen, cocok untuk hidroponik.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/1/15/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Bayam">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Bayam</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 7.000</div>
                            <div class="card-text mb-2 text-secondary">Bayam hijau segar, mudah tumbuh.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 