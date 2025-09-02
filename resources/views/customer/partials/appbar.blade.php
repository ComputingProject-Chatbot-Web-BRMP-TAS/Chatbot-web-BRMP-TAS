<style>
    .navbar {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: space-between;
        padding: 16px 40px;
        background: #fff !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        z-index: 1100;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
    }

    .navbar input[type="text"] {
        width: 100%;
        padding: 6px 36px 6px 12px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        font-size: 15px;
        height: 32px;
    }

    .navbar .fa-search {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #388E3C;
    }

    .navbar .navbar-left {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .navbar .user-section {

        display: flex;
        align-items: center;
        gap: 18px;
        width: 100%;
    }

    .navbar .user-section .user {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .navbar .user-section .fa-user-circle {
        font-size: 28px;
        color: #388E3C;
    }

    .navbar .user-section .fa-comment-dots,
    .navbar .user-section .fa-shopping-cart {
        font-size: 22px;
        color: #388E3C;
        cursor: pointer;
    }

    .navbar .jual-btn {
        background: #FFEB3B;
        color: #388E3C;
        border: none;
        border-radius: 8px;
        padding: 8px 24px;
        font-weight: bold;
        font-size: 16px;
        margin-left: 12px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .navbar .jual-btn:hover {
        background: #FDD835;
    }

    .navbar .btn {
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .navbar .btn-success {
        background: #388E3C;
        color: white;
    }

    .navbar .btn-warning {
        background: #FFEB3B;
        color: #388E3C;
    }

    .navbar .btn:hover {
        transform: translateY(-1px);
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 40px;
        right: 0;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        min-width: 120px;
        z-index: 100;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.25s, transform 0.25s;
    }

    .dropdown-menu.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-item {
        background: #fff;
        color: #222;
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        font-weight: 600;
        font-size: 15px;
        width: 100%;
        text-align: left;
        cursor: pointer;
        transition: background 0.2s;
    }

    .dropdown-item:hover {
        background: #f4f4f4;
    }

    .dropdown-item.logout-item i {
        color: #dc3545;
    }

    .dropdown-item.logout-item:hover {
        background: #f4f4f4;
    }

    .dropdown-item.logout-item:hover i {
        color: #dc3545;
    }

    /* Mobile Responsive Styles */
    .mobile-search-container,
    .mobile-menu-toggle,
    .mobile-cart-btn,
    .mobile-menu-overlay,
    .mobile-menu {
        display: none !important;
    }

    @media (max-width: 1023px) {
        .mobile-back-btn {
            display: none;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            font-size: 20px;
            min-height: 40px;
            min-width: 40px;
            line-height: 1;
        }

        .mobile-transaksi-title,
        .mobile-detail-transaksi-title,
        .mobile-cart-title {
            font-size: 20px;
            font-weight: 800;
            width: 100%;
        }

        .mobile-menu-toggle,
        .mobile-cart-btn {
            display: flex !important;
        }

        .mobile-menu {
            display: block !important;
        }

        .mobile-search-container {
            display: flex !important;
        }

        .navbar {
            padding: 8px 10px;
            height: 64px;
            align-items: center;
        }

        /* Hide desktop elements on mobile */
        .navbar-left {
            display: none !important;
        }

        .navbar-center {
            display: none !important;
        }

        .user-section {
            display: none !important;
        }

        /* Mobile layout */
        .navbar {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            gap: 8px;
        }

        /* Mobile search bar */
        .mobile-search-container {
            display: flex !important;
            flex: 1;
            position: relative;
            align-items: center;
        }

        .mobile-search-container .searchbar-container {
            margin: 0 5px;
        }

        .mobile-search-container input[type="text"] {
            width: 100%;
            padding: 8px 40px 8px 12px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            font-size: 14px;
            height: 40px;
            box-sizing: border-box;
            line-height: 1.2;
        }

        .mobile-search-container .fa-search {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #388E3C;
            font-size: 16px;
        }

        /* Mobile hamburger menu */
        .mobile-menu-toggle {
            display: flex !important;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            font-size: 24px;
            color: #388E3C;
            cursor: pointer;
            padding: 0;
            min-height: 40px;
            min-width: 40px;
            line-height: 1;
        }

        /* Mobile cart button */
        .mobile-cart-btn {
            display: flex !important;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            font-size: 20px;
            color: #388E3C;
            cursor: pointer;
            min-height: 40px;
            min-width: 40px;
            line-height: 1;
        }

        /* Mobile menu overlay */
        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100vh;
            background: #fff;
            z-index: 2001;
            transition: right 0.3s ease;
            padding: 20px;
            box-shadow: -2px 0 8px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.show {
            right: 0;
        }

        .mobile-menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .mobile-menu-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #666;
            cursor: pointer;
        }

        .mobile-menu-items {
            display: flex;
            flex-direction: column;
        }

        .mobile-menu-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px 0;
            color: #222;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .mobile-menu-item:hover {
            color: #388E3C;
        }

        .mobile-menu-item i {
            width: 20px;
            color: #388E3C;
        }

        /* Mobile user section */
        .mobile-user-section {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #e0e0e0;
        }

        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .mobile-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .mobile-user-name {
            font-weight: 600;
            color: #222;
        }

        .mobile-user-actions {
            display: flex;
            flex-direction: column;
        }

        .mobile-user-action {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px 0;
            color: #222;
            text-decoration: none;
            font-weight: 500;
        }

        .mobile-user-action.logout {
            color: #dc3545;
        }
    }

    .navbar-title {
        font-weight: bold !important;
        color: #388E3C !important;
        font-size: 22px !important;
        text-decoration: none !important;
        letter-spacing: 0;
        width: max-content !important;
    }

    .navbar-title-fokus {
        font-weight: bold !important;
        color: #388E3C !important;
        font-size: 22px !important;
        text-decoration: none !important;
        letter-spacing: 0;
    }

    .navbar-category-title {
        font-family: 'Inter', Arial, sans-serif !important;
        font-weight: 500 !important;
        color: #222 !important;
        font-size: 20px !important;
        letter-spacing: 0;
        background: none !important;
    }

    .navbar-search-input {
        font-family: 'Inter', Arial, sans-serif !important;
        font-size: 16px !important;
        color: #222 !important;
        background: #fff !important;
        border-radius: 8px !important;
        border: 1.5px solid #bfc9d1 !important;
        padding: 6px 36px 6px 12px !important;
        height: 32px !important;
    }

    /* CSS untuk memastikan posisi searchbar konsisten */
    .searchbar-container {
        position: relative;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1100;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin: 0 18px;
    }

    .searchbar-container form {
        width: 100%;
        position: relative;
        margin: 0 auto;
    }

    .searchbar-container input[type="text"] {
        width: 100%;
        border: 1.5px solid #bfc9d1;
        border-radius: 8px;
        padding: 6px 36px 6px 12px;
        height: 32px;
        font-family: 'Inter', Arial, sans-serif;
        font-size: 16px;
        color: #222;
        background: #fff;
    }

    .searchbar-container button[type="submit"] {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        background: none;
        border: none;
        padding: 0 16px;
        cursor: pointer;
    }

    .searchbar-container .fa-search {
        color: #388E3C;
    }

    /* Mobile searchbar container */
    .mobile-search-container .searchbar-container {
        flex: 1;
        position: relative;
        align-items: center;
    }

    .mobile-search-container .searchbar-container form {
        width: 100%;
        position: relative;
    }

    .mobile-search-container .searchbar-container input[type="text"] {
        width: 100%;
        padding: 8px 40px 8px 12px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        font-size: 14px;
        height: 40px;
        box-sizing: border-box;
        line-height: 1.2;
    }

    .mobile-search-container .searchbar-container button[type="submit"] {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        background: none;
        border: none;
        padding: 0 12px;
        cursor: pointer;
    }

    .mobile-search-container .searchbar-container .fa-search {
        color: #388E3C;
        font-size: 16px;
    }

    .navbar-login-btn {
        font-family: 'Inter', Arial, sans-serif !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #fff !important;
        background: #4CAF50 !important;
        border-radius: 8px !important;
        border: none !important;
        padding: 8px 16px !important;
    }

    .navbar-register-btn {
        font-family: 'Inter', Arial, sans-serif !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #388E3C !important;
        background: #FFEB3B !important;
        border-radius: 8px !important;
        border: none !important;
        padding: 8px 16px !important;
    }

    .navbar-user-greeting {
        font-family: 'Inter', Arial, sans-serif !important;
        font-weight: 600 !important;
        font-size: 18px !important;
        color: #222 !important;
        letter-spacing: 0;
        background: none !important;
        width: max-content !important;
    }

    .navbar-article-link {
        font-family: 'Inter', Arial, sans-serif !important;
        font-weight: 500 !important;
        font-size: 20px !important;
        color: #222 !important;
        text-decoration: none !important;
        background: none !important;
        cursor: pointer;
        transition: color 0.2s;
        letter-spacing: 0;
    }

    .navbar-article-link:hover {
        color: #388E3C !important;
    }

    .navbar-category-title:hover {
        color: #388E3C !important;
    }
</style>

<div class="navbar">
    <!-- Navbar Fokus (Checkout & Payment)-->
    <a href="#" id="logo-brmp" class="navbar-title-fokus" style="display: none">Benih BRMP</a>
    @if (request()->routeIs('payment') || request()->is('payment'))
        <!-- Modal Konfirmasi Kembali Ke Home (khusus payment) -->
        <div id="modal-konfirmasi-ke-home"
            style="display:none;position:fixed;z-index:2000;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);align-items:center;justify-content:center;">
            <div
                style="background:#fff;padding:32px 24px;border-radius:16px;max-width:400px;width:90vw;box-shadow:0 4px 24px rgba(0,0,0,0.10);text-align:center;">
                <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:12px;">Anda Belum Menyelesaikan Pembayaran
                </h2>
                <p style="color:#444;margin-bottom:24px;">Silakan selesaikan pembayaran terlebih dahulu. Jika ingin
                    kembali
                    ke halaman utama, klik tombol di bawah ini.</p>
                <button id="tetap-di-halaman-payment"
                    style="width:100%;background:#19b15e;color:#fff;font-weight:700;padding:12px 0;border:none;border-radius:8px;font-size:1.1rem;margin-bottom:12px;">Tetap
                    Di Halaman Ini</button>
                <br>
                <button id="kembali-ke-home"
                    style="background:none;border:none;color:#19b15e;font-weight:700;font-size:1rem;">Kembali ke
                    Home</button>
            </div>
        </div>
    @endif

    <!-- Desktop Layout -->
    <!-- Kiri: Logo + Menu -->
    <div class="navbar-left">
        <a href="/" class="navbar-title">Benih BRMP</a>
        <span class="navbar-category-title" id="appbarCategoryBtn"
            style="margin-right:0px;cursor:pointer;position:relative;">Komoditas</span>
        <a href="{{ route('articles.index') }}" class="navbar-article-link" style="margin-left:0px;">Artikel</a>
        <a href="{{ route('transaksi') }}" class="navbar-article-link" style="margin-left:0px;">Transaksi</a>
    </div>

    <!-- Kanan: Searchbar +User Section + Cart -->
    <div class="user-section">
        <div class="searchbar-container">
            <form method="get" action="/">
                <input type="text" name="q" placeholder="Cari di Benih BRMP" value="{{ request('q') }}">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        @auth
            <div class="user" style="position:relative;">
                <a href="{{ route('profile') }}"
                    style="display:inline-flex;align-items:center;text-decoration:none;color:inherit;gap:8px;">
                    @if (Auth::user()->profile_photo_url)
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil"
                            style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                    @else
                        <i class="fas fa-user-circle" style="width:32px; height:32px; font-size:32px; color:#666;"></i>
                    @endif
                    <span class="navbar-user-greeting">Hi, {{ Auth::user()->name }}</span>
                </a>
                <span style="cursor:pointer;" onclick="toggleDropdown()">
                    <i class="fas fa-chevron-down" id="profileArw" style="font-size:14px;"></i>
                </span>
                <div id="dropdown-menu" class="dropdown-menu">
                    <a href="{{ route('complaint.create') }}" class="dropdown-item">
                        <i class="fas fa-comment-dots me-2"></i>Komplain
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="dropdown-item logout-item">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-success navbar-login-btn">Login</a>
        @endauth
        <a href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i></a>
    </div>

    <!-- Mobile Layout -->
    <!-- Mobile Back Button -->
    <button class="mobile-back-btn" onclick="window.history.back()" style="display:none;">
        <i class="fas fa-arrow-left"></i>
    </button>

    <!-- Mobile Title Keranjang (halaman cart) -->
    <div class="mobile-cart-title" style="display:none;">
        <div>Keranjang</div>
    </div>

    <!-- Mobile Title Transaksi (halaman transaksi) -->
    <div class="mobile-transaksi-title" style="display:none;">
        <div>Transaksi</div>
    </div>

    <!-- Mobile Title Detail Transaksi (halaman detail transaksi) -->
    <div class="mobile-detail-transaksi-title" style="display:none;">
        <div>Detail Transaksi</div>
    </div>

    <!-- Mobile Search Bar -->
    <div class="mobile-search-container" style="display:none;">
        <div class="searchbar-container">
            <form method="get" action="/">
                <input type="text" name="q" placeholder="Cari di Benih BRMP" value="{{ request('q') }}">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <!-- Mobile Cart Button -->
    <button class="mobile-cart-btn" onclick="window.location.href='{{ route('cart') }}'" style="display:none;">
        <i class="fas fa-shopping-cart"></i>
    </button>

    <!-- Mobile Hamburger Menu -->
    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" style="display:none;">
        <i class="fas fa-bars"></i>
    </button>

</div>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay" onclick="closeMobileMenu()"></div>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <h3 style="margin:0;color:#388E3C;font-size:18px;font-weight:bold;">Menu</h3>
        <button class="mobile-menu-close" onclick="closeMobileMenu()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="mobile-menu-items">
        <a href="/" class="mobile-menu-item">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>
        <a href="#" class="mobile-menu-item" onclick="toggleMobileCategoryMenu()">
            <i class="fas fa-th-large"></i>
            <span id="komoditasBtn">Komoditas</span>
            <i class="fas fa-chevron-down" id="komoditasArw"
                style="width:auto;margin-left:auto;font-size:12px;color:#222;"></i>
        </a>
        <div id="mobileCategorySubmenu" style="display:none;margin-left:20px;">
            <a href="/kategori/pemanis" class="mobile-menu-item" style="font-size:14px;padding:8px 0;">
                <i class="fas fa-cube"></i>
                <span>Tanaman Pemanis</span>
            </a>
            <a href="/kategori/serat" class="mobile-menu-item" style="font-size:14px;padding:8px 0;">
                <i class="fas fa-tshirt"></i>
                <span>Tanaman Serat</span>
            </a>
            <a href="/kategori/tembakau" class="mobile-menu-item" style="font-size:14px;padding:8px 0;">
                <i class="fas fa-leaf"></i>
                <span>Tanaman Tembakau</span>
            </a>
            <a href="/kategori/minyak" class="mobile-menu-item" style="font-size:14px;padding:8px 0;">
                <i class="fas fa-oil-can"></i>
                <span>Tanaman Minyak Industri</span>
            </a>
        </div>
        <a href="{{ route('articles.index') }}" class="mobile-menu-item">
            <i class="fas fa-newspaper"></i>
            <span>Artikel</span>
        </a>
        <a href="{{ route('transaksi') }}" class="mobile-menu-item">
            <i class="fas fa-receipt"></i>
            <span>Transaksi</span>
        </a>
    </div>

    @auth
        <div class="mobile-user-section">
            <div class="mobile-user-info">
                @if (Auth::user()->profile_photo_url)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil" class="mobile-user-avatar">
                @else
                    <i class="fas fa-user-circle" style="width:40px;height:40px;font-size:40px;color:#666;"></i>
                @endif
                <span class="mobile-user-name">Hi, {{ Auth::user()->name }}</span>
            </div>
            <div class="mobile-user-actions">
                <a href="{{ route('profile') }}" class="mobile-user-action">
                    <i class="fas fa-user"></i>
                    <span>Profil</span>
                </a>
                <a href="{{ route('complaint.create') }}" class="mobile-user-action">
                    <i class="fas fa-comment-dots"></i>
                    <span>Komplain</span>
                </a>
                <a href="{{ route('addresses') }}" class="mobile-user-action">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Daftar Alamat</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="mobile-user-action logout"
                        style="background:none;border:none;width:100%;text-align:left;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="mobile-user-section">
            <div class="mobile-user-actions">
                <a href="{{ route('login') }}" class="mobile-user-action">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="mobile-user-action">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar</span>
                </a>
            </div>
        </div>
    @endauth
</div>

<!-- Dropdown kategori dan mobile menu tetap di luar flex utama -->
<div id="appbarCategoryDropdown" class="dropdown-anim"
    style="display:none;position:fixed;top:56px;left:0;background:#fff !important;border-radius:0;box-shadow:0 4px 24px rgba(0,0,0,0.10);padding:14px 0;z-index:1001;flex-direction:row;gap:0;min-width:600px;max-width:1920px;width:auto;overflow:hidden;opacity:0;transform:translateY(-24px);height:0;transition:opacity 0.25s cubic-bezier(.4,0,.2,1), transform 0.25s cubic-bezier(.4,0,.2,1), height 0.25s cubic-bezier(.4,0,.2,1);">
    <div style="display:flex;flex-direction:row;gap:0;width:100%;justify-content:flex-start;">
        <a href="/kategori/pemanis" class="dropdown-item"
            style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
            <i class="fas fa-cube" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Tanaman
                Pemanis</span>
        </a>
        <a href="/kategori/serat" class="dropdown-item"
            style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
            <i class="fas fa-tshirt" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Tanaman
                Serat</span>
        </a>
        <a href="/kategori/tembakau" class="dropdown-item"
            style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
            <i class="fas fa-leaf" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Tanaman
                Tembakau</span>
        </a>
        <a href="/kategori/minyak" class="dropdown-item"
            style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
            <i class="fas fa-oil-can" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Tanaman
                Minyak Industri</span>
        </a>
    </div>
</div>
</div>

<div id="dropdownOverlay"
    style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.18);z-index:1000;transition:opacity 0.25s;opacity:0;">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var logo = document.getElementById('logo-brmp');
        if (logo) logo.onclick = function(e) {
            e.preventDefault();
            showModalKonfirmasiKeHome();
        };

        function showModalKonfirmasiKeHome() {
            document.getElementById('modal-konfirmasi-ke-home').style.display = 'flex';
        }

        function hideModalKonfirmasiKeHome() {
            document.getElementById('modal-konfirmasi-ke-home').style.display = 'none';
        }
        document.getElementById('tetap-di-halaman-payment').onclick = function() {
            hideModalKonfirmasiKeHome();
        };
        document.getElementById('kembali-ke-home').onclick = function() {
            window.location.href = '/'; // Route ke home
        };
    });
