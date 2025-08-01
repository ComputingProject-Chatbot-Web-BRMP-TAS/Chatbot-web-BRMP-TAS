@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@php
    $latestProducts = App\Models\Product::orderBy('product_id','desc')->take(5)->pluck('product_id')->toArray();
@endphp
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
                        <div class="filter-section-title">Kategori</div>
                        <div class="filter-option">
                            <input type="checkbox" id="pemanis">
                            <label for="pemanis">Tanaman Pemanis</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="serat">
                            <label for="serat">Tanaman Serat</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="tembakau">
                            <label for="tembakau">Tanaman Tembakau</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="minyak">
                            <label for="minyak">Tanaman Minyak Industri</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="col-lg-10 col-md-9">
                <div class="main-content">
                    <div class="products-header">
                        <div class="products-count">
                            Menampilkan produk baru terbaru
                        </div>
                        <div class="sort-dropdown">
                            <label for="sort">Urutkan:</label>
                            <select id="sort" name="sort" onchange="sortProducts()">
                                <option value="price-low">Harga Terendah</option>
                                <option value="price-high">Harga Tertinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="products-grid" id="productsGrid">
                        @forelse($products as $product)
                            @php
                                $availableStock = $product->stock - $product->minimum_stock;
                                $isOutOfStock = $availableStock <= 0;
                            @endphp
                            <a href="{{ route('produk.detail', $product->product_id) }}" class="product-card" data-price="{{ $product->price_per_unit }}" style="{{ $isOutOfStock ? 'opacity: 0.7; filter: grayscale(30%);' : '' }}">
                                @if(in_array($product->product_id, $latestProducts))
                                    <div class="product-badge">Baru</div>
                                @endif
                                @if($isOutOfStock)
                                    <div style="position:absolute;top:8px;right:8px;background:#d32f2f;color:white;padding:4px 8px;border-radius:6px;font-size:11px;font-weight:500;z-index:10;box-shadow:0 2px 4px rgba(211,47,47,0.3);">
                                        <i class="fas fa-times-circle" style="margin-right:2px;"></i>Stok Habis
                                    </div>
                                @endif
                                <button class="heart-icon" onclick="event.preventDefault();">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                    </svg>
                                </button>
                                @if($product->image1)
                                    <img src="{{ asset('images/' . $product->image1) }}" class="product-image" alt="{{ $product->product_name }}">
                                @else
                                    <img src="https://via.placeholder.com/200x200?text=No+Image" class="product-image" alt="No Image">
                                @endif
                                <div class="product-info">
                                    <div class="product-title">{{ $product->product_name }}</div>
                                    <div class="product-price">Rp{{ number_format($product->price_per_unit, 0, ',', '.') }}</div>
                                    <div class="product-location">Kategori: {{ $product->jenis_kategori }}</div>
                                    <div class="product-stock" style="font-size:12px;color:{{ $isOutOfStock ? '#d32f2f' : '#888' }};margin-top:4px;">
                                        Stok: {{ $availableStock }} {{ $product->unit }}
                                        @if($isOutOfStock)
                                            <span style="font-weight:500;">(Habis)</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="no-products">Belum ada produk baru.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('after_content')
    @include('customer.partials.mitra_footer')
@endsection

<script>
function sortProducts() {
    const sortSelect = document.getElementById('sort');
    const productsGrid = document.getElementById('productsGrid');
    const productCards = Array.from(productsGrid.querySelectorAll('.product-card'));
    
    const sortType = sortSelect.value;
    
    productCards.sort((a, b) => {
        const priceA = parseInt(a.getAttribute('data-price'));       const priceB = parseInt(b.getAttribute('data-price'));
        
        if (sortType === 'price-low') {
            return priceA - priceB; // Harga terendah ke tertinggi
        } else if (sortType === 'price-high') {
            return priceB - priceA; // Harga tertinggi ke terendah
        }
    });
    
    // Hapus semua card yang ada
    productCards.forEach(card => card.remove());
    
    // Tambahkan kembali card yang sudah diurutkan
    productCards.forEach(card => productsGrid.appendChild(card));
}
</script>
@endsection 