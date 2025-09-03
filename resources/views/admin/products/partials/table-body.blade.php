{{-- Debug: Show products count --}}
{{-- Products count: {{ $products->count() }} --}}
@forelse($products as $index => $product)
    <tr>
        <td>{{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}</td>
        {{-- Debug: {{ $products->currentPage() }} - {{ $products->perPage() }} - {{ $index }} --}}
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->plantType->plant_type_name ?? 'N/A' }}</td>
        <td>
            @php
                $now = \Carbon\Carbon::now();
                $validFrom = $product->valid_from ? \Carbon\Carbon::parse($product->valid_from) : null;
                $validUntil = $product->valid_until ? \Carbon\Carbon::parse($product->valid_until) : null;
            @endphp
            @if ($validFrom && $validUntil)
                @if ($now->lt($validFrom))
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
            @if ($product->stock > $product->minimum_stock)
                <span class="badge bg-success">Tersedia</span>
            @elseif($product->stock > 0)
                <span class="badge bg-warning">Stok Menipis</span>
            @else
                <span class="badge bg-danger">Habis</span>
            @endif
        </td>
        <td>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.products.show', $product->product_id) }}" class="btn btn-sm btn-info"
                    title="Detail">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-sm btn-warning"
                    title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="{{ route('admin.products.history', $product->product_id) }}" class="btn btn-sm btn-secondary"
                    title="History">
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
