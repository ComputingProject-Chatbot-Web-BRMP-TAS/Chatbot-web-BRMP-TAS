@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <style>
        .bg-image {
            background-image: url('images/image 15.png');
            background-repeat: no-repeat;
            background-position: top center;
            border-radius: 20px 20px 0 0;
        }

        .hero-banner {
            border-radius: 16px;
            background: rgba(146, 146, 146, 0.2);
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(5px);
            display: flex;
            padding: 40px;
            flex-direction: column;
            align-items: flex-start;
            position: relative;
            margin-bottom: 50px;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .hero-subtitle {
            font-size: 14px;
            margin-bottom: 43px;
            color: #fff;
            font-weight: 500;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            padding: 24px 18px;
            margin-bottom: 32px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }

        .hero-banner-margin {
            margin: 60px 0 32px 0;
        }
    </style>

    <div class="container">
        <!-- Hero Banner Section -->
        <div class="hero-banner">
            <h1 class="hero-title">
                <div>PRODUK BARU
                </div>
                <div>
                    KINI
                    <span style="color:#A1FF00">
                        TELAH HADIR.
                    </span>
                </div>
            </h1>
            <p class="hero-subtitle">Temukan koleksi produk terbaru dengan penawaran menarik hanya di Benih BRMP.</p>
            <button class="hero-btn" onclick="window.location.href='{{ route('produk.baru') }}'">Lihat Produk
                Baru</button>
        </div>

        <div class="section" style="margin-bottom:24px;">
            <h2 style="font-weight:bold; margin-bottom:18px;">
                @if (isset($q) && $q)
                    Hasil pencarian untuk: <span style="color:#388E3C">"{{ $q }}"</span>
                @else
                    Produk Pilihan
                @endif
            </h2>
            @if ($products->count() > 0)
                <div class="product-grid" id="productsGrid">
                    @foreach ($products as $product)
                        @include('customer.partials.product-card', ['produk' => $product])
                    @endforeach
                </div>

                <!-- Tombol Lebih Banyak -->
                <div id="loadMoreContainer" style="text-align:center;margin-top:30px;">
                    <button id="loadMoreBtn" class="btn-green"
                        style="background:#4CAF50;color:#fff;border:none;border-radius:8px;padding:12px 32px;font-weight:600;transition:all 0.3s ease;">
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
            fetch('/reset-products-session', {
                method: 'GET'
            });
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
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.18);
        cursor: pointer;
        transition: box-shadow 0.2s, transform 0.2s;
        font-size: 32px;
    }

    .cs-bubble:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.22);
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
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .cs-dropdown-btn {
        background: #fff;
        color: #388E3C;
        border: none;
        border-radius: 12px;
        padding: 12px 20px;
        font-size: 1.1rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
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
    <a href="https://wa.me/6281331162878?text=Halo%2C%20saya%20punya%20keluhan%20atau%20pertanyaan%20yang%20ingin%20saya%20sampaikan."
        target="_blank" class="cs-dropdown-btn" style="text-decoration:none;">
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
