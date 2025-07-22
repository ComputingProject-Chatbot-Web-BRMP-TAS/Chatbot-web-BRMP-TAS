<style>
    .navbar-fokus {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 16px 40px;
        background: #fff !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        z-index: 1100;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 56px;
    }
    .navbar-title-fokus {
        font-family: 'Inter', Arial, sans-serif !important;
        font-weight: bold !important;
        color: #388E3C !important;
        font-size: 22px !important;
        text-decoration: none !important;
        letter-spacing: 0;
    }
    .navbar-exit-fokus {
        margin-left: auto;
        background: none;
        border: none;
        color: #388E3C;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
    }
</style>
<div class="navbar-fokus">
    <a href="#" id="logo-brmp" class="navbar-title-fokus">Benih BRMP</a>
</div>
@if (request()->routeIs('payment') || request()->is('payment'))
<!-- Modal Konfirmasi Kembali Ke Home (khusus payment) -->
<div id="modal-konfirmasi-ke-home" style="display:none;position:fixed;z-index:2000;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);align-items:center;justify-content:center;">
  <div style="background:#fff;padding:32px 24px;border-radius:16px;max-width:400px;width:90vw;box-shadow:0 4px 24px rgba(0,0,0,0.10);text-align:center;">
    <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:12px;">Anda Belum Menyelesaikan Pembayaran</h2>
    <p style="color:#444;margin-bottom:24px;">Silakan selesaikan pembayaran terlebih dahulu. Jika ingin kembali ke halaman utama, klik tombol di bawah ini.</p>
    <button id="tetap-di-halaman-payment" style="width:100%;background:#19b15e;color:#fff;font-weight:700;padding:12px 0;border:none;border-radius:8px;font-size:1.1rem;margin-bottom:12px;">Tetap Di Halaman Ini</button>
    <br>
    <button id="kembali-ke-home" style="background:none;border:none;color:#19b15e;font-weight:700;font-size:1rem;">Kembali ke Home</button>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var logo = document.getElementById('logo-brmp');
    if (logo) logo.onclick = function(e) { e.preventDefault(); showModalKonfirmasiKeHome(); };
    function showModalKonfirmasiKeHome() {
      document.getElementById('modal-konfirmasi-ke-home').style.display = 'flex';
    }
    function hideModalKonfirmasiKeHome() {
      document.getElementById('modal-konfirmasi-ke-home').style.display = 'none';
    }
    document.getElementById('tetap-di-halaman-payment').onclick = function() { hideModalKonfirmasiKeHome(); };
    document.getElementById('kembali-ke-home').onclick = function() {
      window.location.href = '/'; // Route ke home
    };
  });
</script>
@endif 