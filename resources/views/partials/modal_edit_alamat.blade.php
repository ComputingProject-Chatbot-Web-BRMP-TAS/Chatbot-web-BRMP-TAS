<!-- Modal Edit Alamat (2 langkah) -->
<div class="modal fade" id="modalEditAlamat" tabindex="-1" aria-labelledby="modalEditAlamatLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditAlamatLabel">Edit Alamat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditAlamat" method="POST" action="">
        @csrf
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="redirect_to" value="{{ request()->url() }}">
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