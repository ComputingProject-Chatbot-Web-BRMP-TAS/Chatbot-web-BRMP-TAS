@extends('layouts.admin')

@section('content')
<style>
.filter-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 20px;
}

.filter-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.search-input-group {
    position: relative;
}

.search-input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.search-input-group .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.filter-badge {
    font-size: 0.75rem;
}

.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    color: #388E3C;
    border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #388E3C;
    border-color: #388E3C;
}

.pagination .page-link:hover {
    color: #2e7d32;
    background-color: #e8f5e8;
    border-color: #dee2e6;
}

@media (max-width: 768px) {
    .filter-card .row > div {
        margin-bottom: 10px;
    }
    
    .btn-group {
        flex-wrap: wrap;
    }
    
    .btn-group .btn {
        margin-bottom: 5px;
    }
}

.quick-filter-buttons {
    display: flex;
    gap: 5px;
}

.quick-filter-buttons .btn {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}

.load-more-btn {
    transition: all 0.3s ease;
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 600;
}

.load-more-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.load-more-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.load-more-container {
    padding: 20px 0;
}

.load-more-info {
    margin-top: 10px;
    color: #6c757d;
    font-size: 0.9rem;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table tbody tr {
    animation: fadeIn 0.5s ease-in-out;
}

.load-more-btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.table tbody tr td:first-child {
    font-weight: 500;
    text-align: center;
    min-width: 50px;
}

.table tbody tr:hover td:first-child {
    background-color: #f8f9fa;
}
</style>
<div style="padding-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Kelola Produk</h2>
                    <div>
                        <button class="btn btn-outline-success me-2" onclick="exportData()" title="Export Data">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </a>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="card mb-4 filter-card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-search"></i> Pencarian & Filter
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.products.index') }}" id="searchForm">
                            <div class="row">
                                <!-- Search Bar -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="search" class="form-label">Cari Produk</label>
                                        <div class="input-group search-input-group">
                                            <input type="text" class="form-control" id="search" name="search" 
                                                   placeholder="Nama produk, deskripsi, sertifikat..." 
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Plant Type Filter -->
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="plant_type_id" class="form-label">Kategori</label>
                                        <select class="form-select" id="plant_type_id" name="plant_type_id">
                                            <option value="">Semua Kategori</option>
                                            @foreach($plantTypes as $plantType)
                                                <option value="{{ $plantType->plant_type_id }}" 
                                                        {{ request('plant_type_id') == $plantType->plant_type_id ? 'selected' : '' }}>
                                                    {{ $plantType->plant_type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Stock Status Filter -->
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="stock_status" class="form-label">Status Stok</label>
                                        <select class="form-select" id="stock_status" name="stock_status">
                                            <option value="">Semua Status</option>
                                            <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Stok Menipis</option>
                                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Habis</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Certificate Filter -->
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="has_certificate" class="form-label">Sertifikat</label>
                                        <select class="form-select" id="has_certificate" name="has_certificate">
                                            <option value="">Semua</option>
                                            <option value="yes" {{ request('has_certificate') == 'yes' ? 'selected' : '' }}>Ada Sertifikat</option>
                                            <option value="no" {{ request('has_certificate') == 'no' ? 'selected' : '' }}>Tidak Ada</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Sort -->
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="sort_by" class="form-label">Urutkan</label>
                                        <select class="form-select" id="sort_by" name="sort_by">
                                            <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                                            <option value="product_name" {{ request('sort_by') == 'product_name' ? 'selected' : '' }}>Nama A-Z</option>
                                            <option value="price_per_unit" {{ request('sort_by') == 'price_per_unit' ? 'selected' : '' }}>Harga</option>
                                            <option value="stock" {{ request('sort_by') == 'stock' ? 'selected' : '' }}>Stok</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Range Filter -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price_min" class="form-label">Harga Minimum</label>
                                        <input type="number" class="form-control" id="price_min" name="price_min" 
                                               placeholder="0" value="{{ request('price_min') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price_max" class="form-label">Harga Maksimum</label>
                                        <input type="number" class="form-control" id="price_max" name="price_max" 
                                               placeholder="1000000" value="{{ request('price_max') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-filter"></i> Terapkan Filter
                                        </button>
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Produk</h5>
                        <div class="d-flex align-items-center">
                            <!-- Quick Filter Buttons -->
                            <div class="btn-group me-3 quick-filter-buttons" role="group">
                                <a href="{{ route('admin.products.index') }}" 
                                   class="btn btn-sm {{ !request('stock_status') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Semua
                                </a>
                                <a href="{{ route('admin.products.index', ['stock_status' => 'available']) }}" 
                                   class="btn btn-sm {{ request('stock_status') == 'available' ? 'btn-success' : 'btn-outline-success' }}">
                                    Tersedia
                                </a>
                                <a href="{{ route('admin.products.index', ['stock_status' => 'low_stock']) }}" 
                                   class="btn btn-sm {{ request('stock_status') == 'low_stock' ? 'btn-warning' : 'btn-outline-warning' }}">
                                    Stok Menipis
                                </a>
                                <a href="{{ route('admin.products.index', ['stock_status' => 'out_of_stock']) }}" 
                                   class="btn btn-sm {{ request('stock_status') == 'out_of_stock' ? 'btn-danger' : 'btn-outline-danger' }}">
                                    Habis
                                </a>
                            </div>
                            
                            @if(request('search') || request('plant_type_id') || request('stock_status') || request('has_certificate') || request('price_min') || request('price_max'))
                                <span class="badge bg-info me-2 filter-badge">
                                    <i class="fas fa-filter"></i> Filter Aktif
                                </span>
                            @endif
                            <span class="badge bg-secondary filter-badge">
                                {{ $products->total() }} produk ditemukan
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Status Sertifikasi</th>
                                        <th>Harga/Unit</th>
                                        <th>Stok</th>
                                        <th>Min. Pembelian</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                                                         @forelse($products as $index => $product)
                                     <tr>
                                         <td>{{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->plantType->plant_type_name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $now = \Carbon\Carbon::now();
                                                $validFrom = $product->valid_from ? \Carbon\Carbon::parse($product->valid_from) : null;
                                                $validUntil = $product->valid_until ? \Carbon\Carbon::parse($product->valid_until) : null;
                                            @endphp
                                            @if($validFrom && $validUntil)
                                                @if($now->lt($validFrom))
                                                    <span class="badge bg-warning">Belum Berlaku</span>
                                                @elseif($now->between($validFrom, $validUntil))
                                                    <span class="badge bg-success">Berlaku</span>
                                                @elseif($now->gt($validUntil))
                                                    <span class="badge bg-danger">Tidak Berlaku</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Tidak Ada Sertifikat</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($product->price_per_unit, 0, ',', '.') }}</td>
                                        <td>{{ $product->stock }} {{ $product->unit }}</td>
                                        <td>{{ $product->minimum_purchase }} {{ $product->unit }}</td>
                                        <td>
                                            @if($product->stock > $product->minimum_stock)
                                                <span class="badge bg-success">Tersedia</span>
                                            @elseif($product->stock > 0)
                                                <span class="badge bg-warning">Stok Menipis</span>
                                            @else
                                                <span class="badge bg-danger">Habis</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.products.show', $product->product_id) }}" 
                                                   class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.products.edit', $product->product_id) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.products.history', $product->product_id) }}" 
                                                   class="btn btn-sm btn-secondary" title="History">
                                                    <i class="fas fa-history"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        onclick="deleteProduct({{ $product->product_id }})" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada produk</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Load More Button -->
                @if($products->hasMorePages())
                    <div class="text-center mt-4 load-more-container">
                        <button class="btn btn-outline-primary btn-lg load-more-btn" onclick="loadMore()" id="loadMoreBtn" type="button">
                            <i class="fas fa-plus"></i> Tampilkan Lebih Banyak
                        </button>
                        <div class="mt-2 load-more-info">
                            <small class="text-muted">
                                Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk
                            </small>
                        </div>
                        <div class="mt-2">
                            <div class="progress" style="height: 4px; max-width: 200px; margin: 0 auto;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ ($products->count() / $products->total()) * 100 }}%"
                                     aria-valuenow="{{ $products->count() }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="{{ $products->total() }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($products->total() > 0)
                    <div class="text-center mt-4">
                        <div class="alert alert-info">
                            <i class="fas fa-check-circle"></i> Semua produk telah ditampilkan
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus produk ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-submit form when filters change
document.addEventListener('DOMContentLoaded', function() {
    const filterSelects = ['plant_type_id', 'stock_status', 'has_certificate', 'sort_by'];
    
    filterSelects.forEach(function(selectId) {
        const select = document.getElementById(selectId);
        if (select) {
            select.addEventListener('change', function() {
                document.getElementById('searchForm').submit();
            });
        }
    });

    // Debounced search input
    const searchInput = document.getElementById('search');
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                document.getElementById('searchForm').submit();
            }, 500);
        });
    }
    
    // Reset page counter when filters change
    const filterForm = document.getElementById('searchForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function() {
            currentPage = 1;
            console.log('Filter submitted, resetting currentPage to 1');
        });
    }
    
    // Fix numbering after page load
    setTimeout(() => {
        const tableBody = document.querySelector('tbody');
        if (tableBody) {
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach((row, index) => {
                const firstCell = row.querySelector('td:first-child');
                if (firstCell) {
                    const expectedNumber = index + 1;
                    const currentNumber = parseInt(firstCell.textContent);
                    if (currentNumber !== expectedNumber) {
                        console.log(`Initial fix: Row ${index + 1}: ${currentNumber} -> ${expectedNumber}`);
                        firstCell.textContent = expectedNumber;
                    }
                }
            });
        }
    }, 100);
    
    // Fix initial numbering if there are existing rows
    const tableBody = document.querySelector('tbody');
    if (tableBody) {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const firstCell = row.querySelector('td:first-child');
            if (firstCell) {
                const expectedNumber = index + 1;
                const currentNumber = parseInt(firstCell.textContent);
                if (currentNumber !== expectedNumber) {
                    console.log(`Initial numbering fix: Row ${index + 1}: ${currentNumber} -> ${expectedNumber}`);
                    firstCell.textContent = expectedNumber;
                }
            }
        });
    }
    
    // Debug: Check if load more button exists
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        console.log('Load more button found:', loadMoreBtn);
        loadMoreBtn.addEventListener('click', function(e) {
            console.log('Load more button clicked');
            loadMore();
        });
    } else {
        console.log('Load more button not found');
    }
});

