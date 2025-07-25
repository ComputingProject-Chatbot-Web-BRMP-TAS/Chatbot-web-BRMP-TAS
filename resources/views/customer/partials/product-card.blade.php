@php
    $latestProducts = App\Models\Product::orderBy('product_id','desc')->take(5)->pluck('product_id')->toArray();
@endphp
<a href="{{ route('produk.detail', $product->product_id) }}" style="text-decoration:none;color:inherit;">
    <div class="product-card" style="position:relative;">
        @if(in_array($product->product_id, $latestProducts))
            <div class="product-badge">Baru</div>
        @endif
        @if($product->image1)
            <img src="{{ asset('images/' . $product->image1) }}" alt="{{ $product->product_name }}" style="width:100%;height:140px;object-fit:cover;border-radius:12px 12px 0 0;">
        @else
            <div style="width:100%;height:140px;background:#f0f0f0;border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:center;color:#999;">
                <i class="fas fa-seedling" style="font-size:32px;"></i>
            </div>
        @endif
        <div class="info" style="padding:12px 16px 0 16px;">
            <div class="title" style="font-weight:500;font-size:15px;margin-bottom:6px;line-height:1.3;">{{ $product->product_name }}</div>
            <div class="price" style="color:#388E3C;font-weight:bold;font-size:16px;margin-bottom:4px;">Rp{{ number_format($product->price_per_unit,0,',','.') }} / {{ $product->unit }}</div>
            <div class="desc" style="font-size:12px;color:#757575;height:32px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $product->description }}</div>
            <div class="stock" style="font-size:12px;color:#888;margin-top:4px;">Stok: {{ $product->stock }} {{ $product->unit }}</div>
        </div>
    </div>
</a> 