</script>

<script>
    // Dropdown kategori appbar (benar-benar full sepanjang navbar, animasi slide, overlay gelap)
    const appbarCatBtn = document.getElementById('appbarCategoryBtn');
    const appbarCatDropdown = document.getElementById('appbarCategoryDropdown');
    const dropdownOverlay = document.getElementById('dropdownOverlay');
    const navbar = document.querySelector('.navbar');

    function positionDropdown() {
        const rect = navbar.getBoundingClientRect();
        appbarCatDropdown.style.position = 'fixed';
        appbarCatDropdown.style.left = rect.left + 'px';
        appbarCatDropdown.style.top = (rect.bottom) + 'px';
        appbarCatDropdown.style.width = rect.width + 'px';
    }

    function showDropdown() {
        positionDropdown();
        appbarCatDropdown.style.display = 'flex';
        setTimeout(() => {
            appbarCatDropdown.style.opacity = '1';
            appbarCatDropdown.style.transform = 'translateY(0)';
            appbarCatDropdown.style.height = '72px';
            dropdownOverlay.style.display = 'block';
            setTimeout(() => {
                dropdownOverlay.style.opacity = '1';
            }, 10);
        }, 10);
    }

    function hideDropdown() {
        appbarCatDropdown.style.opacity = '0';
        appbarCatDropdown.style.transform = 'translateY(-24px)';
        appbarCatDropdown.style.height = '0';
        dropdownOverlay.style.opacity = '0';
        setTimeout(() => {
            if (appbarCatDropdown.style.opacity === '0') appbarCatDropdown.style.display = 'none';
            dropdownOverlay.style.display = 'none';
        }, 250);
    }
    appbarCatBtn.onclick = function(e) {
        e.stopPropagation();
        if (appbarCatDropdown.style.display === 'flex' && appbarCatDropdown.style.opacity === '1') {
            hideDropdown();
        } else {
            showDropdown();
        }
    };
    dropdownOverlay.onclick = hideDropdown;
    document.addEventListener('click', function(e) {
        if (!appbarCatBtn.contains(e.target) && !appbarCatDropdown.contains(e.target)) {
            hideDropdown();
        }
    });
    window.addEventListener('resize', function() {
        if (appbarCatDropdown.style.display === 'flex') {
            positionDropdown();
        }
    });
