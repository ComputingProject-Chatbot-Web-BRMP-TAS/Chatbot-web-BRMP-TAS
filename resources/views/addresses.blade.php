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
    .btn-add-address {
        background: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 16px;
        font-weight: 600;
        font-size: 1rem;
        transition: background 0.2s;
        cursor: pointer;
        white-space: nowrap;
        width: 100%;
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
    .address-card-clickable {
        cursor: pointer;
        transition: box-shadow 0.2s, border 0.2s;
        border: 2px solid transparent;
    }
    .address-card-clickable:hover {
        box-shadow: 0 4px 16px rgba(76,175,80,0.10);
        border: 2px solid #4CAF50;
        background: #f6fff6;
    }
    .address-card-primary {
        border: 2px solid #4CAF50;
        background: #f6fff6;
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
    <button class="btn-add-address" id="btnTambahAlamatBaru">+ Tambah Alamat Baru</button>
    @if(isset($addresses) && count($addresses) > 0)
        <div class="mt-4">
            @foreach($addresses as $address)
                <div class="mb-3 position-relative">
                    <form method="POST" action="{{ route('addresses.setPrimary', $address) }}">
                        @csrf
                        <div class="card @if($address->is_primary) address-card-primary @elseif(!$address->is_primary) address-card-clickable @endif" style="border-radius:12px;box-shadow:0 1px 6px rgba(0,0,0,0.04);" @if(!$address->is_primary) onclick="this.closest('form').submit();" @endif>
                            <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                                <div style="flex:1;">
                                    @if($address->is_primary)
                                        <span class="badge bg-success mb-2">Utama</span><br>
                                    @endif
                                    <div class="fw-bold" style="font-size:1.1em;">{{ $address->label ?? 'Alamat' }}</div>
                                    <div style="color:#555;font-size:0.98em;">{{ $address->address }}</div>
                                    <div style="color:#888;font-size:0.93em;">({{ $address->latitude }}, {{ $address->longitude }})</div>
                                    @if($address->note)
                                        <div style="color:#888;font-size:0.93em;">Catatan: {{ $address->note }}</div>
                                    @endif
                                    <div style="color:#888;font-size:0.93em;">Penerima: {{ $address->recipient_name }} ({{ $address->recipient_phone }})</div>
                                    <div class="mt-2 d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="editAlamat({{ $address->id }}, event)"
                                            data-id="{{ $address->id }}"
                                            data-label="{{ $address->label }}"
                                            data-address="{{ $address->address }}"
                                            data-latitude="{{ $address->latitude }}"
                                            data-longitude="{{ $address->longitude }}"
                                            data-note="{{ $address->note }}"
                                            data-recipient_name="{{ $address->recipient_name }}"
                                            data-recipient_phone="{{ $address->recipient_phone }}"
                                        >Edit</button>
                                        @if(!$address->is_primary)
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapusAlamat{{ $address->id }}(event)">Hapus</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form id="formHapusAlamat{{ $address->id }}" method="POST" action="{{ route('addresses.destroy', $address) }}" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <script>
                    function hapusAlamat{{ $address->id }}(e) {
                        e.stopPropagation();
                        if(confirm('Hapus alamat ini?')) {
                            document.getElementById('formHapusAlamat{{ $address->id }}').submit();
                        }
                    }
                    function editAlamat(id, e) {
                        e.stopPropagation();
                        // Ambil tombol yang diklik
                        var btn = event.currentTarget;
                        // Isi field modal edit
                        document.getElementById('editLabelInput').value = btn.getAttribute('data-label') || '';
                        document.getElementById('editAlamatTerpilihInput').value = btn.getAttribute('data-address') || '';
                        document.getElementById('editNoteInput').value = btn.getAttribute('data-note') || '';
                        document.getElementById('editRecipientNameInput').value = btn.getAttribute('data-recipient_name') || '';
                        document.getElementById('editRecipientPhoneInput').value = btn.getAttribute('data-recipient_phone') || '';
                        document.getElementById('editLatitudeInput').value = btn.getAttribute('data-latitude') || '';
                        document.getElementById('editLongitudeInput').value = btn.getAttribute('data-longitude') || '';
                        document.getElementById('editAlamatTerpilih').innerText = btn.getAttribute('data-address') || 'Pilih lokasi di peta';
                        // Set action form
                        document.getElementById('formEditAlamat').action = '/addresses/' + btn.getAttribute('data-id');
                        // Reset stepper ke step 2 (langsung ke detail, user bisa klik kembali ke peta jika mau)
                        document.getElementById('editStep1Alamat').style.display = 'none';
                        document.getElementById('editStep2Alamat').style.display = 'block';
                        // Tampilkan modal
                        var modal = new bootstrap.Modal(document.getElementById('modalEditAlamat'));
                        modal.show();
                    }
                    </script>
                </div>
            @endforeach
        </div>
    @else
        <div class="address-empty">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="Alamat kosong" class="address-empty-img">
            <div class="address-empty-title">Ops!, alamat tidak tersedia</div>
            <div class="address-empty-desc">Kamu bisa tambah alamat baru dengan mengklik tombol di atas.</div>
        </div>
    @endif
</div>
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<!-- Modal Tambah Alamat Baru (2 langkah) -->
<div class="modal fade" id="modalTambahAlamat" tabindex="-1" aria-labelledby="modalTambahAlamatLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahAlamatLabel">Tambah Alamat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formTambahAlamat" method="POST" action="{{ route('addresses.store') }}">
        @csrf
        <div class="modal-body p-0" style="border-radius:16px;overflow:hidden;">
          <!-- STEP 1: PILIH LOKASI -->
          <div id="step1Alamat" class="step-alamat">
            <div class="px-3 pt-3 pb-3">
              <input type="text" id="searchAlamat" class="form-control" placeholder="Cari alamat atau tempat..." style="font-size:1em;">
            </div>
            <div style="position:relative;">
              <div id="gmap" style="height: 250px; width: 100%;"></div>
              <!-- Marker tetap di tengah -->
              <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-100%);pointer-events:none;z-index:500;">
                <img src="/images/marker-point.png" style="width:36px;height:36px;">
              </div>
            </div>
            <input type="hidden" name="latitude" id="latitudeInput">
            <input type="hidden" name="longitude" id="longitudeInput">
            <div class="px-3 pt-3 pb-3">
              <button type="button" class="btn btn-success w-100" id="btnLokasiSaatIni">Gunakan Lokasi Saat Ini</button>
            </div>
            <div class="px-3">
              <div class="fw-bold" id="alamatTerpilih" style="font-size:1.1em;">Pilih lokasi di peta</div>
            </div>
            <div class="px-3 pt-3 pb-3">    
              <button type="button" class="btn btn-success w-100" id="btnPilihLokasi" disabled>Pilih Lokasi Ini</button>
            </div>
          </div>
          <!-- STEP 2: DETAIL ALAMAT -->
          <div id="step2Alamat" class="step-alamat" style="display:none;">
            <div class="px-3 pt-3 pb-2">
              <label class="form-label">Label Alamat</label>
              <input type="text" name="label" class="form-control" placeholder="Rumah, Kantor, dll">
            </div>
            <div class="px-3 pb-2">
              <label class="form-label">Alamat Lengkap</label>
              <input type="text" id="alamatTerpilihInput" name="address" class="form-control" required>
            </div>
            <div class="px-3 pb-2">
              <label class="form-label">Catatan untuk Kurir <span style="color:#888;font-size:0.95em;">(opsional)</span></label>
              <input type="text" name="note" class="form-control" placeholder="Contoh: Patokan rumah, lantai, dsb">
            </div>
            <div class="px-3 pb-2">
              <label class="form-label">Nama Penerima</label>
              <input type="text" name="recipient_name" class="form-control" required value="{{ Auth::user()->name }}">
            </div>
            <div class="px-3 pb-3">
              <label class="form-label">Nomor Telepon Penerima</label>
              <input type="tel" name="recipient_phone" class="form-control" required pattern="^(08|628)[0-9]{7,11}$" placeholder="Contoh: 08123456789" value="{{ Auth::user()->phone }}">
            </div>
            <div class="px-3 pb-3 d-flex gap-2">
              <button type="button" class="btn btn-outline-secondary w-50" id="btnAlamatBack">Kembali</button>
              <button type="submit" class="btn btn-success w-50">Simpan Alamat</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Edit Alamat (2 langkah) -->
<div class="modal fade" id="modalEditAlamat" tabindex="-1" aria-labelledby="modalEditAlamatLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditAlamatLabel">Edit Alamat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditAlamat" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PATCH">
        <div class="modal-body p-0" style="border-radius:16px;overflow:hidden;">
          <!-- STEP 1: PILIH LOKASI -->
          <div id="editStep1Alamat" class="step-alamat">
            <div class="px-3 pt-3 pb-3">
              <input type="text" id="editSearchAlamat" class="form-control" placeholder="Cari alamat atau tempat..." style="font-size:1em;">
            </div>
            <div style="position:relative;">
              <div id="editGmap" style="height: 250px; width: 100%;"></div>
              <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-100%);pointer-events:none;z-index:500;">
                <img src="/images/marker-point.png" style="width:36px;height:36px;">
              </div>
            </div>
            <input type="hidden" name="latitude" id="editLatitudeInput">
            <input type="hidden" name="longitude" id="editLongitudeInput">
            <div class="px-3 pt-3 pb-3">
              <button type="button" class="btn btn-success w-100" id="editBtnLokasiSaatIni">Gunakan Lokasi Saat Ini</button>
            </div>
            <div class="px-3">
              <div class="fw-bold" id="editAlamatTerpilih" style="font-size:1.1em;">Pilih lokasi di peta</div>
            </div>
            <div class="px-3 pt-3 pb-3">    
              <button type="button" class="btn btn-success w-100" id="editBtnPilihLokasi">Pilih Lokasi Ini</button>
            </div>
          </div>
          <!-- STEP 2: DETAIL ALAMAT -->
          <div id="editStep2Alamat" class="step-alamat" style="display:none;">
            <div class="px-3 pt-3 pb-2">
              <label class="form-label">Label Alamat</label>
              <input type="text" name="label" id="editLabelInput" class="form-control" placeholder="Rumah, Kantor, dll">
            </div>
            <div class="px-3 pb-2">
              <label class="form-label">Alamat Lengkap</label>
              <input type="text" id="editAlamatTerpilihInput" name="address" class="form-control" required>
            </div>
            <div class="px-3 pb-2">
              <label class="form-label">Catatan untuk Kurir <span style="color:#888;font-size:0.95em;">(opsional)</span></label>
              <input type="text" name="note" id="editNoteInput" class="form-control" placeholder="Contoh: Patokan rumah, lantai, dsb">
            </div>
            <div class="px-3 pb-2">
              <label class="form-label">Nama Penerima</label>
              <input type="text" name="recipient_name" id="editRecipientNameInput" class="form-control" required>
            </div>
            <div class="px-3 pb-3">
              <label class="form-label">Nomor Telepon Penerima</label>
              <input type="tel" name="recipient_phone" id="editRecipientPhoneInput" class="form-control" required pattern="^(08|628)[0-9]{7,11}$" placeholder="Contoh: 08123456789">
            </div>
            <div class="px-3 pb-3 d-flex gap-2">
              <button type="button" class="btn btn-success w-50" id="editBtnAlamatBack">Ubah Pinpoint Lokasi</button>
              <button type="submit" class="btn btn-success w-50">Simpan Perubahan</button>
            </div>
          </div>
        </div>
      </form>
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
    document.getElementById('alamatTerpilihInput').value = '';
    document.getElementById('latitudeInput').value = lat;
    document.getElementById('longitudeInput').value = lng;
    // Debounce to avoid too many requests
    if (reverseGeocodeTimeout) clearTimeout(reverseGeocodeTimeout);
    reverseGeocodeTimeout = setTimeout(() => {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById('alamatTerpilih').innerText = data.display_name;
                    document.getElementById('alamatTerpilihInput').value = data.display_name;
                    document.getElementById('btnPilihLokasi').disabled = false;
                } else {
                    document.getElementById('alamatTerpilih').innerText = 'Alamat tidak ditemukan';
                    document.getElementById('alamatTerpilihInput').value = '';
                    document.getElementById('btnPilihLokasi').disabled = true;
                }
            })
            .catch(() => {
                document.getElementById('alamatTerpilih').innerText = 'Alamat tidak ditemukan';
                document.getElementById('alamatTerpilihInput').value = '';
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

// Stepper logic
const step1 = document.getElementById('step1Alamat');
const step2 = document.getElementById('step2Alamat');
const btnPilihLokasi = document.getElementById('btnPilihLokasi');
const btnAlamatBack = document.getElementById('btnAlamatBack');

if(btnPilihLokasi) {
  btnPilihLokasi.onclick = function(e) {
      e.preventDefault();
      // Pastikan data sudah terisi
      if(document.getElementById('alamatTerpilihInput').value && document.getElementById('latitudeInput').value && document.getElementById('longitudeInput').value) {
          step1.style.display = 'none';
          step2.style.display = 'block';
      }
  };
}
if(btnAlamatBack) {
  btnAlamatBack.onclick = function(e) {
    e.preventDefault();
    step2.style.display = 'none';
    step1.style.display = 'block';
  };
}
// Saat modal dibuka, reset ke step 1
modalTambahAlamat.addEventListener('show.bs.modal', function () {
    step1.style.display = 'block';
    step2.style.display = 'none';
});

// Stepper logic untuk modal edit alamat
const editStep1 = document.getElementById('editStep1Alamat');
const editStep2 = document.getElementById('editStep2Alamat');
const editBtnPilihLokasi = document.getElementById('editBtnPilihLokasi');
const editBtnAlamatBack = document.getElementById('editBtnAlamatBack');
let editLeafletMap, editLastCenter = {lat: -7.977, lng: 112.634};
let editMapJustInitialized = false;
let editReverseGeocodeTimeout;

function initEditLeafletMap(lat, lng) {
    if (editLeafletMap) {
        editMapJustInitialized = true;
        editLeafletMap.setView([lat, lng], 16);
        return;
    }
    editLeafletMap = L.map('editGmap', {
        center: [lat, lng],
        zoom: 16,
        zoomControl: false,
        attributionControl: false
    });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(editLeafletMap);
    editLeafletMap.on('moveend', function() {
        if (editMapJustInitialized) {
            editMapJustInitialized = false;
            return; // Jangan update alamat pada inisialisasi
        }
        editLastCenter = editLeafletMap.getCenter();
        updateEditAddress(editLastCenter.lat, editLastCenter.lng);
    });
    // Jangan panggil updateEditAddress di sini!
}

function updateEditAddress(lat, lng) {
    document.getElementById('editAlamatTerpilih').innerText = 'Mencari alamat...';
    document.getElementById('editBtnPilihLokasi').disabled = true;
    document.getElementById('editAlamatTerpilihInput').value = '';
    document.getElementById('editLatitudeInput').value = lat;
    document.getElementById('editLongitudeInput').value = lng;
    if (editReverseGeocodeTimeout) clearTimeout(editReverseGeocodeTimeout);
    editReverseGeocodeTimeout = setTimeout(() => {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById('editAlamatTerpilih').innerText = data.display_name;
                    document.getElementById('editAlamatTerpilihInput').value = data.display_name;
                    document.getElementById('editBtnPilihLokasi').disabled = false;
                } else {
                    document.getElementById('editAlamatTerpilih').innerText = 'Alamat tidak ditemukan';
                    document.getElementById('editAlamatTerpilihInput').value = '';
                    document.getElementById('editBtnPilihLokasi').disabled = true;
                }
            })
            .catch(() => {
                document.getElementById('editAlamatTerpilih').innerText = 'Alamat tidak ditemukan';
                document.getElementById('editAlamatTerpilihInput').value = '';
                document.getElementById('editBtnPilihLokasi').disabled = true;
            });
    }, 300);
}

