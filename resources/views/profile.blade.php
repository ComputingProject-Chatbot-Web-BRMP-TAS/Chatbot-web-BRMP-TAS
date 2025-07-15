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
                @if(Auth::user()->profile_photo_url)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil">
                @else
                    <i class="fas fa-user-circle"></i>
                @endif
            </div>
            <form method="POST" action="{{ route('profile.upload_foto') }}" enctype="multipart/form-data" style="width:100%;">
                @csrf
                <input type="file" name="foto_profil" id="fotoProfilInput" accept="image/jpeg,image/png" style="display:none;" onchange="this.form.submit()">
                <button type="button" class="btn-upload" onclick="document.getElementById('fotoProfilInput').click()">Pilih Foto</button>
            </form>
            @if ($errors->has('foto_profil'))
                <div style="color: #d32f2f; background: #fff3f3; border: 1px solid #f8d7da; padding: 10px 16px; border-radius: 8px; margin-bottom: 16px; text-align:center;">
                    <strong>Gagal upload foto:</strong> {{ $errors->first('foto_profil') }}
                </div>
            @endif
            @if (session('success'))
                <div style="color: #388e3c; background: #eaffea; border: 1px solid #b2dfdb; padding: 10px 16px; border-radius: 8px; margin-bottom: 16px; text-align:center;">
                    {{ session('success') }}
                </div>
            @endif
            <div class="profile-file-info">
                Besar file: maksimum 10.000.000 bytes (10 Megabytes).<br>
                Ekstensi file yang diperbolehkan: JPG, JPEG, PNG
            </div>
            <div class="profile-actions">
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalGantiPassword">Ganti Kata Sandi</button>
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
                    {{-- Tidak ada tombol Ubah jika sudah terisi --}}
                @else
                    <div class="profile-info-value" style="color:#4CAF50; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalEditTanggalLahir">Tambah Tanggal Lahir</div>
                @endif
            </div>
            <div class="profile-info-row">
                <div class="profile-info-label">Jenis Kelamin</div>
                @if(Auth::user()->gender ?? false)
                    <div class="profile-info-value">{{ Auth::user()->gender }}</div>
                    {{-- Tidak ada tombol Ubah jika sudah terisi --}}
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
                    <div class="profile-info-value">{{ Auth::user()->phone }}
                        @if(!Auth::user()->isPhoneVerified())
                            <span class="profile-info-badge">Belum diverifikasi</span>
                        @endif
                    </div>
                    <div class="profile-info-action" data-bs-toggle="modal" data-bs-target="#modalEditPhone">Ubah</div>
                    @if(!Auth::user()->isPhoneVerified())
                        <button class="btn btn-outline-success btn-sm ms-2" id="btnVerifikasiPhone" data-bs-toggle="modal" data-bs-target="#modalVerifikasiPhone">Verifikasi</button>
                    @endif
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
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          <div class="mb-3">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="email" value="{{ Auth::user()->email }}">
          </div>
          <button type="submit" class="btn btn-success w-100">Simpan</button>
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
          <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control" placeholder="Pilih tanggal lahir" readonly required>
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
            <input type="tel" class="form-control" id="inputPhone" name="phone" pattern="^(08|628)[0-9]{7,11}$" placeholder="Contoh: 08123456789" value="{{ Auth::user()->phone }}" >
            <div class="form-text">Kami akan mengirimkan kode verifikasi melalui SMS</div>
          </div>
          <button type="submit" class="btn btn-success w-100">Selanjutnya</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Verifikasi Nomor HP -->
