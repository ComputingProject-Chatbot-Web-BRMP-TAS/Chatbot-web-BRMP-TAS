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
        .product-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #4CAF50;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 10;
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
        <!-- Hapus search bar di homepage -->
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
            <h2 style="font-weight:bold; margin-bottom:18px;">
                @if(isset($q) && $q)
                    Hasil pencarian untuk: <span style="color:#388E3C">"{{ $q }}"</span>
                @else
                    Produk Pilihan
                @endif
            </h2>
            @if($products->count() > 0)
            <div class="product-grid" id="productsGrid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,20px);">
                @foreach($products as $product)
                    @include('customer.partials.product-card', ['produk' => $product])
                @endforeach
            </div>

            <!-- Tombol Lebih Banyak -->
            <div id="loadMoreContainer" style="text-align:center;margin-top:30px;">
                <button id="loadMoreBtn" class="btn-green" style="background:#4CAF50;color:#fff;border:none;border-radius:8px;padding:12px 32px;font-weight:600;transition:all 0.3s ease;">
                    <i class="fas fa-plus" style="margin-right:8px;"></i>
                    Lebih Banyak
                </button>
            </div>
            @else
                <div style="padding:32px 0;text-align:center;color:#888;font-size:18px;">Produk tidak ditemukan.</div>
            @endif
        </div>
        {{-- Hapus section rekomendasi --}}
    </div>
@endsection

@section('after_content')
    @include('customer.partials.mitra_footer')
    <script>
    let currentOffset = {{ $products->count() }};
    let totalProducts = {{ \App\Models\Product::count() }};
    let isLoading = false;

    // Reset session ketika halaman di-refresh
    window.addEventListener('beforeunload', function() {
        fetch('/reset-products-session', {method: 'GET'});
    });

    document.getElementById('loadMoreBtn').addEventListener('click', function() {
        if (isLoading) return;

        console.log('LoadMore button clicked, currentOffset:', currentOffset);
        
        isLoading = true;
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:8px;"></i>Memuat...';
        btn.disabled = true;

        fetch(`/load-more-products?offset=${currentOffset}`)
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                
                // Cek apakah ada error dari server
                if (data.error) {
                    throw new Error(data.error);
                }
                
                // Tambahkan produk baru ke grid
                if (data.html && data.html.trim() !== '') {
                    console.log('Adding HTML to grid, length:', data.html.length);
                    document.getElementById('productsGrid').insertAdjacentHTML('beforeend', data.html);
                } else {
                    console.log('No HTML content in response');
                }

                // Update offset berdasarkan total produk yang sudah dimuat
                currentOffset = data.totalLoaded;
                console.log('Updated currentOffset to:', currentOffset);

                // Sembunyikan tombol jika sudah tidak ada produk lagi
                if (!data.hasMore) {
                    console.log('No more products, hiding button');
                    document.getElementById('loadMoreContainer').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                console.error('Error message:', error.message);
                console.error('Error stack:', error.stack);
                alert('Terjadi kesalahan saat memuat produk: ' + error.message);
            })
            .finally(() => {
                isLoading = false;
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    });
    </script>
@endsection

<!-- Bubble Customer Service Button (Dropdown) -->
<style>
.cs-bubble {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    background: #388E3C;
    color: white;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(0,0,0,0.18);
    cursor: pointer;
    transition: box-shadow 0.2s, transform 0.2s;
    font-size: 32px;
}
.cs-bubble:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.22);
    transform: scale(1.08);
    background: #2e7d32;
}
.cs-dropdown {
    position: fixed;
    bottom: 90px;
    right: 24px;
    z-index: 10000;
    display: none;
    flex-direction: column;
    gap: 12px;
    animation: csDropdownUp 0.2s;
}
@keyframes csDropdownUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.cs-dropdown-btn {
    background: #fff;
    color: #388E3C;
    border: none;
    border-radius: 12px;
    padding: 12px 20px;
    font-size: 1.1rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
    min-width: 170px;
}
.cs-dropdown-btn:hover {
    background: #388E3C;
    color: #fff;
}
</style>
<div class="cs-bubble" id="csBubbleBtn" title="Customer Service">
    <i class="fas fa-headset"></i>
</div>
<div class="cs-dropdown" id="csDropdownMenu">
    <a href="https://wa.me/6281331162878?text=Halo%2C%20saya%20punya%20keluhan%20atau%20pertanyaan%20yang%20ingin%20saya%20sampaikan." target="_blank" class="cs-dropdown-btn" style="text-decoration:none;">
        <i class="fab fa-whatsapp"></i> WhatsApp
    </a>
    <a href="/komplain" class="cs-dropdown-btn" style="text-decoration:none;">
        <i class="fas fa-exclamation-circle"></i> Komplain
    </a>
</div>
<script>
    const csBubbleBtn = document.getElementById('csBubbleBtn');
    const csDropdownMenu = document.getElementById('csDropdownMenu');
    let csDropdownOpen = false;
    csBubbleBtn.addEventListener('click', function(e) {
        csDropdownOpen = !csDropdownOpen;
        csDropdownMenu.style.display = csDropdownOpen ? 'flex' : 'none';
    });
    // Close dropdown if click outside
    document.addEventListener('click', function(e) {
        if (!csBubbleBtn.contains(e.target) && !csDropdownMenu.contains(e.target)) {
            csDropdownMenu.style.display = 'none';
            csDropdownOpen = false;
        }
    });
</script>
<!-- END Bubble Customer Service Button -->
