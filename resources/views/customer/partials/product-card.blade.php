@php
    $latestProducts = App\Models\Product::orderBy('product_id','desc')->take(5)->pluck('product_id')->toArray();
    $availableStock = $product->stock - $product->minimum_stock;
    $isOutOfStock = $availableStock <= 0;
@endphp
<div class="product-card" 
     data-price="{{ $product->price_per_unit }}" 
     data-stock="{{ $availableStock }}" 
     data-name="{{ $product->product_name }}"
     style="position:relative;{{ $isOutOfStock ? 'opacity: 0.7; filter: grayscale(30%);' : '' }}; cursor: pointer;"
     onclick="window.location.href='{{ route('produk.detail', $product->product_id) }}'"
     onkeydown="if(event.key === 'Enter' || event.key === ' ') { window.location.href='{{ route('produk.detail', $product->product_id) }}' }"
     tabindex="0"
     role="button"
     aria-label="Lihat detail {{ $product->product_name }}">
    @if(in_array($product->product_id, $latestProducts))
        <div class="product-badge">Baru</div>
    @endif
    @if($isOutOfStock)
        <div style="position:absolute;top:8px;right:8px;background:#d32f2f;color:white;padding:4px 8px;border-radius:6px;font-size:11px;font-weight:500;z-index:10;box-shadow:0 2px 4px rgba(211,47,47,0.3);">
            <i class="fas fa-times-circle" style="margin-right:2px;"></i>Stok Habis
        </div>
    @endif
    @if($product->image1)
        <img src="{{ asset('storage/' . $product->image1) }}" alt="{{ $product->product_name }}" style="width:100%;height:120px;object-fit:cover;border-radius:12px 12px 0 0;">
    @else
        <div style="width:100%;height:120px;background:#f0f0f0;border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:center;color:#999;">
            <i class="fas fa-seedling" style="font-size:32px;"></i>
        </div>
    @endif
    <div class="info" style="padding:12px 16px 16px 16px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
        <div>
            <div class="title" style="font-weight:500;font-size:15px;margin-bottom:6px;line-height:1.3;">{{ $product->product_name ?? 'Nama Produk Tidak Tersedia' }}</div>
            <div class="price" style="color:#388E3C;font-weight:bold;font-size:16px;margin-bottom:4px;">Rp{{ number_format($product->price_per_unit ?? 0,0,',','.') }} / {{ $product->unit ?? 'Kg' }}</div>
            <div class="desc" style="font-size:12px;color:#757575;height:32px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;text-overflow:ellipsis;">{{ $product->description ?? 'Deskripsi tidak tersedia' }}</div>
        </div>
        <div class="stock" style="font-size:12px;color:{{ $isOutOfStock ? '#d32f2f' : '#888' }};margin-top:8px;">
            Stok: {{ $availableStock }} {{ $product->unit ?? 'Kg' }}
            @if($isOutOfStock)
                <span style="font-weight:500;">(Habis)</span>
            @endif
        </div>
    </div>
</div> 