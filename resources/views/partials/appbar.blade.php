<div class="navbar">
    <div style="font-weight:bold; color:#388E3C; font-size:22px;">Benih BRMP</div>
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
            <a href="{{ route('login') }}" class="btn btn-warning" style="color: #388E3C;">Masuk</a>
        @endauth
        <i class="fas fa-comment-dots"></i>
        <a href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i></a>
    </div>
</div> 