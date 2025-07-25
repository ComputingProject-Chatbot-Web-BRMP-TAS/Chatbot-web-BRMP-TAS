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
                    <form method="GET" id="filterForm">
                        <input type="hidden" name="kategori" value="{{ request()->route('kategori') }}">
                        <div class="filter-section">
                            @foreach($plantTypes as $type)
                                <div class="filter-option">
                                    <input type="checkbox" id="plant_type_{{ $type->plant_type_id }}" name="plant_types[]" value="{{ $type->plant_type_id }}" onchange="document.getElementById('filterForm').submit()" {{ in_array($type->plant_type_id, (array) request('plant_types', [])) ? 'checked' : '' }}>
                                    <label for="plant_type_{{ $type->plant_type_id }}">{{ $type->plant_type_name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
            <!-- Products Section -->
            <div class="col-lg-10 col-md-9">
                <div class="main-content">
                    <div class="products-header">
                        <div class="products-count">
                            Menampilkan {{ $products->count() }} produk untuk <strong>"{{ $judul }}"</strong>
                        </div>
                        <div class="sort-dropdown">
                            <label for="sort">Urutkan:</label>
                            <select id="sort" name="sort" onchange="sortProducts()">
                                <option value="price-low">Harga Terendah</option>
                                <option value="price-high">Harga Tertinggi</option>
                            </select>
                        </div>
                    </div>
                    @if($products->count() > 0)
                        <div class="products-grid" id="productsGrid">
                            @foreach($products as $product)
                                @include('customer.partials.product-card', ['product' => $product])
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
    @include('customer.partials.mitra_footer')
@endsection
<script>
function sortProducts() {
    const sortSelect = document.getElementById('sort');
    const productsGrid = document.getElementById('productsGrid');
    const productCards = Array.from(productsGrid.querySelectorAll('.product-card'));
    const sortType = sortSelect.value;
    productCards.sort((a, b) => {
        const priceA = parseInt(a.getAttribute('data-price'));
        const priceB = parseInt(b.getAttribute('data-price'));
        if (sortType === 'price-low') {
            return priceA - priceB;
        } else if (sortType === 'price-high') {
            return priceB - priceA;
        }
    });
    productCards.forEach(card => card.remove());
    productCards.forEach(card => productsGrid.appendChild(card));
}
</script> 