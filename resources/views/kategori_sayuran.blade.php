@extends('layouts.app')
@section('content')
<style>
.kategori-banner {
    margin: 60px 0 32px 0;
}
</style>
<div class="container py-4">
    <div class="mb-4 p-4 rounded-4 kategori-banner" style="background:linear-gradient(90deg,#4CAF50 60%,#FFF176 100%);color:#fff;box-shadow:0 4px 24px rgba(76,175,80,0.10);">
        <h1 class="fw-bold mb-0" style="font-size:2.3rem;letter-spacing:1px;">Sayuran</h1>
        <div style="font-size:1.1rem;opacity:.95;">Benih sayuran segar untuk panen sehat di rumah Anda.</div>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="bg-white rounded-4 p-4 shadow-sm border border-2 border-warning-subtle">
                <div class="fw-bold mb-2 text-warning" style="font-size:1.1rem;">Filter</div>
                <div class="mb-2">Jenis Sayuran</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="bayam"><label class="form-check-label" for="bayam">Bayam</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="kangkung"><label class="form-check-label" for="kangkung">Kangkung</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="wortel"><label class="form-check-label" for="wortel">Wortel</label></div>
                <div class="mt-3 mb-2">Lokasi</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="jakarta"><label class="form-check-label" for="jakarta">Jakarta</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="bandung"><label class="form-check-label" for="bandung">Bandung</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="surabaya"><label class="form-check-label" for="surabaya">Surabaya</label></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="mb-3 text-success fw-semibold">Menampilkan 4 produk untuk "Sayuran"</div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/7/6/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Bayam">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Bayam</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 7.000</div>
                            <div class="card-text mb-2 text-secondary">Bayam hijau segar, mudah tumbuh.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/12/1/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Kangkung">
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
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/10/10/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Wortel">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Wortel</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 10.000</div>
                            <div class="card-text mb-2 text-secondary">Wortel oranye, cocok untuk dataran tinggi.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/1/15/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Sawi">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Sawi</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 9.000</div>
                            <div class="card-text mb-2 text-secondary">Sawi hijau, cocok untuk tumisan.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 