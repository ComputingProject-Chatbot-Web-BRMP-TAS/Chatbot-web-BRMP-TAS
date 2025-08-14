@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
<div class="product-detail-modern-bg">
    <div class="product-detail-modern-container">
    <div class="product-detail-modern-left">
            <div class="product-detail-main-image-wrapper">
                @if($product->image1)
                    <img src="{{ asset('storage/' . $product->image1) }}" alt="{{ $product->product_name }}" class="product-detail-main-image" id="mainImage">
                @else
                    <div class="product-detail-default-image" id="mainImage">
                        <i class="fas fa-seedling"></i>
                    </div>
                @endif
            </div>
            <div class="product-detail-thumbs">
                @if($product->image1)
                    <img src="{{ asset('storage/' . $product->image1) }}" alt="thumb1" class="selected" onclick="changeImage(this, '{{ asset('storage/' . $product->image1) }}')">
                @else
                    <div class="product-detail-thumb-default selected" onclick="changeImage(this, 'default')">
                        <i class="fas fa-seedling"></i>
                    </div>
                @endif
                @if($product->image2)
                    <img src="{{ asset('storage/' . $product->image2) }}" alt="thumb2" onclick="changeImage(this, '{{ asset('storage/' . $product->image2) }}')">
                @endif
                @if($product->image_certificate)
                    <img src="{{ asset('storage/' . $product->image_certificate) }}" alt="certificate" onclick="changeImage(this, '{{ asset('storage/' . $product->image_certificate) }}')">
                @endif
            </div>
        </div>
        <div class="product-detail-modern-center">
            <div class="product-detail-title">{{ $product->product_name }}</div>
            <div class="product-detail-price">Rp{{ number_format($product->price_per_unit, 0, ',', '.') }} / {{ $product->unit }}</div>
            @php
                $availableStock = $product->stock - $product->minimum_stock;
                $isOutOfStock = $availableStock <= 0;
            @endphp
            <div class="product-detail-stock {{ $isOutOfStock ? 'text-danger' : '' }}">
                Stok: {{ $availableStock }} {{ $product->unit }}
                @if($isOutOfStock)
                    <span style="color: #d32f2f; font-weight: 500;">(Stok Habis)</span>
                @endif
            </div>
            <div class="product-detail-desc">{{ $product->description }}</div>
            
            <!-- Informasi Sertifikat -->
            @if($product->certificate_number)
            <div class="certificate-info" style="margin-top: 20px;">
                <h4 style="color: #16a34a; margin-bottom: 8px;">
                    <i class="fas fa-certificate" style="margin-right: 6px;"></i>
                    Informasi Sertifikat
                </h4>
                <div style="background: #f8f9fa; padding: 16px; border-radius: 8px; border-left: 4px solid #16a34a;">
                    <div style="margin-bottom: 8px;">
                        <strong>Nomor Sertifikat:</strong> {{ $product->certificate_number }}
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Kelas:</strong> {{ $product->certificate_class }}
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Berlaku dari:</strong> {{ $product->valid_from ? \Carbon\Carbon::parse($product->valid_from)->format('d M Y') : '-' }}
                    </div>
                    <div>
                        <strong>Berlaku sampai:</strong> {{ $product->valid_until ? \Carbon\Carbon::parse($product->valid_until)->format('d M Y') : '-' }}
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="product-detail-modern-right">
            @if(session('error'))
                <div style="background:#ffebee;border:1px solid #f44336;border-radius:8px;padding:12px;margin-bottom:16px;color:#d32f2f;font-size:0.9rem;">
                    <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div style="background:#e8f5e9;border:1px solid #4caf50;border-radius:8px;padding:12px;margin-bottom:16px;color:#2e7d32;font-size:0.9rem;">
                    <i class="fas fa-check-circle" style="margin-right:6px;"></i>
                    {{ session('success') }}
                </div>
            @endif
            <div class="product-detail-card">
                <div class="product-detail-card-title">Atur jumlah dan catatan</div>
                @if($isOutOfStock)
                    <div style="text-align: center; padding: 20px; color: #d32f2f; font-weight: 500;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 24px; margin-bottom: 8px;"></i>
                        <div>Produk tidak tersedia</div>
                        <div style="font-size: 0.9rem; margin-top: 4px; color: #666;">Stok telah habis</div>
                    </div>
                @else
                    <form method="POST" action="{{ Auth::check() ? route('cart.add', $product->product_id) : route('login') }}" id="addToCartForm">
                        @csrf
                        <div class="product-detail-card-qty">
                            <input type="text" id="qtyInput" name="quantity" value="" placeholder="0" min="{{ $product->minimum_purchase }}" max="{{ $availableStock }}" style="width:60px;text-align:center;background:#fff;">
                            <span style="margin-left:8px;">{{ $product->unit }}</span>
                            <span style="margin-left:8px;color:#d32f2f;font-size:0.9rem;">*Minimal Pembelian {{ number_format($product->minimum_purchase, 0, ',', '') }}{{ $product->unit }}</span>
                        </div>
                        <div id="stockWarning" style="color:#d32f2f;font-size:0.98rem;display:none;margin-bottom:8px;">
                            <i class="fas fa-exclamation-triangle" style="margin-right:4px;"></i>
                            Stok tidak mencukupi
                        </div>
                        <div id="minPurchaseWarning" style="color:#d32f2f;font-size:0.98rem;display:none;margin-bottom:8px;">
                            <i class="fas fa-exclamation-triangle" style="margin-right:4px;"></i>
                            Minimal pembelian tidak terpenuhi
                        </div>
                        <div class="product-detail-card-subtotal">
                            Subtotal
                            <span id="subtotal">Rp0</span>
                        </div>
                        <button class="btn-green w-100" style="margin-bottom:10px;opacity:0.6;cursor:not-allowed;background:#ccc !important;color:#666 !important;" type="submit" id="addToCartBtn" disabled>+ Keranjang</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Gallery Modal -->
