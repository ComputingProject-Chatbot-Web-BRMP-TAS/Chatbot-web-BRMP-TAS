@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <style>
        body { background: #f8f9fa; }
        .profile-tabs {
            display: flex;
            gap: 0;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 32px;
            margin-top: 64px; /* dinaikkan jarak dari appbar */
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
            text-decoration: none; /* pastikan tidak ada underline */
        }
        .profile-tab:focus, .profile-tab:active, .profile-tab:hover {
            text-decoration: none;
        }
        .profile-tab.active {
            color: #4CAF50;
            border-bottom: 3px solid #4CAF50;
            font-weight: 700;
        }
        .profile-main {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            max-width: 900px;
            margin: 0 auto;
        }
        .profile-left {
            width: 260px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 28px 18px 18px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #E0F2F1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            overflow: hidden;
        }
        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .profile-photo i {
            color: #4CAF50;
            font-size: 64px;
        }
        .btn-upload {
            background: #fff;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 0;
            width: 100%;
            font-weight: 600;
            color: #388E3C;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background 0.2s, border 0.2s;
        }
        .btn-upload:hover {
            background: #FFF176;
            border-color: #FFF176;
        }
        .profile-file-info {
            font-size: 13px;
            color: #888;
            text-align: center;
            margin-bottom: 18px;
        }
        .profile-actions {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }
        .profile-actions button {
            width: 100%;
            padding: 10px 0;
            border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            background: #fff;
            color: #222;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s, border 0.2s;
        }
        .profile-actions button:hover {
            background: #eaffea;
            border-color: #4CAF50;
        }
        .profile-actions .btn-yellow {
            background: #FFF176;
            color: #388E3C;
            border: none;
            font-weight: 600;
        }
        .profile-actions .btn-yellow:hover {
            background: #FFEB3B;
        }
        .profile-right {
            flex: 1;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 32px 32px 24px 32px;
        }
        .profile-section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #388E3C;
            margin-bottom: 18px;
        }
        .profile-info-row {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
        }
        .profile-info-label {
            width: 140px;
            color: #888;
            font-weight: 500;
            font-size: 1rem;
        }
        .profile-info-value {
            color: #222;
            font-size: 1rem;
            font-weight: 500;
        }
        .profile-info-action {
            margin-left: 18px;
            color: #4CAF50;
            font-weight: 600;
            font-size: 0.98rem;
            cursor: pointer;
            text-decoration: none; /* pastikan tidak ada underline */
        }
        .profile-info-action:hover, .profile-info-action:focus, .profile-info-action:active {
            text-decoration: none;
        }
        .profile-info-badge {
            background: #eaffea;
            color: #388E3C;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 6px;
            padding: 3px 10px;
            margin-left: 10px;
        }
        @media (max-width: 900px) {
            .profile-main { flex-direction: column; gap: 18px; }
            .profile-left, .profile-right { width: 100%; max-width: 100%; }
            .profile-right { padding: 18px 8px; }
        }
    </style>
    <div class="profile-tabs">
        <a href="{{ route('profile') }}" class="profile-tab @if(Route::currentRouteName() == 'profile') active @endif">Biodata Diri</a>
        <a href="{{ route('addresses') }}" class="profile-tab @if(Route::currentRouteName() == 'addresses') active @endif">Daftar Alamat</a>
    </div>
    <div class="profile-main">
        <div class="profile-left">
            <div class="profile-photo">
                @if(Auth::user()->profile_photo_url ?? false)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil">
                @else
                    <i class="fas fa-user-circle"></i>
                @endif
            </div>
            <form method="POST" action="#" enctype="multipart/form-data" style="width:100%;">
                <button type="button" class="btn-upload">Pilih Foto</button>
            </form>
            <div class="profile-file-info">
                Besar file: maksimum 10.000.000 bytes (10 Megabytes).<br>
                Ekstensi file yang diperbolehkan: JPG, JPEG, PNG
            </div>
            <div class="profile-actions">
                <button>Ganti Kata Sandi</button>
            </div>
        </div>
        <div class="profile-right">
            <div class="profile-section-title">Ubah Biodata Diri</div>
            <div class="profile-info-row">
                <div class="profile-info-label">Nama</div>
                <div class="profile-info-value">{{ Auth::user()->name }}</div>
                <div class="profile-info-action" data-bs-toggle="modal" data-bs-target="#modalEditNama">Ubah</div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-label">Tanggal Lahir</div>
                @if(Auth::user()->birth_date ?? false)
                    <div class="profile-info-value">{{ Auth::user()->birth_date }}</div>
                    <div class="profile-info-action" data-bs-toggle="modal" data-bs-target="#modalEditTanggalLahir">Ubah</div>
                @else
                    <div class="profile-info-value" style="color:#4CAF50; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalEditTanggalLahir">Tambah Tanggal Lahir</div>
                @endif
            </div>
            <div class="profile-info-row">
                <div class="profile-info-label">Jenis Kelamin</div>
                @if(Auth::user()->gender ?? false)
                    <div class="profile-info-value">{{ Auth::user()->gender }}</div>
                    <div class="profile-info-action" data-bs-toggle="modal" data-bs-target="#modalEditJenisKelamin">Ubah</div>
                @else
                    <div class="profile-info-value" style="color:#4CAF50; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalEditJenisKelamin">Tambah Jenis Kelamin</div>
                @endif
            </div>
            <div class="profile-section-title" style="margin-top:32px;">Ubah Kontak</div>
            <div class="profile-info-row">
                <div class="profile-info-label">Email</div>
                <div class="profile-info-value">{{ Auth::user()->email }}</div>
                <div class="profile-info-action" data-bs-toggle="modal" data-bs-target="#modalEditEmail">Ubah</div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-label">Nomor HP</div>
                @if(Auth::user()->phone ?? false)
                    <div class="profile-info-value">{{ Auth::user()->phone }}</div>
                    <div class="profile-info-action" data-bs-toggle="modal" data-bs-target="#modalEditPhone">Ubah</div>
                @else
                    <div class="profile-info-value" style="color:#4CAF50; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalEditPhone">Tambah Nomor HP</div>
                @endif
            </div>
        </div>
    </div>

