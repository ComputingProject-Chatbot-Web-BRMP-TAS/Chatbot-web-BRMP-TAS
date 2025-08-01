@extends('layouts.admin')

@section('content')
<div style="padding-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Tambah Produk Baru</h2>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Tambah Produk</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-3">Informasi Dasar</h6>
                                    
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Nama Produk *</label>
                                        <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                                               id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="plant_type_id" class="form-label">Kategori *</label>
                                        <select class="form-select @error('plant_type_id') is-invalid @enderror" 
                                                id="plant_type_id" name="plant_type_id" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($plantTypes as $plantType)
                                                <option value="{{ $plantType->plant_type_id }}" 
                                                        {{ old('plant_type_id') == $plantType->plant_type_id ? 'selected' : '' }}>
                                                    {{ $plantType->plant_type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('plant_type_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi *</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="mb-3">Informasi Stok & Harga</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="stock" class="form-label">Stok *</label>
                                                <input type="number" step="0.01" class="form-control @error('stock') is-invalid @enderror" 
                                                       id="stock" name="stock" value="{{ old('stock') }}" required>
                                                @error('stock')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="minimum_stock" class="form-label">Stok Minimum *</label>
                                                <input type="number" step="0.01" class="form-control @error('minimum_stock') is-invalid @enderror" 
                                                       id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock') }}" required>
                                                @error('minimum_stock')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="unit" class="form-label">Satuan *</label>
                                                <input type="text" class="form-control @error('unit') is-invalid @enderror" 
                                                       id="unit" name="unit" value="{{ old('unit', 'Kg') }}" required>
                                                @error('unit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="minimum_purchase" class="form-label">Min. Pembelian *</label>
                                                <input type="number" step="0.01" class="form-control @error('minimum_purchase') is-invalid @enderror" 
                                                       id="minimum_purchase" name="minimum_purchase" value="{{ old('minimum_purchase') }}" required>
                                                @error('minimum_purchase')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="price_per_unit" class="form-label">Harga per Unit (Rp) *</label>
                                        <input type="number" class="form-control @error('price_per_unit') is-invalid @enderror" 
                                               id="price_per_unit" name="price_per_unit" value="{{ old('price_per_unit') }}" required>
                                        @error('price_per_unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-3">Gambar Produk</h6>
                                    
                                    <div class="mb-3">
                                        <label for="image1" class="form-label">Gambar Utama</label>
                                        <input type="file" class="form-control @error('image1') is-invalid @enderror" 
                                               id="image1" name="image1" accept="image/*">
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                        @error('image1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="image2" class="form-label">Gambar Tambahan</label>
                                        <input type="file" class="form-control @error('image2') is-invalid @enderror" 
                                               id="image2" name="image2" accept="image/*">
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                        @error('image2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="mb-3">Informasi Sertifikat</h6>
                                    
                                    <div class="mb-3">
                                        <label for="image_certificate" class="form-label">Gambar Sertifikat</label>
                                        <input type="file" class="form-control @error('image_certificate') is-invalid @enderror" 
                                               id="image_certificate" name="image_certificate" accept="image/*">
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                        @error('image_certificate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="certificate_number" class="form-label">Nomor Sertifikat</label>
                                        <input type="text" class="form-control @error('certificate_number') is-invalid @enderror" 
                                               id="certificate_number" name="certificate_number" value="{{ old('certificate_number') }}">
                                        @error('certificate_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="certificate_class" class="form-label">Kelas Sertifikat</label>
                                        <input type="text" class="form-control @error('certificate_class') is-invalid @enderror" 
                                               id="certificate_class" name="certificate_class" value="{{ old('certificate_class') }}">
                                        @error('certificate_class')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="valid_from" class="form-label">Berlaku Dari</label>
                                                <input type="date" class="form-control @error('valid_from') is-invalid @enderror" 
                                                       id="valid_from" name="valid_from" value="{{ old('valid_from') }}">
                                                @error('valid_from')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="valid_until" class="form-label">Berlaku Sampai</label>
                                                <input type="date" class="form-control @error('valid_until') is-invalid @enderror" 
                                                       id="valid_until" name="valid_until" value="{{ old('valid_until') }}">
                                                @error('valid_until')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Produk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 