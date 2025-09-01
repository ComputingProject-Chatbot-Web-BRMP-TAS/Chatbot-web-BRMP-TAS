@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
    <div class="product-detail-modern-bg">
        <div class="product-detail-modern-container">
            <div class="product-detail-modern-left">
                <div class="product-detail-main-image-wrapper">
                    @if ($productHistory->image1)
                        <img src="{{ asset('storage/products/' . $productHistory->image1) }}"
                            alt="{{ $productHistory->product_name }}" class="product-detail-main-image" id="mainImage">
                    @else
                        <div class="product-detail-default-image" id="mainImage">
                            <i class="fas fa-seedling"></i>
                        </div>
                    @endif
                </div>
                <div class="product-detail-thumbs">
                    @if ($productHistory->image1)
                        <img src="{{ asset('storage/products/' . $productHistory->image1) }}" alt="thumb1"
                            class="selected"
                            onclick="changeImage(this, '{{ asset('storage/products/' . $productHistory->image1) }}')">
                    @else
                        <div class="product-detail-thumb-default selected" onclick="changeImage(this, 'default')">
                            <i class="fas fa-seedling"></i>
                        </div>
                    @endif
                    @if ($productHistory->image2)
                        <img src="{{ asset('storage/products/' . $productHistory->image2) }}" alt="thumb2"
                            onclick="changeImage(this, '{{ asset('storage/products/' . $productHistory->image2) }}')">
                    @endif
                    @if ($productHistory->image_certificate)
                        <img src="{{ asset('storage/certificates/' . $productHistory->image_certificate) }}"
                            alt="certificate"
                            onclick="changeImage(this, '{{ asset('storage/certificates/' . $productHistory->image_certificate) }}')">
                    @endif
                </div>
            </div>
            <div class="product-detail-modern-center">
                <div class="product-detail-title">{{ $productHistory->product_name }}</div>
                <div class="product-detail-price">Rp{{ number_format($productHistory->price_per_unit, 0, ',', '.') }} /
                    {{ $productHistory->unit }}</div>
                <div class="product-detail-desc">{{ $productHistory->description }}</div>

                <!-- Informasi Sertifikat -->
                @if ($productHistory->certificate_number)
                    <div class="certificate-info">
                        <h4 style="color: #16a34a; margin-bottom: 8px;">
                            <i class="fas fa-certificate" style="margin-right: 6px;"></i>
                            Informasi Sertifikat
                        </h4>
                        <div
                            style="background: #f8f9fa; padding: 16px; border-radius: 8px; border-left: 4px solid #16a34a;">
                            <div style="margin-bottom: 8px;">
                                <strong>Nomor Sertifikat:</strong> {{ $productHistory->certificate_number }}
                            </div>
                            <div style="margin-bottom: 8px;">
                                <strong>Kelas:</strong> {{ $productHistory->certificate_class }}
                            </div>
                            <div style="margin-bottom: 8px;">
                                <strong>Berlaku dari:</strong>
                                {{ $productHistory->valid_from ? $productHistory->valid_from->format('d M Y') : '-' }}
                            </div>
                            <div>
                                <strong>Berlaku sampai:</strong>
                                {{ $productHistory->valid_until ? $productHistory->valid_until->format('d M Y') : '-' }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Informasi Record -->
                <div class="record-info" style="margin-top: 20px;">
                    <div
                        style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 12px; color: #856404;">
                        <i class="fas fa-history" style="margin-right: 6px;"></i>
                        <strong>Foto produk dari transaksi sebelumnya</strong><br>
                        <small>Direkam pada:
                            {{ $productHistory->recorded_at ? $productHistory->recorded_at->format('d M Y H:i') : '-' }}</small>
                    </div>
                </div>
            </div>
            <div class="product-detail-modern-right">
                @if (session('error'))
                    <div
                        style="background:#ffebee;border:1px solid #f44336;border-radius:8px;padding:12px;margin-bottom:16px;color:#d32f2f;font-size:0.9rem;">
                        <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div
                        style="background:#e8f5e9;border:1px solid #4caf50;border-radius:8px;padding:12px;margin-bottom:16px;color:#2e7d32;font-size:0.9rem;">
                        <i class="fas fa-check-circle" style="margin-right:6px;"></i>
                        {{ session('success') }}
                    </div>
                @endif
                <div class="product-detail-card">
                    <div class="product-detail-card-title">Status Produk Saat Ini</div>

                    @if ($isProductAvailable)
                        <div style="text-align: center; padding: 20px; color: #16a34a; font-weight: 500;">
                            <i class="fas fa-check-circle" style="font-size: 24px; margin-bottom: 8px; color: #16a34a;"></i>
                            <div>Produk masih tersedia</div>
                            <div style="font-size: 0.9rem; margin-top: 4px; color: #666;">
                                Stok: {{ $currentProduct->stock - $currentProduct->minimum_stock }}
                                {{ $currentProduct->unit }}
                            </div>
                            <button onclick="location.href='{{ route('produk.detail', $currentProduct->product_id) }}'"
                                class="btn-green w-100 mt-3">
                                Lihat Detail Produk Terkini
                            </button>
                        </div>
                    @else
                        <div style="text-align: center; padding: 20px; color: #d32f2f; font-weight: 500;">
                            <i class="fas fa-exclamation-triangle"
                                style="font-size: 24px; margin-bottom: 8px; color: #d32f2f;"></i>
                            <div>Produk tidak tersedia</div>
                            <div style="font-size: 0.9rem; margin-top: 4px; color: #666;">
                                @if ($currentProduct)
                                    Stok: {{ $currentProduct->stock - $currentProduct->minimum_stock }}
                                    {{ $currentProduct->unit }}
                                @else
                                    Produk telah dihapus
                                @endif
                            </div>
                            @if ($currentProduct)
                                <button onclick="location.href='{{ route('produk.detail', $currentProduct->product_id) }}'"
                                    class="btn-outline w-100 mt-3">
                                    Lihat Detail Produk Terkini
                                </button>
                            @endif
                        </div>
                    @endif

                    <!-- Tombol Kembali -->
                    <div>
                        <button onclick="location.href='{{ url()->previous() }}'" class="btn-outline w-100">
                            <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div class="modal fade gallery-modal" id="imageGalleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-body p-0">
                    <div id="imageGalleryCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            @if ($productHistory->image1)
                                <div class="carousel-item active">
                                    <img src="{{ asset('storage/products/' . $productHistory->image1) }}"
                                        class="d-block w-100" alt="{{ $productHistory->product_name }}">
                                </div>
                            @endif
                            @if ($productHistory->image2)
                                <div class="carousel-item">
                                    <img src="{{ asset('storage/products/' . $productHistory->image2) }}"
                                        class="d-block w-100" alt="{{ $productHistory->product_name }}">
                                </div>
                            @endif
                            @if ($productHistory->image_certificate)
                                <div class="carousel-item">
                                    <img src="{{ asset('storage/certificates/' . $productHistory->image_certificate) }}"
                                        class="d-block w-100" alt="{{ $productHistory->product_name }}">
                                </div>
                            @endif
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#imageGalleryCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#imageGalleryCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .product-detail-modern-bg {
            min-height: 100vh;
            background: #f8f9fa;
            padding-top: 100px;
            /* dinaikkan agar tidak tenggelam appbar */
            padding-bottom: 40px;
        }

        .product-detail-modern-container {
            display: flex;
            gap: 32px;
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            padding: 40px 32px;
        }

        .product-detail-modern-left {
            flex: 1.1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .product-detail-main-image {
            width: 340px;
            height: 340px;
            object-fit: contain;
            border-radius: 16px;
            background: #f3f3f3;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .product-detail-main-image-wrapper {
            width: 340px;
            height: 340px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f3f3f3;
            border-radius: 16px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .product-detail-default-image {
            width: 340px;
            height: 340px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f0f0f0;
            border-radius: 16px;
            color: #999;
        }

        .product-detail-default-image i {
            font-size: 80px;
        }

        .product-detail-thumbs {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
        }

        .product-detail-thumbs img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            cursor: pointer;
        }

        .product-detail-thumbs img.selected {
            border: 2px solid #4CAF50;
        }

        .product-detail-thumb-default {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f0f0f0;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            cursor: pointer;
            color: #999;
        }

        .product-detail-thumb-default.selected {
            border: 2px solid #4CAF50;
        }

        .product-detail-thumb-default i {
            font-size: 20px;
        }

        .product-detail-modern-center {
            flex: 1.5;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-top: 10px;
        }

        .product-detail-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .product-detail-price {
            color: #388E3C;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .product-detail-stock {
            color: #888;
            font-size: 1rem;
            margin-bottom: 18px;
        }

        .product-detail-info-list {
            margin-bottom: 18px;
        }

        .product-detail-info-list .label {
            color: #888;
            font-weight: 500;
            margin-right: 8px;
        }

        .product-detail-info-list .value {
            color: #222;
            font-weight: 500;
        }

        .product-detail-desc {
            margin-top: 18px;
            color: #444;
            font-size: 1.1rem;
        }

        .product-detail-modern-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .product-detail-card {
            width: 320px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            padding: 24px 20px 18px 20px;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            margin-top: 0;
        }

        .product-detail-card-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 16px;
        }

        .btn-outline {
            border-radius: 8px;
            border: 2px solid #3C9A40;
            background: #fff;
            color: #3C9A40;
            font-size: 16px;
            font-weight: 700;
            padding: 10px 0;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            transform: translateY(-2px);
        }

        .certificate-info {
            margin-top: 20px;
            padding: 16px;
            background: #f8f9fa;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        .record-info {
            margin-top: 20px;
        }

        @media (max-width: 1100px) {
            .product-detail-modern-container {
                flex-direction: column;
                padding: 18px 6px;
                gap: 18px;
            }

            .product-detail-modern-right {
                align-items: stretch;
            }

            .product-detail-card {
                width: 100%;
                margin-top: 18px;
            }
        }

        .product-detail-main-image,
        .product-detail-default-image {
            cursor: zoom-in;
        }

        /* Gallery modal visuals */
        .gallery-modal .modal-body img {
            max-height: 80vh;
            object-fit: contain;
            background: #000;
        }

        .gallery-modal .modal-content {
            background: rgba(0, 0, 0, 0.06);
        }
    </style>
