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
    .navbar .btn {
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .navbar .btn-danger {
        background: #dc3545;
        color: white;
    }
    .navbar .btn:hover {
        transform: translateY(-1px);
    }
    .navbar-title {
        font-family: 'Inter', Arial, sans-serif !important;
        font-weight: bold !important;
        color: #388E3C !important;
        font-size: 22px !important;
        text-decoration: none !important;
        letter-spacing: 0;
    }
    .navbar-menu-link {
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
    .navbar-menu-link:hover {
        color: #388E3C !important;
    }
    .navbar-user-greeting {
        font-family: 'Inter', Arial, sans-serif !important;
        font-weight: 600 !important;
        font-size: 18px !important;
        color: #222 !important;
        letter-spacing: 0;
        background: none !important;
    }
    .navbar-logout-btn {
        font-family: 'Inter', Arial, sans-serif !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #fff !important;
        background: #dc3545 !important;
        border-radius: 8px !important;
        border: none !important;
        padding: 8px 16px !important;
        cursor: pointer;
        transition: background 0.2s;
    }
    .navbar-logout-btn:hover {
        background: #c82333 !important;
    }
    @media (max-width: 768px) {
        .navbar {
            padding: 10px 16px;
        }
        .navbar-menu-link {
            font-size: 16px !important;
        }
        .navbar-title {
            font-size: 18px !important;
        }
    }
</style>

<div class="navbar" style="display:flex;align-items:center;justify-content:space-between;">
    <!-- Kiri: Logo + Menu -->
    <div class="navbar-left" style="display:flex;align-items:center;gap:18px;min-width:320px;">
        <a href="{{ route('admin.dashboard') }}" class="navbar-title">Admin BRMP</a>
        <span style="width:0px;"></span>
        <a href="{{ route('admin.products.index') }}" class="navbar-menu-link" style="margin-right:0px;">Produk</a>
        <a href="{{ route('admin.transactions') }}" class="navbar-menu-link" style="margin-left:0px;">Transaksi</a>
        <a href="{{ route('admin.articles') }}" class="navbar-menu-link" style="margin-left:0px;">Artikel</a>
    </div>
    
    <!-- Kanan: User Section + Logout -->
    <div class="user-section" style="display:flex;align-items:center;gap:18px;min-width:220px;justify-content:flex-end;">
        <form action="{{ route('admin.logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="btn btn-danger navbar-logout-btn">Logout</button>
        </form>
    </div>
</div> 