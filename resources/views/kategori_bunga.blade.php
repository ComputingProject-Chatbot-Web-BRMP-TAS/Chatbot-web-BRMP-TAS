@extends('layouts.app')
@section('content')
<style>
.kategori-banner {
    margin: 60px 0 32px 0;
}
</style>
<div class="container py-4">
    <div class="mb-4 p-4 rounded-4 kategori-banner" style="background:linear-gradient(90deg,#4CAF50 60%,#FFF176 100%);color:#fff;box-shadow:0 4px 24px rgba(76,175,80,0.10);">
        <h1 class="fw-bold mb-0" style="font-size:2.3rem;letter-spacing:1px;">Bunga</h1>
        <div style="font-size:1.1rem;opacity:.95;">Benih bunga indah untuk taman dan dekorasi rumah Anda.</div>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="bg-white rounded-4 p-4 shadow-sm border border-2 border-warning-subtle">
                <div class="fw-bold mb-2 text-warning" style="font-size:1.1rem;">Filter</div>
                <div class="mb-2">Jenis Bunga</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="mawar"><label class="form-check-label" for="mawar">Mawar</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="melati"><label class="form-check-label" for="melati">Melati</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="anggrek"><label class="form-check-label" for="anggrek">Anggrek</label></div>
                <div class="mt-3 mb-2">Lokasi</div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="jakarta"><label class="form-check-label" for="jakarta">Jakarta</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="bandung"><label class="form-check-label" for="bandung">Bandung</label></div>
                <div class="form-check mb-1"><input class="form-check-input" type="checkbox" id="surabaya"><label class="form-check-label" for="surabaya">Surabaya</label></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="mb-3 text-success fw-semibold">Menampilkan 4 produk untuk "Bunga"</div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/7/6/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Mawar">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Mawar</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 20.000</div>
                            <div class="card-text mb-2 text-secondary">Mawar merah, harum dan indah.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/12/1/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Melati">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Melati</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 18.000</div>
                            <div class="card-text mb-2 text-secondary">Melati putih, harum dan segar.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/10/10/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Anggrek">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Anggrek</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 25.000</div>
                            <div class="card-text mb-2 text-secondary">Anggrek bulan, mudah tumbuh.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/1/15/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" class="card-img-top rounded-top-4" alt="Benih Bunga Matahari">
                        <div class="card-body bg-white rounded-bottom-4">
                            <h5 class="card-title fw-bold text-success">Benih Bunga Matahari</h5>
                            <div class="mb-1 text-warning fw-bold">Rp 15.000</div>
                            <div class="card-text mb-2 text-secondary">Bunga matahari, cerah dan indah.</div>
                            <span class="badge bg-warning text-success fw-semibold">Baru</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 