@extends('layouts.app')

@section('content')
<style>
    body { background: #f8f9fa; }
    .profile-tabs {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 32px;
        margin-top: 64px;
        justify-content: flex-start;
    }
    .profile-tab {
        padding: 16px 36px 12px 36px;
        font-weight: 500;
        color: #222;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-size: 1.1rem;
        transition: color 0.2s, border 0.2s;
        text-decoration: none;
    }
    .profile-tab.active {
        color: #4CAF50;
        border-bottom: 3px solid #4CAF50;
        font-weight: 700;
    }
    .addresses-container {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 32px 32px 24px 32px;
        margin-top: 32px;
        justify-items: center;
    }
    .address-add-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }
    .btn-add-address {
        background: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 40%;
        font-weight: 600;
        font-size: 1rem;
        transition: background 0.2s;
        cursor: pointer;
        white-space: nowrap;
    }
    .btn-add-address:hover {
        background: #388E3C;
    }
    .address-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 48px;
        margin-bottom: 48px;
    }
    .address-empty-img {
        width: 220px;
        margin-bottom: 18px;
    }
    .address-empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 8px;
        text-align: center;
    }
    .address-empty-desc {
        color: #666;
        font-size: 1.08rem;
        text-align: center;
    }
    @media (max-width: 900px) {
        .addresses-container { padding: 18px 8px; }
        .profile-tabs { margin-top: 32px; }
    }
</style>
<div class="profile-tabs">
    <a href="{{ route('profile') }}" class="profile-tab @if(Route::currentRouteName() == 'profile') active @endif">Biodata Diri</a>
    <a href="{{ route('addresses') }}" class="profile-tab @if(Route::currentRouteName() == 'addresses') active @endif">Daftar Alamat</a>
</div>
<div class="addresses-container">
    <div class="address-add-row">
        <button class="btn-add-address" id="btnTambahAlamatBaru">+ Tambah Alamat Baru</button>
    </div>
    <div class="address-empty">
        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="Alamat kosong" class="address-empty-img">
        <div class="address-empty-title">Ops!, alamat tidak tersedia</div>
        <div class="address-empty-desc">Kamu bisa tambah alamat baru dengan mengklik tombol di atas.</div>
    </div>
</div>
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<!-- Modal Tambah Alamat Baru -->
<div class="modal fade" id="modalTambahAlamat" tabindex="-1" aria-labelledby="modalTambahAlamatLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="min-width:350px;">
      <div class="modal-header" style="border-bottom:1px solid #eee;">
        <h5 class="modal-title" id="modalTambahAlamatLabel">Tambah Alamat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0" style="border-radius:16px;overflow:hidden;">
        <div class="px-3 pt-3 pb-2">
          <input type="text" id="searchAlamat" class="form-control" placeholder="Cari alamat atau tempat..." style="font-size:1em;">
        </div>
        <div style="position:relative;">
          <div id="gmap" style="height: 250px; width: 100%;"></div>
          <!-- Marker tetap di tengah -->
          <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-100%);pointer-events:none;z-index:500;">
            <img src="/images/marker-point.png" style="width:36px;height:36px;">
          </div>
        </div>
        <button class="btn btn-success w-100 mt-3" id="btnLokasiSaatIni" style="background:#00B14F;border:none;font-weight:600;">Gunakan Lokasi Saat Ini</button>
        <div class="mt-3 px-3">
          <div class="fw-bold" id="alamatTerpilih" style="font-size:1.1em;">Pilih lokasi di peta</div>
        </div>
        <button class="btn w-100 mt-3 mb-2" id="btnPilihLokasi" style="background:#00B14F;color:#fff;font-weight:600;font-size:1.1em;" disabled>Pilih Lokasi Ini</button>
      </div>
    </div>
  </div>
</div>
<!-- Leaflet & Nominatim JS -->
<script>
let leafletMap, lastCenter = {lat: -7.977, lng: 112.634}; // Default Malang
let reverseGeocodeTimeout;

function initLeafletMap() {
    if (leafletMap) return;
    leafletMap = L.map('gmap', {
        center: [lastCenter.lat, lastCenter.lng],
        zoom: 16,
        zoomControl: false,
        attributionControl: false
    });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(leafletMap);

    // Update address saat peta digeser
    leafletMap.on('moveend', function() {
        lastCenter = leafletMap.getCenter();
        updateAddress(lastCenter.lat, lastCenter.lng);
    });

    // Initial address
    updateAddress(lastCenter.lat, lastCenter.lng);
}

function updateAddress(lat, lng) {
    document.getElementById('alamatTerpilih').innerText = 'Mencari alamat...';
    document.getElementById('btnPilihLokasi').disabled = true;
    // Debounce to avoid too many requests
    if (reverseGeocodeTimeout) clearTimeout(reverseGeocodeTimeout);
    reverseGeocodeTimeout = setTimeout(() => {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById('alamatTerpilih').innerText = data.display_name;
                    document.getElementById('btnPilihLokasi').disabled = false;
                } else {
                    document.getElementById('alamatTerpilih').innerText = 'Alamat tidak ditemukan';
                    document.getElementById('btnPilihLokasi').disabled = true;
                }
            })
            .catch(() => {
                document.getElementById('alamatTerpilih').innerText = 'Alamat tidak ditemukan';
                document.getElementById('btnPilihLokasi').disabled = true;
            });
    }, 300);
}

// Perbaikan: gunakan event Bootstrap modal 'shown.bs.modal' untuk inisialisasi peta dan invalidateSize
const modalTambahAlamat = document.getElementById('modalTambahAlamat');
modalTambahAlamat.addEventListener('shown.bs.modal', function () {
    initLeafletMap();
    setTimeout(() => {
        leafletMap.invalidateSize();
        leafletMap.setView([lastCenter.lat, lastCenter.lng], 16);
    }, 100); // Sedikit delay agar modal benar-benar terbuka
});

document.getElementById('btnTambahAlamatBaru').onclick = function() {
    var modal = new bootstrap.Modal(document.getElementById('modalTambahAlamat'));
    modal.show();
    // Tidak perlu lagi inisialisasi peta di sini
};

document.getElementById('btnLokasiSaatIni').onclick = function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            let lat = pos.coords.latitude;
            let lng = pos.coords.longitude;
            lastCenter = {lat, lng};
            leafletMap.setView([lat, lng], 16);
        });
    }
};

// Search bar untuk pencarian alamat
const searchAlamat = document.getElementById('searchAlamat');
if (searchAlamat) {
  searchAlamat.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      let query = this.value.trim();
      if (!query) return;
      fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
          if (data && data.length > 0) {
            let lat = parseFloat(data[0].lat);
            let lon = parseFloat(data[0].lon);
            lastCenter = {lat, lng: lon};
            leafletMap.setView([lat, lon], 17);
          } else {
            alert('Alamat tidak ditemukan');
          }
        });
    }
  });
}
</script>
@endsection 