function deleteProduct(productId) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/ADMIN-BRMP-TAS/products/${productId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Clear all filters
function clearFilters() {
    window.location.href = '{{ route("admin.products.index") }}';
}

// Export data function
function exportData() {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('export', 'excel');
    window.location.href = currentUrl.toString();
}

// Load more functionality
let currentPage = 1;
let isLoading = false;

// Debug function to check if loadMore is available
console.log('LoadMore function available:', typeof loadMore);

function loadMore() {
    console.log('loadMore function called');
    console.log('isLoading:', isLoading);
    console.log('currentPage before:', currentPage);
    
    if (isLoading) {
        console.log('Already loading, returning');
        return;
    }
    
    isLoading = true;
    currentPage++;
    console.log('currentPage after:', currentPage);
    
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const originalText = loadMoreBtn.innerHTML;
    loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
    loadMoreBtn.disabled = true;
    
    // Get current URL and add page parameter
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('page', currentPage);
    console.log('Fetching URL:', currentUrl.toString());
    
    // Add AJAX header
    const headers = {
        'X-Requested-With': 'XMLHttpRequest'
    };
    
    // Fetch more products
    fetch(currentUrl.toString(), { headers: headers })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            console.log('HTML received, length:', html.length);
            console.log('HTML preview:', html.substring(0, 200));
            const currentTableBody = document.querySelector('tbody');
            
            if (currentTableBody && html.trim() !== '') {
                // Append new rows to current table
                currentTableBody.insertAdjacentHTML('beforeend', html);
                
                                 // Fix numbering for all rows to ensure sequential numbering
                 const allRows = currentTableBody.querySelectorAll('tr');
                 allRows.forEach((row, index) => {
                     const firstCell = row.querySelector('td:first-child');
                     if (firstCell) {
                         const expectedNumber = index + 1;
                         const currentNumber = parseInt(firstCell.textContent);
                         if (currentNumber !== expectedNumber) {
                             console.log(`Load more fix: Row ${index + 1}: ${currentNumber} -> ${expectedNumber}`);
                             firstCell.textContent = expectedNumber;
                         }
                     }
                 });
                
                // Update the counter
                const currentCount = currentTableBody.querySelectorAll('tr').length;
                const totalCount = {{ $products->total() }};
                
                // Update the info text
                const infoElement = document.querySelector('.load-more-info small');
                if (infoElement) {
                    infoElement.textContent = `Menampilkan ${currentCount} dari ${totalCount} produk`;
                }
                
                // Update progress bar
                const progressBar = document.querySelector('.progress-bar');
                if (progressBar) {
                    const progress = (currentCount / totalCount) * 100;
                    progressBar.style.width = progress + '%';
                    progressBar.setAttribute('aria-valuenow', currentCount);
                }
                
                // Check if we've loaded all products
                if (currentCount >= totalCount) {
                    loadMoreBtn.style.display = 'none';
                    const loadMoreContainer = document.querySelector('.load-more-container');
                    if (loadMoreContainer) {
                        loadMoreContainer.innerHTML = `
                            <div class="alert alert-info">
                                <i class="fas fa-check-circle"></i> Semua produk telah ditampilkan
                            </div>
                        `;
                    }
                }
            } else {
                // No more data to load
                loadMoreBtn.style.display = 'none';
                const loadMoreContainer = document.querySelector('.load-more-container');
                if (loadMoreContainer) {
                    loadMoreContainer.innerHTML = `
                        <div class="alert alert-info">
                            <i class="fas fa-check-circle"></i> Semua produk telah ditampilkan
                        </div>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Error loading more products:', error);
            loadMoreBtn.innerHTML = originalText;
            loadMoreBtn.disabled = false;
            // Show error message
            alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        })
        .finally(() => {
            isLoading = false;
            if (loadMoreBtn.style.display !== 'none') {
                loadMoreBtn.innerHTML = originalText;
                loadMoreBtn.disabled = false;
            }
        });
}
</script>
@endsection 