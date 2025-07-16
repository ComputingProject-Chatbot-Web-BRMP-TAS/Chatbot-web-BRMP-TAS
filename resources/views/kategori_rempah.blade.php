@extends('layouts.app')
@section('content')
<style>
.kategori-banner {
    margin: 60px 0 20px 0;
    background: #4CAF50;
    color: white;
    text-align: center;
    padding: 40px 0;
}

.breadcrumb-section {
    background: #f8f9fa;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
}

.breadcrumb-custom {
    margin: 0;
    padding: 0;
    background: none;
    font-size: 0.9rem;
}

.breadcrumb-custom .breadcrumb-item {
    color: #666;
}

.breadcrumb-custom .breadcrumb-item a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb-custom .breadcrumb-item a:hover {
    text-decoration: underline;
}

.breadcrumb-custom .breadcrumb-item.active {
    color: #495057;
}

.content-wrapper {
    background: #f8f9fa;
    min-height: 100vh;
    padding: 20px;
    margin-top: 80px;
}

.main-content {
    background: white;
    padding: 20px;
    margin: 0;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 2px solid #4CAF50;
}

.filter-sidebar {
    background: white;
    padding: 20px;
    border-radius: 12px;
    height: fit-content;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 2px solid #4CAF50;
}

.filter-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #4CAF50;
}

.filter-section {
    margin-bottom: 25px;
}

.filter-section-title {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 12px;
    color: #4CAF50;
}

.filter-option {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    padding: 4px 0;
}

.filter-option input[type="checkbox"] {
    margin-right: 8px;
    width: 16px;
    height: 16px;
    accent-color: #4CAF50;
}

.filter-option label {
    font-size: 0.9rem;
    color: #666;
    cursor: pointer;
    margin: 0;
}

.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e9ecef;
}

.products-count {
    font-size: 0.9rem;
    color: #666;
}

.products-count strong {
    color: #4CAF50;
}

.sort-dropdown {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sort-dropdown label {
    font-size: 0.9rem;
    color: #666;
    margin: 0;
}

.sort-dropdown select {
    border: 1px solid #4CAF50;
    border-radius: 4px;
    padding: 6px 12px;
    font-size: 0.9rem;
    background: white;
    color: #4CAF50;
}

.sort-dropdown select:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
}

.product-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
    text-decoration: none;
    color: inherit;
}

.product-card:hover {
    box-shadow: 0 4px 16px rgba(76, 175, 80, 0.15);
    border-color: #4CAF50;
    transform: translateY(-2px);
}

.product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-bottom: 1px solid #f0f0f0;
}

.product-info {
    padding: 12px;
}

.product-title {
    font-size: 0.9rem;
    color: #333;
    margin-bottom: 8px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    font-size: 1rem;
    font-weight: 600;
    color: #FF6B35;
    margin-bottom: 6px;
}

.product-location {
    font-size: 0.8rem;
    color: #999;
    margin-bottom: 8px;
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
}

.heart-icon {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #4CAF50;
    z-index: 10;
}

.heart-icon:hover {
    background: #4CAF50;
    color: white;
    transform: scale(1.1);
}

.no-products {
    text-align: center;
    padding: 60px 20px;
    color: #999;
}

.no-products-text {
    font-size: 1.1rem;
    margin-bottom: 10px;
    color: #4CAF50;
}

.no-products-subtitle {
    font-size: 0.9rem;
    color: #bbb;
}

@media (max-width: 768px) {
    .content-wrapper {
        padding: 15px;
        margin-top: 60px;
    }
    
    .filter-sidebar {
        border-right: none;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 20px;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 12px;
    }
    
    .product-image {
        height: 160px;
    }
    
    .products-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
}

@media (max-width: 576px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<!-- Main Content -->
<div class="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row g-4">
            <!-- Filter Sidebar -->
            <div class="col-lg-2 col-md-3">
                <div class="filter-sidebar">
                    <div class="filter-title">Filter</div>
                    
                    <div class="filter-section">
                        <div class="filter-section-title">Jenis Rempah</div>
                        <div class="filter-option">
                            <input type="checkbox" id="jahe">
                            <label for="jahe">Jahe</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="kunyit">
                            <label for="kunyit">Kunyit</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="temulawak">
                            <label for="temulawak">Temulawak</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="kencur">
                            <label for="kencur">Kencur</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="lengkuas">
                            <label for="lengkuas">Lengkuas</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="kapulaga">
                            <label for="kapulaga">Kapulaga</label>
                        </div>
                    </div>

                    <div class="filter-section">
                        <div class="filter-section-title">Lokasi</div>
                        <div class="filter-option">
                            <input type="checkbox" id="jakarta">
                            <label for="jakarta">Jakarta</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="bandung">
                            <label for="bandung">Bandung</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="surabaya">
                            <label for="surabaya">Surabaya</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="col-lg-10 col-md-9">
                <div class="main-content">
                    <div class="products-header">
                        <div class="products-count">
                            Menampilkan {{ $products->count() }} produk untuk <strong>"Rempah-Rempah/Herbal"</strong> (1 - {{ $products->count() }} of {{ $products->count() }})
                        </div>
                        <div class="sort-dropdown">
                            <label for="sort">Urutkan:</label>
                            <select id="sort" name="sort">
                                <option value="relevant">Paling Sesuai</option>
                                <option value="newest">Terbaru</option>
                                <option value="price-low">Harga Terendah</option>
                                <option value="price-high">Harga Tertinggi</option>
                            </select>
                        </div>
                    </div>

                    @if($products->count() > 0)
                        <div class="products-grid">
                            @foreach($products as $produk)
                                <a href="{{ route('produk.detail', $produk->produk_id) }}" class="product-card">
                                    <div class="product-badge">Baru</div>
                                    <button class="heart-icon" onclick="event.preventDefault();">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    </button>
                                    <img src="{{ asset('images/' . $produk->gambar) }}" 
                                         class="product-image" 
                                         alt="{{ $produk->nama }}">
                                    <div class="product-info">
                                        <div class="product-title">{{ $produk->nama }}</div>
                                        <div class="product-price">Rp{{ number_format($produk->harga, 0, ',', '.') }}</div>
                                        <div class="product-location">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                                <circle cx="12" cy="10" r="3"/>
                                            </svg>
                                            Jakarta Barat
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="no-products">
                            <div class="no-products-text">Produk tidak ditemukan</div>
                            <div class="no-products-subtitle">Coba ubah kata kunci atau filter pencarian</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('after_content')
    @include('partials.mitra_footer')
@endsection
@endsection 