<style>
    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 40px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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
    <div class="search-bar">
        <input type="text" placeholder="Cari produk...">
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