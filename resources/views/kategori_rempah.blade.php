@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="mb-4 p-4 rounded-4" style="background:linear-gradient(90deg,#4CAF50 60%,#FFF176 100%);color:#fff;box-shadow:0 4px 24px rgba(76,175,80,0.10);">
        <h1 class="fw-bold mb-0" style="font-size:2.3rem;letter-spacing:1px;">Rempah-Rempah/Herbal</h1>
        <div style="font-size:1.1rem;opacity:.95;">Aneka benih rempah dan herbal untuk kesehatan dan masakan Anda.</div>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="bg-white rounded-4 p-4 shadow-sm border border-2 border-warning-subtle">
                <div class="fw-bold mb-2 text-warning" style="font-size:1.1rem;">Filter</div>
                <div class="mb-2">Jenis Rempah</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="jahe"><label class="form-check-label" for="jahe">Jahe</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="kunyit"><label class="form-check-label" for="kunyit">Kunyit</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="temulawak"><label class="form-check-label" for="temulawak">Temulawak</label></div>
                <div class="mt-3 mb-2">Lokasi</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="jakarta"><label class="form-check-label" for="jakarta">Jakarta</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="bandung"><label class="form-check-label" for="bandung">Bandung</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="surabaya"><label class="form-check-label" for="surabaya">Surabaya</label></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="mb-3 text-success fw-semibold">Menampilkan 4 produk untuk "Rempah-Rempah/Herbal"</div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/7/6/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Jahe">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Jahe</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 18.000</div>
                            <div class="card-text mb-2 text-secondary">Jahe merah, cocok untuk minuman herbal.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/12/1/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Kunyit">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Kunyit</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 14.000</div>
                            <div class="card-text mb-2 text-secondary">Kunyit kuning, segar dan berkualitas.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/10/10/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Temulawak">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Temulawak</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 16.000</div>
                            <div class="card-text mb-2 text-secondary">Temulawak segar, cocok untuk jamu.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/1/15/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Herbal Mix">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Herbal Mix</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 20.000</div>
                            <div class="card-text mb-2 text-secondary">Campuran rempah herbal untuk kesehatan.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 