<div class="modal fade gallery-modal" id="imageGalleryModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content bg-transparent border-0 shadow-none">
			<button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-0">
				<div id="imageGalleryCarousel" class="carousel slide" data-bs-ride="false">
					<div class="carousel-inner">
						@if($product->image1)
							<div class="carousel-item active">
								<img src="{{ asset('storage/' . $product->image1) }}" class="d-block w-100" alt="{{ $product->product_name }}">
							</div>
						@endif
						@if($product->image2)
							<div class="carousel-item">
								<img src="{{ asset('storage/' . $product->image2) }}" class="d-block w-100" alt="{{ $product->product_name }}">
							</div>
						@endif
						@if($product->image_certificate)
							<div class="carousel-item">
								<img src="{{ asset('storage/' . $product->image_certificate) }}" class="d-block w-100" alt="{{ $product->product_name }}">
							</div>
						@endif
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#imageGalleryCarousel" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#imageGalleryCarousel" data-bs-slide="next">
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
    padding-top: 100px; /* dinaikkan agar tidak tenggelam appbar */
    padding-bottom: 40px;
}
.product-detail-modern-container {
    display: flex;
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
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
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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
.product-detail-main-image,
.product-detail-default-image {
    cursor: zoom-in;
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
.certificate-info {
    margin-top: 20px;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 12px;
    border: 1px solid #e9ecef;
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
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
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
.product-detail-card-qty {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}
.qty-btn {
    background: #f3f3f3;
    border: none;
    border-radius: 6px;
    width: 32px;
    height: 32px;
    font-size: 1.2rem;
    color: #388E3C;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}
.qty-btn:hover {
    background: #E8F5E9;
}
.product-detail-card-stock {
    color: #888;
    font-size: 0.98rem;
    margin-left: 10px;
}
.product-detail-card-subtotal {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 18px;
    margin-top: 8px;
}
.btn-green {
    background: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px 32px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-green:hover {
    background: #388E3C;
}
.btn-outline {
    background: #fff;
    color: #388E3C;
    border: 2px solid #4CAF50;
    border-radius: 8px;
    padding: 12px 32px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
}
.btn-outline:hover {
    background: #E8F5E9;
    color: #222;
}
.product-detail-card-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 16px;
    font-size: 1.05rem;
    color: #888;
}
.icon-action {
    display: flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    transition: color 0.2s;
}
.icon-action:hover {
    color: #388E3C;
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
/* Gallery modal visuals */
.gallery-modal .modal-body img {
    max-height: 80vh;
    object-fit: contain;
    background: #000;
}
.gallery-modal .modal-content { background: rgba(0,0,0,0.06); }
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
    document.querySelectorAll('.product-detail-thumbs img, .product-detail-thumbs .product-detail-thumb-default').forEach(thumb => {
        thumb.classList.remove('selected');
    });
    thumbElement.classList.add('selected');
}
@if(!$isOutOfStock)
function updateSubtotal() {
    let qty = parseFloat(document.getElementById('qtyInput').value.replace(',', '.')) || 0;
    let harga = {{ $product->price_per_unit }};
    let availableStock = {{ $availableStock }};
    let minimumPurchase = {{ $product->minimum_purchase }};
    
    // Reset semua warning
    document.getElementById('stockWarning').style.display = 'none';
    document.getElementById('minPurchaseWarning').style.display = 'none';
    
    // Jika quantity kosong atau 0
    if (qty === 0 || document.getElementById('qtyInput').value.trim() === '') {
        document.getElementById('subtotal').innerText = 'Rp0';
        const addToCartBtn = document.getElementById('addToCartBtn');
        addToCartBtn.disabled = true;
        addToCartBtn.style.opacity = '0.6';
        addToCartBtn.style.cursor = 'not-allowed';
        return;
    }
    
    // Validasi minimal pembelian
    if (qty < minimumPurchase) {
        document.getElementById('minPurchaseWarning').style.display = 'block';
        document.getElementById('minPurchaseWarning').innerText = 'Minimal pembelian: ' + {{ number_format($product->minimum_purchase, 0, ',', '') }} + ' {{ $product->unit }}';
        // Jangan otomatis set ke minimal pembelian, biarkan user input manual
        // qty = minimumPurchase;
        // document.getElementById('qtyInput').value = qty;
    }
    
    // Validasi stok
    if (qty > availableStock) {
        document.getElementById('stockWarning').style.display = 'block';
        document.getElementById('stockWarning').innerText = 'Stok tidak mencukupi. Maksimal: ' + availableStock + ' {{ $product->unit }}';
        qty = availableStock;
        document.getElementById('qtyInput').value = qty;
    }
    
    document.getElementById('subtotal').innerText = 'Rp' + (harga * qty).toLocaleString('id-ID');
    
    // Disable/enable tombol berdasarkan validasi
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (qty < minimumPurchase || qty > availableStock || qty === 0) {
        addToCartBtn.disabled = true;
        addToCartBtn.style.opacity = '0.6';
        addToCartBtn.style.cursor = 'not-allowed';
        addToCartBtn.style.background = '#ccc';
        addToCartBtn.style.color = '#666';
    } else {
        addToCartBtn.disabled = false;
        addToCartBtn.style.opacity = '1';
        addToCartBtn.style.cursor = 'pointer';
        addToCartBtn.style.background = '#388e3c';
        addToCartBtn.style.color = '#fff';
    }
}

const unitProduk = @json($product->unit);
const qtyInput = document.getElementById('qtyInput');
const minimumPurchase = {{ $product->minimum_purchase }};
const availableStock = {{ $availableStock }};

if (["Mata", "Tanaman", "Rizome"].includes(unitProduk)) {
    qtyInput.setAttribute('type', 'number');
    qtyInput.setAttribute('step', '1');
    qtyInput.setAttribute('min', minimumPurchase);
    qtyInput.setAttribute('max', availableStock);
    qtyInput.addEventListener('input', function(e) {
        let val = this.value;
        if (val !== "") {
            val = parseInt(val, 10);
            if (isNaN(val)) {
                this.value = "";
            } else if (val > availableStock) {
                val = availableStock;
                this.value = val;
            }
        }
        updateSubtotal();
    });
    qtyInput.addEventListener('blur', function(e) {
        if (this.value === "" || isNaN(this.value)) {
            this.value = "";
            updateSubtotal();
        }
    });
} else {
    qtyInput.setAttribute('min', minimumPurchase);
    qtyInput.setAttribute('max', availableStock);
    qtyInput.addEventListener('input', function(e) {
        updateSubtotal();
    });
    qtyInput.addEventListener('blur', function(e) {
        let val = this.value.replace(',', '.');
        if (val === "" || isNaN(val)) {
            this.value = "";
        } else {
            val = parseFloat(val);
            if (val > availableStock) {
                val = availableStock;
                this.value = val;
            }
        }
        updateSubtotal();
    });
}

// Inisialisasi subtotal saat halaman dimuat
updateSubtotal();

// Validasi form submission
document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    let qty = parseFloat(document.getElementById('qtyInput').value.replace(',', '.')) || 0;
    let minimumPurchase = {{ $product->minimum_purchase }};
    let availableStock = {{ $availableStock }};
    
    if (qty === 0 || document.getElementById('qtyInput').value.trim() === '') {
        e.preventDefault();
        alert('Silakan masukkan jumlah yang ingin dibeli');
        return false;
    }
    
    if (qty < minimumPurchase) {
        e.preventDefault();
        alert('Minimal pembelian: ' + {{ number_format($product->minimum_purchase, 0, ',', '') }} + ' {{ $product->unit }}');
        return false;
    }
    
    if (qty > availableStock) {
        e.preventDefault();
        alert('Stok tidak mencukupi. Maksimal: ' + availableStock + ' {{ $product->unit }}');
        return false;
    }
});
@endif

// Image gallery modal logic
(function() {
	const galleryImages = [
		@if($product->image1) '{{ asset('storage/' . $product->image1) }}', @endif
		@if($product->image2) '{{ asset('storage/' . $product->image2) }}', @endif
		@if($product->image_certificate) '{{ asset('storage/' . $product->image_certificate) }}', @endif
	];

	if (galleryImages.length === 0) return;

	const mainImageEl = document.getElementById('mainImage');
	const modalEl = document.getElementById('imageGalleryModal');
	const carouselEl = document.getElementById('imageGalleryCarousel');
	let carouselInstance;

	function ensureCarousel() {
		if (!carouselInstance) {
			carouselInstance = new bootstrap.Carousel(carouselEl, { interval: false, ride: false, keyboard: true });
		}
	}

	function openGalleryAt(index) {
		const items = carouselEl.querySelectorAll('.carousel-item');
		items.forEach((item, i) => {
			if (i === index) item.classList.add('active'); else item.classList.remove('active');
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