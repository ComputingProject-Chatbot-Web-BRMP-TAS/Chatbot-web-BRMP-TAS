<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Benih BRMP</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #fff;
            margin: 0;
            color: #222;
        }
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
        .container {
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 16px;
        }
        .section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 24px;
            margin-bottom: 32px;
        }
        .section h2, .section h3 {
            margin-top: 0;
        }
        .categories {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        .category {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fff;
            border: 2px solid #E0E0E0;
            border-radius: 12px;
            padding: 16px 20px;
            min-width: 90px;
            cursor: pointer;
            transition: border 0.2s, background 0.2s;
        }
        .category.selected, .category:hover {
            border: 2px solid #4CAF50;
            background: #E8F5E9;
        }
        .category i {
            font-size: 28px;
            color: #4CAF50;
            margin-bottom: 8px;
        }
        .category span {
            font-size: 15px;
        }
        .recommendations {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
        }
        .product-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            width: 210px;
            min-height: 260px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 0 0 16px 0;
            margin-bottom: 12px;
        }
        .product-card .image-placeholder {
            height: 120px;
            background: #E0F2F1;
            border-radius: 12px 12px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #B2DFDB;
            font-size: 32px;
        }
        .product-card .info {
            padding: 12px 16px 0 16px;
        }
        .product-card .title {
            font-weight: 500;
            font-size: 16px;
            margin-bottom: 4px;
        }
        .product-card .price {
            color: #388E3C;
            font-weight: bold;
            font-size: 17px;
            margin-bottom: 4px;
        }
        .product-card .desc {
            font-size: 13px;
            color: #757575;
        }
        .product-card .tag {
            display: flex;
            align-items: center;
            font-size: 13px;
            color: #FBC02D;
            margin-top: 6px;
        }
        .product-card .tag i {
            margin-right: 4px;
        }
        @media (max-width: 900px) {
            .recommendations {
                flex-direction: column;
                gap: 0;
            }
            .product-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
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
    <div class="container">
        <div class="section">
            <h2 style="margin-bottom:18px;">Kategori</h2>
            <div class="categories">
                <div class="category selected">
                    <i class="fas fa-th-large"></i>
                    <span>Semua</span>
                </div>
                <div class="category">
                    <i class="fas fa-tshirt"></i>
                    <span>Fashion</span>
                </div>
                <div class="category">
                    <i class="fas fa-couch"></i>
                    <span>Furniture</span>
                </div>
                <div class="category">
                    <i class="fas fa-plug"></i>
                    <span>Elektronik</span>
                </div>
                <div class="category">
                    <i class="fas fa-gem"></i>
                    <span>Aksesoris</span>
                </div>
                <div class="category">
                    <i class="fas fa-running"></i>
                    <span>Sepatu</span>
                </div>
                <div class="category">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Tas</span>
                </div>
                <div class="category">
                    <i class="fas fa-paint-brush"></i>
                    <span>Kosmetik</span>
                </div>
                <div class="category">
                    <i class="fas fa-home"></i>
                    <span>Perabotan</span>
                </div>
            </div>
        </div>
        <div class="section">
            <h3>Rekomendasi Untuk Anda</h3>
            <div class="recommendations">
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">hp</div>
                        <div class="price">Rp. 123.213</div>
                        <div class="tag"><i class="fas fa-star"></i>Baru dengan tag</div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">buku cerita</div>
                        <div class="price">Rp. 10.000</div>
                        <div class="tag"><i class="fas fa-star"></i>Bekas</div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">jembatan</div>
                        <div class="price">Rp. 30.000</div>
                        <div class="tag"><i class="fas fa-star"></i>Baru dengan tag</div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">ikan mujaer<br>yyyyyyyyyyyyyyyyyyyy</div>
                        <div class="price">Rp. 1.222.222.222.222</div>
                        <div class="tag"><i class="fas fa-star"></i>Baru</div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">ayam jagoo</div>
                        <div class="price">Rp. 8.888.888.888.888</div>
                        <div class="tag"><i class="fas fa-star"></i>Bekas seperti baru</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
