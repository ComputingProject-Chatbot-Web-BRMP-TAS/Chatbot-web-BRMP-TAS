<style>
    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 40px;
        background: #fff !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        z-index: 1100;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
    }
    .navbar .search-bar {
        flex: 0 0 400px;
        margin: 0 32px;
        position: relative;
        max-width: 400px;
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
    .navbar .user-section {
        display: flex;
        align-items: center;
        gap: 18px;
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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
    @media (max-width: 1200px) {
        .navbar {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 10px 8px;
            height: auto;
        }
        .navbar > div:first-child, /* logo */
        .appbar-category,
        .navbar .user-section {
            display: none !important;
        }
        .navbar .mobile-search-bar {
            order: 1;
            flex: 1;
            margin: 0 8px 0 0;
            max-width: unset;
            display: block;
        }
        .navbar .cart-mobile {
            order: 2;
            display: flex !important;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #388E3C;
            margin: 0 8px;
            background: none;
            border: none;
            height: 40px;
            width: 40px;
        }
        .navbar .menu-toggle {
            order: 3;
            display: block;
            background: none;
            border: none;
            font-size: 26px;
            color: #388E3C;
            margin-left: 0;
            cursor: pointer;
        }
        .navbar .mobile-menu {
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #fff;
            position: absolute;
            top: 60px;
            left: 0;
            right: 0;
            z-index: 1200;
            padding: 16px 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
    }
    @media (min-width: 1201px) {
        .navbar .menu-toggle, .navbar .mobile-menu, .navbar .cart-mobile { display: none !important; }
    }
    .navbar-title {
        font-family: 'Inter', Arial, sans-serif !important;
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

<div class="navbar" style="display:flex;align-items:center;justify-content:space-between;">
    <!-- Kiri: Logo + Menu -->
    <div class="navbar-left" style="display:flex;align-items:center;gap:18px;min-width:320px;">
        <a href="/" class="navbar-title">Benih BRMP</a>
        <span style="width:0px;"></span>
        <span class="navbar-category-title" id="appbarCategoryBtn" style="margin-right:0px;cursor:pointer;position:relative;">Kategori</span>
        <a href="{{ route('article') }}" class="navbar-article-link" style="margin-left:0px;">Artikel</a>
        <a href="{{ route('transaksi') }}" class="navbar-article-link" style="margin-left:0px;">Transaksi</a>
    </div>
    <!-- Tengah: Searchbar -->
    <div class="navbar-center" style="flex:1;display:flex;justify-content:center;min-width:0;">
        <form method="get" action="/" style="flex:1;min-width:120px;max-width:1000px;margin:0 16px;position:relative;">
            <input type="text" name="q" class="navbar-search-input" placeholder="Cari di Benih BRMP" value="{{ request('q') }}" style="width:100%;border:1.5px solid #bfc9d1;">
            <button type="submit" style="position:absolute;right:0;top:0;height:100%;background:none;border:none;padding:0 16px;cursor:pointer;"><i class="fas fa-search" style="color:#388E3C;"></i></button>
        </form>
    </div>
    <!-- Kanan: User Section + Cart -->
    <div class="user-section" style="display:flex;align-items:center;gap:18px;min-width:220px;justify-content:flex-end;">
        @auth
            <div class="user" style="position:relative;">
                <a href="{{ route('profile') }}" style="display:inline-flex;align-items:center;text-decoration:none;color:inherit;gap:8px;">
                    @if(Auth::user()->profile_photo_url)
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil" style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                    @else
                        <i class="fas fa-user-circle" style="width:32px; height:32px; font-size:32px; color:#666;"></i>
                    @endif
                    <span class="navbar-user-greeting">Hi, {{ Auth::user()->name }}</span>
                </a>
                <span style="cursor:pointer;" onclick="toggleDropdown()">
                    <i class="fas fa-chevron-down" style="font-size:14px;"></i>
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
            <a href="{{ route('login') }}" class="btn btn-success navbar-login-btn" style="margin-right: 10px;">Login</a>
            <a href="{{ route('register') }}" class="btn btn-warning navbar-register-btn">Daftar</a>
        @endauth
        <a href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i></a>
    </div>
    <!-- Dropdown kategori dan mobile menu tetap di luar flex utama -->
    <div id="appbarCategoryDropdown" class="dropdown-anim" style="display:none;position:fixed;top:56px;left:0;background:#fff !important;border-radius:0;box-shadow:0 4px 24px rgba(0,0,0,0.10);padding:14px 0;z-index:1001;flex-direction:row;gap:0;min-width:600px;max-width:1920px;width:auto;overflow:hidden;opacity:0;transform:translateY(-24px);height:0;transition:opacity 0.25s cubic-bezier(.4,0,.2,1), transform 0.25s cubic-bezier(.4,0,.2,1), height 0.25s cubic-bezier(.4,0,.2,1);">
            <div style="display:flex;flex-direction:row;gap:0;width:100%;justify-content:flex-start;">
                <a href="/kategori/pemanis" class="dropdown-item" style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
                    <i class="fas fa-cube" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Tanaman Pemanis</span>
                </a>
                <a href="/kategori/serat" class="dropdown-item" style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
                    <i class="fas fa-tshirt" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Tanaman Serat</span>
                </a>
                <a href="/kategori/tembakau" class="dropdown-item" style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
                    <i class="fas fa-leaf" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Tanaman Tembakau</span>
                </a>
                <a href="/kategori/minyak" class="dropdown-item" style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
                    <i class="fas fa-oil-can" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Tanaman Minyak Industri</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="dropdownOverlay" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.18);z-index:1000;transition:opacity 0.25s;opacity:0;"></div>

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
        setTimeout(() => { dropdownOverlay.style.opacity = '1'; }, 10);
    }, 10);
}
function hideDropdown() {
    appbarCatDropdown.style.opacity = '0';
    appbarCatDropdown.style.transform = 'translateY(-24px)';
    appbarCatDropdown.style.height = '0';
    dropdownOverlay.style.opacity = '0';
    setTimeout(() => {
        if(appbarCatDropdown.style.opacity === '0') appbarCatDropdown.style.display = 'none';
        dropdownOverlay.style.display = 'none';
    }, 250);
}
appbarCatBtn.onclick = function(e) {
    e.stopPropagation();
    if(appbarCatDropdown.style.display === 'flex' && appbarCatDropdown.style.opacity === '1') {
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
    if(appbarCatDropdown.style.display === 'flex') {
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
    if (menu.classList.contains('show')) {
        menu.classList.remove('show');
        setTimeout(function(){ menu.style.display = 'none'; }, 250);
    } else {
        menu.style.display = 'block';
        setTimeout(function(){ menu.classList.add('show'); }, 10);
    }
}
document.addEventListener('click', function(e) {
    var menu = document.getElementById('dropdown-menu');
    var toggle = document.querySelector('.dropdown-toggle');
    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        if (menu.classList.contains('show')) {
            menu.classList.remove('show');
            setTimeout(function(){ menu.style.display = 'none'; }, 250);
        }
    }
});
</script>

<script>
function toggleMobileMenu() {
    var menu = document.getElementById('mobileMenu');
    if(menu.style.display === 'flex') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'flex';
    }
}
</script>
