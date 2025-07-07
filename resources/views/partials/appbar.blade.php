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
        @auth
            <div class="user">
                <i class="fas fa-user-circle"></i>
                <span>Hi, {{ Auth::user()->name }}</span>
                <i class="fas fa-chevron-down" style="font-size:14px;"></i>
            </div>
            <button class="jual-btn">Jual</button>
        @else
            <a href="{{ route('register') }}" class="btn btn-success" style="margin-right: 10px;">Daftar</a>
            <a href="{{ route('login') }}" class="btn btn-warning">Masuk</a>
        @endauth
        <i class="fas fa-comment-dots"></i>
        <a href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i></a>
    </div>
</div>