</script>

<style>
    #appbarCategoryDropdown .dropdown-item:hover {
        background: #f4f4f4;
    }
</style>

<script>
    function toggleDropdown() {
        var menu = document.getElementById('dropdown-menu');
        var profileArw = document.getElementById('profileArw');
        if (menu.classList.contains('show')) {
            menu.classList.remove('show');
            setTimeout(function() {
                menu.style.display = 'none';
            }, 250);
            profileArw.style.transform = 'rotate(0deg)';
            profileArw.style.color = '#222';
        } else {
            menu.style.display = 'block';
            setTimeout(function() {
                menu.classList.add('show');
            }, 10);
            profileArw.style.transform = 'rotate(180deg)';
            profileArw.style.color = '#388E3C';
        }
    }
    document.addEventListener('click', function(e) {
        var menu = document.getElementById('dropdown-menu');
        if (!menu.contains(e.target)) {
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
                setTimeout(function() {
                    menu.style.display = 'none';
                }, 250);
            }
        }
    });
</script>

<script>
    // Mobile menu functions
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('mobileMenuOverlay');

        if (menu.classList.contains('show')) {
            closeMobileMenu();
        } else {
            menu.classList.add('show');
            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('mobileMenuOverlay');

        menu.classList.remove('show');
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function toggleMobileCategoryMenu() {
        const submenu = document.getElementById('mobileCategorySubmenu');
        const komoditasBtn = document.getElementById('komoditasBtn');
        const komoditasArw = document.getElementById('komoditasArw');
        if (submenu.style.display === 'none' || submenu.style.display === '') {
            submenu.style.display = 'block';
            komoditasBtn.style.color = '#388E3C';
            komoditasArw.style.transform = 'rotate(180deg)';
            komoditasArw.style.color = '#388E3C';
        } else {
            submenu.style.display = 'none';
            komoditasBtn.style.color = '#222';
            komoditasArw.style.transform = 'rotate(0deg)';
            komoditasArw.style.color = '#222';
        }
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('mobileMenu');
        const toggle = document.querySelector('.mobile-menu-toggle');

        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            closeMobileMenu();
        }
    });
</script>
