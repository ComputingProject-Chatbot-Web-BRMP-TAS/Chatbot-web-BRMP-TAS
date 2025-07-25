<!-- Modal Tambah Alamat Baru (2 langkah) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<div class="modal fade" id="modalTambahAlamat" tabindex="-1" aria-labelledby="modalTambahAlamatLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahAlamatLabel">Tambah Alamat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formTambahAlamat" method="POST" action="{{ route('addresses.store') }}">
        @csrf
        <input type="hidden" name="redirect_to" value="{{ request()->url() }}">
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
<script>
let leafletMap, lastCenter = {lat: -7.977, lng: 112.634};
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
    leafletMap.on('moveend', function() {
        lastCenter = leafletMap.getCenter();
        updateAddress(lastCenter.lat, lastCenter.lng);
    });
    updateAddress(lastCenter.lat, lastCenter.lng);
}
function updateAddress(lat, lng) {
    document.getElementById('alamatTerpilih').innerText = 'Mencari alamat...';
    document.getElementById('btnPilihLokasi').disabled = true;
    document.getElementById('alamatTerpilihInput').value = '';
    document.getElementById('latitudeInput').value = lat;
    document.getElementById('longitudeInput').value = lng;
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
const modalTambahAlamat = document.getElementById('modalTambahAlamat');
if(modalTambahAlamat) {
    modalTambahAlamat.addEventListener('shown.bs.modal', function () {
        initLeafletMap();
        setTimeout(() => {
            leafletMap.invalidateSize();
            leafletMap.setView([lastCenter.lat, lastCenter.lng], 16);
        }, 100);
    });
}
document.getElementById('btnLokasiSaatIni')?.addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            let lat = pos.coords.latitude;
            let lng = pos.coords.longitude;
            lastCenter = {lat, lng};
            leafletMap.setView([lat, lng], 16);
        });
    }
});
const searchAlamat = document.getElementById('searchAlamat');
if (searchAlamat) {
  searchAlamat.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
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
const step1 = document.getElementById('step1Alamat');
const step2 = document.getElementById('step2Alamat');
const btnPilihLokasi = document.getElementById('btnPilihLokasi');
const btnAlamatBack = document.getElementById('btnAlamatBack');
if(btnPilihLokasi) {
  btnPilihLokasi.onclick = function(e) {
      e.preventDefault();
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
if(modalTambahAlamat) {
    modalTambahAlamat.addEventListener('show.bs.modal', function () {
        step1.style.display = 'block';
        step2.style.display = 'none';
    });
}
// Form submission tradisional - tidak perlu AJAX
// Form akan submit biasa dan redirect sesuai redirect_to
</script> 