// Search bar untuk pencarian alamat di modal edit
const editSearchAlamat = document.getElementById('editSearchAlamat');
if (editSearchAlamat) {
  editSearchAlamat.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      let query = this.value.trim();
      if (!query) return;
      fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
          if (data && data.length > 0) {
            let lat = parseFloat(data[0].lat);
            let lon = parseFloat(data[0].lon);
            editLastCenter = {lat, lng: lon};
            editLeafletMap.setView([lat, lon], 17);
          } else {
            alert('Alamat tidak ditemukan');
          }
        });
    }
  });
}

document.getElementById('editBtnLokasiSaatIni').onclick = function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            let lat = pos.coords.latitude;
            let lng = pos.coords.longitude;
            editLastCenter = {lat, lng};
            editLeafletMap.setView([lat, lng], 16);
        });
    }
};

if(editBtnPilihLokasi) {
  editBtnPilihLokasi.onclick = function(e) {
      e.preventDefault();
      if(document.getElementById('editAlamatTerpilihInput').value && document.getElementById('editLatitudeInput').value && document.getElementById('editLongitudeInput').value) {
          editStep1.style.display = 'none';
          editStep2.style.display = 'block';
      }
  };
}
if(editBtnAlamatBack) {
  editBtnAlamatBack.onclick = function(e) {
    e.preventDefault();
    editStep2.style.display = 'none';
    editStep1.style.display = 'block';
    // Saat kembali ke peta, pastikan peta resize
    setTimeout(() => {
      if(editLeafletMap) editLeafletMap.invalidateSize();
    }, 100);
  };
}
// Saat modal edit dibuka, inisialisasi peta dan stepper
const modalEditAlamat = document.getElementById('modalEditAlamat');
modalEditAlamat.addEventListener('shown.bs.modal', function () {
    // Ambil koordinat dari field (jika ada)
    let lat = parseFloat(document.getElementById('editLatitudeInput').value) || -7.977;
    let lng = parseFloat(document.getElementById('editLongitudeInput').value) || 112.634;
    initEditLeafletMap(lat, lng);
    setTimeout(() => {
        if(editLeafletMap) editLeafletMap.invalidateSize();
    }, 100);
});
</script>
@endsection 