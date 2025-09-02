@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @php
        $latestProducts = App\Models\Product::orderBy('product_id', 'desc')->take(5)->pluck('product_id')->toArray();
    @endphp
    <style>
        .kategori-banner {
            margin: 60px 0 20px 0;
            background: #4CAF50;
            color: white;
            text-align: center;
            padding: 40px 0;
        }


        .content-wrapper {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            gap: 20px;
            flex-direction: row;
            justify-content: center;
        }

        .main-content {
            background: white;
            padding: 20px;
            margin: 0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #4CAF50;
        }

        .filter-sidebar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            height: fit-content;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
            flex-wrap: wrap;
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

        @media (max-width: 1023px) {

            .content-wrapper {
                padding: 10px;
            }

            .main-content {
                padding: 0 0;
                background: none;
                border: none;
                box-shadow: none;
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

                        <form method="GET" action="{{ url()->current() }}" id="filterForm">
                            <div class="filter-section">
                                <div class="filter-section-title">Kategori</div>
                                <div class="filter-option">
                                    <input type="checkbox" name="kategori[]" value="pemanis" id="pemanis"
                                        {{ request()->has('kategori') && in_array('pemanis', (array) request('kategori')) ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    <label for="pemanis">Tanaman Pemanis</label>
                                </div>
                                <div class="filter-option">
                                    <input type="checkbox" name="kategori[]" value="serat" id="serat"
                                        {{ request()->has('kategori') && in_array('serat', (array) request('kategori')) ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    <label for="serat">Tanaman Serat</label>
                                </div>
                                <div class="filter-option">
                                    <input type="checkbox" name="kategori[]" value="tembakau" id="tembakau"
                                        {{ request()->has('kategori') && in_array('tembakau', (array) request('kategori')) ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    <label for="tembakau">Tanaman Tembakau</label>
                                </div>
                                <div class="filter-option">
                                    <input type="checkbox" name="kategori[]" value="minyak" id="minyak"
                                        {{ request()->has('kategori') && in_array('minyak', (array) request('kategori')) ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    <label for="minyak">Tanaman Minyak Industri</label>
                                </div>
                            </div>
                        </form>
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

                        <div class="product-grid" id="productsGrid">
                            @forelse($products as $product)
                                @include('customer.partials.product-card', ['product' => $product])
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
                const priceA = parseInt(a.getAttribute('data-price'));
                const priceB = parseInt(b.getAttribute('data-price'));

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
