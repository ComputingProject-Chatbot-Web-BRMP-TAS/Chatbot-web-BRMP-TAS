<style>
    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 40px;
        background: #fff !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        z-index: 1100;
        position: relative;
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
        color: #4CAF50;
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
        color: #4CAF50;
    }
    .navbar .user-section .fa-comment-dots,
    .navbar .user-section .fa-shopping-cart {
        font-size: 22px;
        color: #4CAF50;
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
        background: #4CAF50;
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
</style>

<div class="navbar">
    <div style="font-weight:bold; color:#388E3C; font-size:22px;">
        <a href="/" style="text-decoration: none; color: inherit;">Benih BRMP</a>
    </div>
    <span class="appbar-category" id="appbarCategoryBtn" style="font-weight:500; color:#222; margin-left:24px; margin-right:12px; font-size:17px; cursor:pointer; position:relative; background:#fff !important;">Kategori
        <div id="appbarCategoryDropdown" class="dropdown-anim" style="display:none;position:fixed;top:56px;left:0;background:#fff !important;border-radius:0;box-shadow:0 4px 24px rgba(0,0,0,0.10);padding:14px 0;z-index:1001;flex-direction:row;gap:0;min-width:600px;max-width:1920px;width:auto;overflow:hidden;opacity:0;transform:translateY(-24px);height:0;transition:opacity 0.25s cubic-bezier(.4,0,.2,1), transform 0.25s cubic-bezier(.4,0,.2,1), height 0.25s cubic-bezier(.4,0,.2,1);">
            <div style="display:flex;flex-direction:row;gap:0;width:100%;justify-content:flex-start;">
                <a href="/kategori/tumbuhan" class="dropdown-item" style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
                    <i class="fas fa-seedling" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Tumbuhan</span>
                </a>
                <a href="/kategori/rempah" class="dropdown-item" style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
                    <i class="fas fa-leaf" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Rempah-Rempah/Herbal</span>
                </a>
                <a href="/kategori/buah" class="dropdown-item" style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
                    <i class="fas fa-apple-alt" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Buah-Buahan</span>
                </a>
                <a href="/kategori/sayuran" class="dropdown-item" style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
                    <i class="fas fa-carrot" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Sayuran</span>
                </a>
                <a href="/kategori/bunga" class="dropdown-item" style="padding:10px 28px;cursor:pointer;display:flex;align-items:center;gap:12px;min-width:160px;border-radius:8px;transition:background 0.15s; color:#388E3C; font-weight:600; text-decoration:none;">
                    <i class="fas fa-spa" style="color:#388E3C;"></i> <span style="font-size:15px;color:#388E3C;">Bunga</span>
                </a>
            </div>
        </div>
    </span>
    <div class="search-bar">
        <input type="text" placeholder="Cari di Benih BRMP" style="border:1.5px solid #bfc9d1;">
        <i class="fas fa-search"></i>
    </div>
    <div class="user-section">
        @if(session('user'))
            <div class="user" style="position:relative;">
                <a href="{{ route('profile') }}" style="display:inline-flex;align-items:center;text-decoration:none;color:inherit;gap:8px;">
                    <i class="fas fa-user-circle"></i>
                    <span>Hi, {{ session('user.name') }}</span>
                </a>
                <span class="dropdown-toggle" style="cursor:pointer;" onclick="toggleDropdown()">
                    <i class="fas fa-chevron-down" style="font-size:14px;"></i>
                </span>
                <div id="dropdown-menu" class="dropdown-menu">
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </div>
            </div>
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
        @else
            <a href="{{ route('login') }}" class="btn btn-success" style="margin-right: 10px;">Login</a>
            <a href="{{ route('register') }}" class="btn btn-warning">Daftar</a>
        @endif
        <a href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i></a>
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