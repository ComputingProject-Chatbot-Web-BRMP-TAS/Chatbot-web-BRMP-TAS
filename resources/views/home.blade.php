@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
            margin: 0;
            color: #222;
        }
        /* Floating leaves animation */
        .floating-leaves {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        .leaf {
            position: absolute;
            color: #4CAF50;
            font-size: 20px;
            animation: float 6s ease-in-out infinite;
            opacity: 0.3;
        }
        .leaf:nth-child(1) { left: 10%; animation-delay: 0s; }
        .leaf:nth-child(2) { left: 20%; animation-delay: 2s; }
        .leaf:nth-child(3) { left: 30%; animation-delay: 4s; }
        .leaf:nth-child(4) { left: 40%; animation-delay: 1s; }
        .leaf:nth-child(5) { left: 50%; animation-delay: 3s; }
        .leaf:nth-child(6) { left: 60%; animation-delay: 5s; }
        .leaf:nth-child(7) { left: 70%; animation-delay: 1.5s; }
        .leaf:nth-child(8) { left: 80%; animation-delay: 3.5s; }
        .leaf:nth-child(9) { left: 90%; animation-delay: 0.5s; }
        @keyframes float {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.3; }
            90% { opacity: 0.3; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 0.3; }
        }
        .hero-banner {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 50%, #CDDC39 100%);
            border-radius: 20px;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(76, 175, 80, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1;
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
            position: relative;
            z-index: 1;
        }
        .section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            padding: 24px 18px;
            margin-bottom: 32px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
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
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            width: 100%;
            box-sizing: border-box;
        }
        .product-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            min-height: 260px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 0 0 16px 0;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            border: 1px solid rgba(76, 175, 80, 0.1);
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
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
        .hero-banner-margin {
            margin: 60px 0 32px 0;
        }
    </style>
    <!-- Floating leaves animation -->
    <div class="floating-leaves">
        <div class="leaf">🍃</div>
        <div class="leaf">🌿</div>
        <div class="leaf">🍃</div>
        <div class="leaf">🌱</div>
        <div class="leaf">🍃</div>
        <div class="leaf">🌿</div>
        <div class="leaf">🍃</div>
        <div class="leaf">🌱</div>
        <div class="leaf">🍃</div>
    </div>
    <div class="container">
        <!-- Hero Banner Section -->
        <div class="hero-banner hero-banner-margin">
            <div class="hero-content">
                <h1 class="hero-title">Produk Baru Telah Hadir!</h1>
                <p class="hero-subtitle">Temukan koleksi produk terbaru dengan penawaran menarik hanya di Benih BRMP.</p>
                <button class="hero-btn" onclick="window.location.href='{{ route('produk.baru') }}'">Lihat Produk Baru</button>
            </div>
            <div class="hero-icon">
                <div class="hero-icon-circle">
                    <i class="fas fa-seedling"></i>
                </div>
            </div>
        </div>
        
        <div class="section" style="margin-bottom:24px;">
            <h2 style="font-weight:bold; margin-bottom:18px;">Produk Pilihan</h2>
            <div class="product-grid" style="display:grid;grid-template-columns:repeat(5,1fr);gap:24px;">
                <a href="/produk/1" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/7/6/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Cabai Rawit" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Cabai Rawit</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 15.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Isi 50 butir, cocok untuk pekarangan rumah.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
                </a>
                <a href="/produk/2" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/12/1/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Tomat" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Tomat</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 12.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Tahan penyakit, hasil melimpah.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
                </a>
                <a href="/produk/3" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/10/10/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Kangkung" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Kangkung</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 8.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Cepat panen, cocok untuk hidroponik.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
                </a>
                <a href="/produk/4" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/1/15/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Bayam" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Bayam</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 7.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Bayam hijau segar, mudah tumbuh.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
                </a>
                <a href="/produk/5" style="text-decoration:none;color:inherit;">
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/3/20/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Wortel" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Wortel</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 10.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Wortel oranye, cocok untuk dataran tinggi.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="section">
            <h3>Rekomendasi Untuk Anda</h3>
            <div class="product-grid" style="display:grid;grid-template-columns:repeat(5,1fr);gap:24px;">
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/7/6/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Cabai Rawit" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Cabai Rawit</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 15.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Isi 50 butir, cocok untuk pekarangan rumah.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/12/1/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Tomat" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Tomat</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 12.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Tahan penyakit, hasil melimpah.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/10/10/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Kangkung" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Kangkung</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 8.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Cepat panen, cocok untuk hidroponik.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/1/15/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Bayam" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Bayam</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 7.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Bayam hijau segar, mudah tumbuh.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
                <div class="product-card">
                    <img src="https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/3/20/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg" alt="Benih Wortel" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
                    <div class="info" style="padding:12px 16px 0 16px;">
                        <div class="title" style="font-weight:500;font-size:16px;margin-bottom:4px;">Benih Wortel</div>
                        <div class="price" style="color:#388E3C;font-weight:bold;font-size:17px;margin-bottom:4px;">Rp 10.000</div>
                        <div class="desc" style="font-size:13px;color:#757575;">Wortel oranye, cocok untuk dataran tinggi.</div>
                        <div class="tag" style="display:flex;align-items:center;font-size:13px;color:#FBC02D;margin-top:6px;"><i class="fas fa-star" style="margin-right:4px;"></i>Baru</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_content')
    @include('partials.mitra_footer')
@endsection