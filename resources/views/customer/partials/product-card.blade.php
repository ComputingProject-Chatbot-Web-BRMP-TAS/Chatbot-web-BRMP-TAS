@php
    $latestProducts = App\Models\Product::orderBy('product_id', 'desc')->take(5)->pluck('product_id')->toArray();
    $availableStock = $product->stock - $product->minimum_stock;
    $isOutOfStock = $availableStock <= 0;
@endphp

<div class="product-card" data-price="{{ $product->price_per_unit }}" data-stock="{{ $availableStock }}"
    data-name="{{ $product->product_name }}"
    style="position:relative;{{ $isOutOfStock ? 'opacity: 0.7; filter: grayscale(30%);' : '' }}; cursor: pointer;"
    onclick="window.location.href='{{ route('produk.detail', $product->product_id) }}'"
    onkeydown="if(event.key === 'Enter' || event.key === ' ') { window.location.href='{{ route('produk.detail', $product->product_id) }}' }"
    tabindex="0" role="button" aria-label="Lihat detail {{ $product->product_name }}">
    @if (in_array($product->product_id, $latestProducts))
        <div class="product-badge">Baru</div>
    @endif
    @if ($isOutOfStock)
        <div
            style="position:absolute;top:8px;right:8px;background:#d32f2f;color:white;padding:4px 8px;border-radius:6px;font-size:11px;font-weight:500;z-index:10;box-shadow:0 2px 4px rgba(211,47,47,0.3);">
            <i class="fas fa-times-circle" style="margin-right:2px;"></i>Stok Habis
        </div>
    @endif
    @if ($product->image1)
        <img src="{{ asset('storage/products/' . $product->image1) }}" alt="{{ $product->product_name }}">
    @else
        <div
            style="width:100%;height:120px;background:#f0f0f0;border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:center;color:#999;">
            <i class="fas fa-seedling" style="font-size:32px;"></i>
        </div>
    @endif
    <div class="info">
        <div>
            <div class="price">
                Rp{{ number_format($product->price_per_unit ?? 0, 0, ',', '.') }} / {{ $product->unit ?? 'Kg' }}</div>
            <div class="title">
                {{ $product->product_name ?? 'Nama Produk Tidak Tersedia' }}</div>
            <div class="desc"> {{ $product->description ?? 'Deskripsi tidak tersedia' }}</div>
        </div>
        <div class="stock" style="
        color: {{ $isOutOfStock ? '#d32f2f' : '#888' }};">
            Stok: {{ $availableStock }} {{ $product->unit ?? 'Kg' }}
            @if ($isOutOfStock)
                <span style="font-weight:500;">(Habis)</span>
            @endif
        </div>
    </div>
</div>
