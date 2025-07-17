@php
    $latestProducts = App\Models\Product::orderBy('produk_id','desc')->take(5)->pluck('produk_id')->toArray();
@endphp
<a href="{{ route('produk.detail', $produk->produk_id) }}" style="text-decoration:none;color:inherit;">
    <div class="product-card" style="position:relative;">
        @if(in_array($produk->produk_id, $latestProducts))
            <div class="product-badge">Baru</div>
        @endif
        @if($produk->gambar)
            <img src="{{ asset('images/' . $produk->gambar) }}" alt="{{ $produk->nama }}" style="width:100%;height:140px;object-fit:cover;border-radius:12px 12px 0 0;">
        @else
            <div style="width:100%;height:140px;background:#f0f0f0;border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:center;color:#999;">
                <i class="fas fa-seedling" style="font-size:32px;"></i>
            </div>
        @endif
        <div class="info" style="padding:12px 16px 0 16px;">
            <div class="title" style="font-weight:500;font-size:15px;margin-bottom:6px;line-height:1.3;">{{ $produk->nama }}</div>
            <div class="price" style="color:#388E3C;font-weight:bold;font-size:16px;margin-bottom:4px;">Rp{{ number_format($produk->harga,0,',','.') }}</div>
            <div class="desc" style="font-size:12px;color:#757575;height:32px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $produk->deskripsi }}</div>
        </div>
    </div>
</a> 