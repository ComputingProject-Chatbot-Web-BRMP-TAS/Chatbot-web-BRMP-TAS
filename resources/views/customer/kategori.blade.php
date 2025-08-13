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
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.filter-reset {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #6c757d;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s;
}
.filter-reset:hover {
    background: #e9ecef;
    color: #495057;
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
.filter-option:hover label {
    color: #4CAF50;
}
.filter-option input[type="checkbox"]:checked + label {
    color: #4CAF50;
    font-weight: 500;
}
.price-filter {
    margin-bottom: 20px;
}
.price-inputs {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}
.price-inputs input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.price-inputs input:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}
.price-inputs input:invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2);
}
.stock-filter {
    margin-bottom: 20px;
}
.stock-options {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.stock-option {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 0;
}
.stock-option input[type="radio"] {
    accent-color: #4CAF50;
}
.stock-option label {
    font-size: 0.9rem;
    color: #666;
    cursor: pointer;
    margin: 0;
    transition: color 0.2s;
}
.stock-option:hover label {
    color: #4CAF50;
}
.stock-option input[type="radio"]:checked + label {
    color: #4CAF50;
    font-weight: 500;
}
.btn-primary {
    transition: all 0.2s ease;
}
.btn-primary:hover {
    background: #45a049 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(76, 175, 80, 0.3);
}
.btn-primary:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(76, 175, 80, 0.3);
}
.btn-primary:disabled {
    cursor: not-allowed;
    opacity: 0.7;
}
.btn-loading i {
    margin-right: 5px;
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
    font-size: 0.95rem;
    color: #666;
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
    padding: 6px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.9rem;
    background: white;
    cursor: pointer;
}
.sort-dropdown select:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
    margin-top: 16px;
}
.product-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(60,60,60,0.06);
    padding: 20px 16px 16px 16px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    min-height: 220px;
    border: 1.5px solid #e0e0e0;
    transition: box-shadow 0.2s, border-color 0.2s;
}
.product-card:hover {
    box-shadow: 0 4px 16px rgba(60,60,60,0.12);
    border-color: #4CAF50;
}
.product-card-image img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    margin-bottom: 16px;
    background: #f5f5f5;
    border-radius: 8px;
}
.product-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
    color: #222;
}
.product-card-price {
    color: #388e3c;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 6px;
}
.product-card-desc {
    color: #555;
    font-size: 0.97rem;
    margin-bottom: 8px;
    min-height: 32px;
}
.product-card-stock {
    font-size: 0.93rem;
    color: #888;
    margin-top: auto;
}
.product-card-badge {
    display: inline-block;
    background: #4CAF50;
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 6px;
    padding: 2px 10px;
    margin-top: 8px;
}
.loading {
    text-align: center;
    padding: 40px;
    color: #666;
}
.loading::after {
    content: '';
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid #4CAF50;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s ease-in-out infinite;
    margin-left: 10px;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
.no-products {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}
.no-products-text {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #495057;
}
.no-products-subtitle {
    font-size: 0.95rem;
    color: #888;
}
@media (max-width: 576px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .products-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    .price-inputs {
        flex-direction: column;
    }
    .filter-sidebar {
        margin-bottom: 20px;
    }
    .main-content {
        padding: 15px;
    }
    .content-wrapper {
        padding: 15px;
    }
    .filter-title {
        font-size: 1rem;
    }
    .filter-section-title {
        font-size: 0.9rem;
    }
}
@media (max-width: 768px) {
    .col-lg-2.col-md-3 {
        order: 2;
    }
    .col-lg-10.col-md-9 {
        order: 1;
    }
    .filter-sidebar {
        position: sticky;
        top: 20px;
        z-index: 100;
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
                    <div class="filter-title">
                        Filter
                        <button type="button" class="filter-reset" onclick="resetFilters()">Reset</button>
                    </div>
                    <form method="GET" id="filterForm">
                        <input type="hidden" name="kategori" value="{{ request()->route('kategori') }}">
                        
                        <!-- Plant Type Filter -->
                        <div class="filter-section">
                            <div class="filter-section-title">Jenis Tanaman</div>
                            @foreach($plantTypes as $type)
                                <div class="filter-option">
                                    <input type="checkbox" id="plant_type_{{ $type->plant_type_id }}" name="plant_types[]" value="{{ $type->plant_type_id }}" {{ in_array($type->plant_type_id, (array) request('plant_types', [])) ? 'checked' : '' }}>
                                    <label for="plant_type_{{ $type->plant_type_id }}">{{ $type->plant_type_name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Filter -->
                        <div class="filter-section">
                            <div class="filter-section-title">Rentang Harga</div>
                            <div class="price-filter">
                                <div class="price-inputs">
                                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" min="0" step="1000">
                                </div>
                                <div class="price-inputs">
                                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" min="0" step="1000">
                                </div>
                            </div>
                        </div>

                        <!-- Stock Filter -->
                        <div class="filter-section">
                            <div class="filter-section-title">Ketersediaan Stok</div>
                            <div class="stock-filter">
                                <div class="stock-options">
                                    <div class="stock-option">
                                        <input type="radio" id="stock_all" name="stock_filter" value="all" {{ request('stock_filter', 'all') == 'all' ? 'checked' : '' }}>
                                        <label for="stock_all">Semua</label>
                                    </div>
                                    <div class="stock-option">
                                        <input type="radio" id="stock_available" name="stock_filter" value="available" {{ request('stock_filter') == 'available' ? 'checked' : '' }}>
                                        <label for="stock_available">Tersedia</label>
                                    </div>
                                    <div class="stock-option">
                                        <input type="radio" id="stock_low" name="stock_filter" value="low" {{ request('stock_filter') == 'low' ? 'checked' : '' }}>
                                        <label for="stock_low">Stok Menipis (≤10)</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Apply Filter Button -->
                        <button type="submit" class="btn btn-primary w-100" id="applyFilterBtn" style="background: #4CAF50; border: none; padding: 10px; border-radius: 6px; font-weight: 500; transition: all 0.2s;">
                            <span class="btn-text">Terapkan Filter</span>
                            <span class="btn-loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Memproses...
                            </span>
                        </button>
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
                                <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Nama Z-A</option>
                                <option value="price-low" {{ request('sort') == 'price-low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="stock-high" {{ request('sort') == 'stock-high' ? 'selected' : '' }}>Stok Tertinggi</option>
                                <option value="stock-low" {{ request('sort') == 'stock-low' ? 'selected' : '' }}>Stok Terendah</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="productsContainer">
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
</div>
@section('after_content')
    @include('customer.partials.mitra_footer')
@endsection

@push('scripts')
<script>
// Store original products data for sorting
let originalProducts = [];
let currentSort = '{{ request("sort", "name-asc") }}';

// Initialize products data
document.addEventListener('DOMContentLoaded', function() {
    const productCards = document.querySelectorAll('.product-card');
    originalProducts = Array.from(productCards).map(card => {
        const price = parseInt(card.getAttribute('data-price')) || 0;
        const stock = parseInt(card.getAttribute('data-stock')) || 0;
        const name = card.getAttribute('data-name') || '';
        
        return {
            element: card,
            price: price,
            stock: stock,
            name: name
        };
    });
    
    // Apply initial sort
    if (currentSort) {
        sortProducts();
    }
    
    // Initialize filter functionality
    initializeFilters();
});

function initializeFilters() {
    // Add input validation for price filters
    const minPriceInput = document.querySelector('input[name="min_price"]');
    const maxPriceInput = document.querySelector('input[name="max_price"]');
    
    if (minPriceInput && maxPriceInput) {
        // Validate min price cannot be greater than max price
        minPriceInput.addEventListener('input', function() {
            const minPrice = parseInt(this.value) || 0;
            const maxPrice = parseInt(maxPriceInput.value) || 0;
            
            if (maxPrice > 0 && minPrice > maxPrice) {
                this.setCustomValidity('Harga minimum tidak boleh lebih besar dari harga maksimum');
            } else {
                this.setCustomValidity('');
            }
        });
        
        maxPriceInput.addEventListener('input', function() {
            const maxPrice = parseInt(this.value) || 0;
            const minPrice = parseInt(minPriceInput.value) || 0;
            
            if (minPrice > 0 && maxPrice < minPrice) {
                this.setCustomValidity('Harga maksimum tidak boleh lebih kecil dari harga minimum');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Add form submission validation
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            const minPrice = parseInt(minPriceInput?.value) || 0;
            const maxPrice = parseInt(maxPriceInput?.value) || 0;
            
            if (minPrice > 0 && maxPrice > 0 && minPrice > maxPrice) {
                e.preventDefault();
                alert('Harga minimum tidak boleh lebih besar dari harga maksimum');
                return false;
            }
            
            // Show loading state
            const applyBtn = document.getElementById('applyFilterBtn');
            if (applyBtn) {
                const btnText = applyBtn.querySelector('.btn-text');
                const btnLoading = applyBtn.querySelector('.btn-loading');
                
                if (btnText && btnLoading) {
                    btnText.style.display = 'none';
                    btnLoading.style.display = 'inline-block';
                    applyBtn.disabled = true;
                    applyBtn.style.opacity = '0.7';
                }
            }
        });
    }
}

function sortProducts() {
    const sortSelect = document.getElementById('sort');
    const productsGrid = document.getElementById('productsGrid');
    const sortType = sortSelect.value;
    currentSort = sortType;
    
    if (!productsGrid || originalProducts.length === 0) return;
    
    // Sort products based on selected criteria
    originalProducts.sort((a, b) => {
        switch(sortType) {
            case 'name-asc':
                return a.name.localeCompare(b.name);
            case 'name-desc':
                return b.name.localeCompare(a.name);
            case 'price-low':
                return a.price - b.price;
            case 'price-high':
                return b.price - a.price;
            case 'stock-high':
                return b.stock - a.stock;
            case 'stock-low':
                return a.stock - b.stock;
            default:
                return 0;
        }
    });
    
    // Clear and re-append sorted products
    productsGrid.innerHTML = '';
    originalProducts.forEach(product => {
        productsGrid.appendChild(product.element);
    });
    
    // Update URL without page reload
    updateURL();
}

function resetFilters() {
    // Reset all checkboxes
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Reset price inputs
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.value = '';
    });
    
    // Reset stock filter
    document.getElementById('stock_all').checked = true;
    
    // Reset sort
    document.getElementById('sort').value = 'name-asc';
    
    // Submit form
    document.getElementById('filterForm').submit();
}

function updateURL() {
    const url = new URL(window.location);
    url.searchParams.set('sort', currentSort);
    window.history.replaceState({}, '', url);
}
</script>
@endpush 