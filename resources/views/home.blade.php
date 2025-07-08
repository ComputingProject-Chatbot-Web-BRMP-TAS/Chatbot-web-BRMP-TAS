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
            background: #f8f9fa;
            margin: 0;
            color: #222;
        }
        .hero-banner {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 50%, #CDDC39 100%);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .hero-content {
            flex: 1;
            max-width: 60%;
        }
        .hero-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 12px;
            line-height: 1.2;
        }
        .hero-subtitle {
            font-size: 1.1rem;
            margin-bottom: 24px;
            opacity: 0.95;
            line-height: 1.4;
        }
        .hero-btn {
            background: #FFF176;
            color: #388E3C;
            border: none;
            border-radius: 12px;
            padding: 12px 28px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .hero-btn:hover {
            background: #FFF59D;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }
        .hero-icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-icon-circle {
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
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
            .hero-banner {
                flex-direction: column;
                text-align: center;
                padding: 32px 24px;
            }
            .hero-content {
                max-width: 100%;
                margin-bottom: 24px;
            }
            .hero-title {
                font-size: 1.8rem;
            }
            .hero-subtitle {
                font-size: 1rem;
            }
            .hero-icon-circle {
                width: 100px;
                height: 100px;
                font-size: 40px;
            }
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
    @include('partials.appbar')
    
    <div class="container">
        <!-- Hero Banner Section -->
        <div class="hero-banner">
            <div class="hero-content">
                <h1 class="hero-title">Produk Baru Telah Hadir!</h1>
                <p class="hero-subtitle">Temukan koleksi produk terbaru dengan penawaran menarik hanya di Benih BRMP.</p>
                <button class="hero-btn">Lihat Produk Baru</button>
            </div>
            <div class="hero-icon">
                <div class="hero-icon-circle">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>
        
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
                <a href="{{ route('produk.detail', 'hp') }}" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">hp</div>
                        <div class="price">Rp. 123.213</div>
                        <div class="tag"><i class="fas fa-star"></i>Baru dengan tag</div>
                    </div>
                </div>
                </a>
                <a href="{{ route('produk.detail', 'buku-cerita') }}" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">buku cerita</div>
                        <div class="price">Rp. 10.000</div>
                        <div class="tag"><i class="fas fa-star"></i>Bekas</div>
                    </div>
                </div>
                </a>
                <a href="{{ route('produk.detail', 'jembatan') }}" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">jembatan</div>
                        <div class="price">Rp. 30.000</div>
                        <div class="tag"><i class="fas fa-star"></i>Baru dengan tag</div>
                    </div>
                </div>
                </a>
                <a href="{{ route('produk.detail', 'ikan-mujaer') }}" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">ikan mujaer<br>yyyyyyyyyyyyyyyyyyyy</div>
                        <div class="price">Rp. 1.222.222.222.222</div>
                        <div class="tag"><i class="fas fa-star"></i>Baru</div>
                    </div>
                </div>
                </a>
                <a href="{{ route('produk.detail', 'ayam-jagoo') }}" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <div class="image-placeholder"><i class="fas fa-image"></i></div>
                    <div class="info">
                        <div class="title">ayam jagoo</div>
                        <div class="price">Rp. 8.888.888.888.888</div>
                        <div class="tag"><i class="fas fa-star"></i>Bekas seperti baru</div>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>