<!-- Modal Edit Nama -->
<div class="modal fade" id="modalEditNama" tabindex="-1" aria-labelledby="modalEditNamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditNamaLabel">Ubah Nama</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2" style="color:#666;">Kamu hanya dapat mengubah nama 1 kali lagi. Pastikan nama sudah benar.</div>
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          <div class="mb-3">
            <label for="inputNama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="inputNama" name="name" value="{{ Auth::user()->name }}">
            <div class="form-text">Nama dapat dilihat oleh pengguna lainnya</div>
          </div>
          <button type="submit" class="btn btn-success w-100">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit Email -->
<div class="modal fade" id="modalEditEmail" tabindex="-1" aria-labelledby="modalEditEmailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditEmailLabel">Ubah Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" value="{{ Auth::user()->email }}">
          </div>
          <button type="submit" class="btn btn-success w-100" disabled>Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit Tanggal Lahir -->
<div class="modal fade" id="modalEditTanggalLahir" tabindex="-1" aria-labelledby="modalEditTanggalLahirLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditTanggalLahirLabel">Tambah Tanggal Lahir</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2" style="color:#666;">Kamu hanya dapat mengatur tanggal lahir satu kali. Pastikan tanggal lahir sudah benar.</div>
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          <div class="row mb-3">
            <div class="col">
              <input type="number" class="form-control" name="birth_date_day" min="1" max="31" placeholder="Tanggal" required>
            </div>
            <div class="col">
              <input type="number" class="form-control" name="birth_date_month" min="1" max="12" placeholder="Bulan" required>
            </div>
            <div class="col">
              <input type="number" class="form-control" name="birth_date_year" min="1900" max="{{ date('Y') }}" placeholder="Tahun" required>
            </div>
          </div>
          <button type="submit" class="btn btn-success w-100">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit Jenis Kelamin -->
<div class="modal fade" id="modalEditJenisKelamin" tabindex="-1" aria-labelledby="modalEditJenisKelaminLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditJenisKelaminLabel">Tambah Jenis Kelamin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2" style="color:#666;">Kamu hanya dapat mengubah data jenis kelamin 1 kali lagi. Pastikan data sudah benar</div>
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          <div class="d-flex justify-content-center gap-4 mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="gender" id="genderPria" value="Pria" checked>
              <label class="form-check-label" for="genderPria">
                <i class="fas fa-male" style="font-size:2rem;color:#4CAF50;"></i><br>Pria
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="gender" id="genderWanita" value="Wanita">
              <label class="form-check-label" for="genderWanita">
                <i class="fas fa-female" style="font-size:2rem;color:#aaa;"></i><br>Wanita
              </label>
            </div>
          </div>
          <button type="submit" class="btn btn-success w-100">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit Nomor HP -->
<div class="modal fade" id="modalEditPhone" tabindex="-1" aria-labelledby="modalEditPhoneLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditPhoneLabel">Tambah Nomor HP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2" style="color:#666;">Pastikan nomor HP Anda aktif untuk keamanan dan kemudahan transaksi</div>
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          <div class="mb-3">
            <label for="inputPhone" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="inputPhone" name="phone" value="{{ Auth::user()->phone }}">
            <div class="form-text">Kami akan mengirimkan kode verifikasi melalui SMS</div>
          </div>
          <button type="submit" class="btn btn-success w-100">Selanjutnya</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