<div class="modal fade" id="modalVerifikasiPhone" tabindex="-1" aria-labelledby="modalVerifikasiPhoneLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerifikasiPhoneLabel">Verifikasi Nomor HP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('profile.verify_phone') }}">
          @csrf
          <div class="mb-3">
            <label for="otp_code" class="form-label">Masukkan Kode OTP</label>
            <input type="text" class="form-control" id="otp_code" name="otp_code" maxlength="6" required placeholder="Kode OTP">
            <div class="form-text">Kode OTP telah dikirim ke nomor HP Anda.</div>
            <button type="button" class="btn btn-link p-0" id="btnKirimUlangOTP">Kirim Ulang OTP</button>
            <div id="otpStatus" class="mt-2" style="font-size:0.95em;"></div>
          </div>
          <button type="submit" class="btn btn-success w-100">Verifikasi</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Ganti Password -->
<div class="modal fade" id="modalGantiPassword" tabindex="-1" aria-labelledby="modalGantiPasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalGantiPasswordLabel">Ganti Kata Sandi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formGantiPassword" method="POST" action="{{ route('profile.change_password') }}">
          @csrf
          <div class="mb-3">
            <label for="old_password" class="form-label">Password Lama</label>
            <input type="password" class="form-control" id="old_password" name="old_password" required>
          </div>
          <div class="mb-3">
            <label for="new_password" class="form-label">Password Baru</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
            <div class="form-text" id="passwordHelpBlock">
              Password minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.
            </div>
          </div>
          <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
          </div>
          <div id="passwordError" class="text-danger mb-2" style="display:none;"></div>
          <button type="submit" class="btn btn-success w-100">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('after_content')
    @include('partials.mitra_footer')
@endsection

<!-- Tambahkan jQuery CDN sebelum script custom -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const selects = document.querySelectorAll('.choices-select');
  selects.forEach(function(select) {
    new Choices(select, {
      searchEnabled: false,
      itemSelectText: '',
      shouldSort: false,
      position: 'bottom',
      renderChoiceLimit: 5 // jumlah opsi yang terlihat
    });
  });
});
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#tanggal_lahir", {
      dateFormat: "Y-m-d",
      maxDate: "today",
      allowInput: false
    });
  });
</script>
<script>
$(function() {
  $('#btnKirimUlangOTP').on('click', function() {
    $('#otpStatus').text('Mengirim ulang kode...');
    $.post({
      url: '{{ route('profile.send_otp') }}',
      data: {
        _token: '{{ csrf_token() }}'
      },
      success: function(res) {
        $('#otpStatus').text('Kode OTP telah dikirim ulang ke nomor HP Anda.');
      },
      error: function() {
        $('#otpStatus').text('Gagal mengirim ulang OTP. Coba lagi.');
      }
    });
  });

  $('#modalVerifikasiPhone').on('show.bs.modal', function() {
    $('#otpStatus').text('');
    $.post({
      url: '{{ route('profile.send_otp') }}',
      data: {
        _token: '{{ csrf_token() }}'
      },
      success: function(res) {
        $('#otpStatus').text('Kode OTP telah dikirim ke nomor HP Anda.');
      },
      error: function() {
        $('#otpStatus').text('Gagal mengirim OTP. Coba lagi.');
      }
    });
  });
});
</script>
<script>
$(function() {
  $('#formGantiPassword').on('submit', function(e) {
    var newPassword = $('#new_password').val();
    var confirmPassword = $('#new_password_confirmation').val();
    var error = '';
    // Password strength validation
    if (newPassword.length < 8) {
      error = 'Password minimal 8 karakter.';
    } else if (!/[A-Z]/.test(newPassword)) {
      error = 'Password harus mengandung huruf besar.';
    } else if (!/[a-z]/.test(newPassword)) {
      error = 'Password harus mengandung huruf kecil.';
    } else if (!/[0-9]/.test(newPassword)) {
      error = 'Password harus mengandung angka.';
    } else if (!/[^A-Za-z0-9]/.test(newPassword)) {
      error = 'Password harus mengandung simbol.';
    } else if (newPassword !== confirmPassword) {
      error = 'Konfirmasi password tidak cocok.';
    }
    if (error) {
      $('#passwordError').text(error).show();
      e.preventDefault();
    } else {
      $('#passwordError').hide();
    }
  });
});
</script>