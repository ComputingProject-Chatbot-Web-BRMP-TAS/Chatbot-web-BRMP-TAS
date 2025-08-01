{{-- Debug: Show products count --}}
{{-- Products count: {{ $products->count() }} --}}
@forelse($products as $index => $product)
<tr>
    <td>{{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}</td>
    {{-- Debug: {{ $products->currentPage() }} - {{ $products->perPage() }} - {{ $index }} --}}
    <td>
        @if($product->image1)
            <img src="{{ asset('storage/' . $product->image1) }}" 
                 alt="{{ $product->product_name }}" 
                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
        @else
            <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-image text-muted"></i>
            </div>
        @endif
    </td>
    <td>{{ $product->product_name }}</td>
    <td>{{ $product->plantType->plant_type_name ?? 'N/A' }}</td>
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