@endpush

@push('scripts')
    <script>
        function changeImage(thumbElement, imageSrc) {
            const mainImageContainer = document.getElementById('mainImage');

            if (imageSrc === 'default') {
                // Show default image
                mainImageContainer.innerHTML = '<i class="fas fa-seedling"></i>';
                mainImageContainer.className = 'product-detail-default-image';
            } else {
                // Show actual image
                mainImageContainer.src = imageSrc;
                mainImageContainer.className = 'product-detail-main-image';
            }

            // Update selected thumbnail
            document.querySelectorAll('.product-detail-thumbs img, .product-detail-thumbs .product-detail-thumb-default')
                .forEach(thumb => {
                    thumb.classList.remove('selected');
                });
            thumbElement.classList.add('selected');
        }
        // Image gallery modal logic
        (function() {
            const galleryImages = [
                @if ($productHistory->image1)
                    '{{ asset('storage/products/' . $productHistory->image1) }}',
                @endif
                @if ($productHistory->image2)
                    '{{ asset('storage/products/' . $productHistory->image2) }}',
                @endif
                @if ($productHistory->image_certificate)
                    '{{ asset('storage/certificates/' . $productHistory->image_certificate) }}',
                @endif
            ];

            if (galleryImages.length === 0) return;

            const mainImageEl = document.getElementById('mainImage');
            const modalEl = document.getElementById('imageGalleryModal');
            const carouselEl = document.getElementById('imageGalleryCarousel');
            let carouselInstance;

            function ensureCarousel() {
                if (!carouselInstance) {
                    carouselInstance = new bootstrap.Carousel(carouselEl, {
                        interval: false,
                        ride: false,
                        keyboard: true
                    });
                }
            }

            function openGalleryAt(index) {
                const items = carouselEl.querySelectorAll('.carousel-item');
                items.forEach((item, i) => {
                    if (i === index) item.classList.add('active');
                    else item.classList.remove('active');
                });
                ensureCarousel();
                const bsModal = new bootstrap.Modal(modalEl);
                bsModal.show();
            }

            if (mainImageEl && mainImageEl.tagName === 'IMG') {
                mainImageEl.addEventListener('click', function() {
                    const currentSrc = this.getAttribute('src');
                    let idx = galleryImages.findIndex(u => u === currentSrc);
                    if (idx < 0) idx = 0;
                    openGalleryAt(idx);
                });
            }
        })();
    </script>
@endpush

@section('after_content')
    @include('customer.partials.mitra_footer')
@endsection
