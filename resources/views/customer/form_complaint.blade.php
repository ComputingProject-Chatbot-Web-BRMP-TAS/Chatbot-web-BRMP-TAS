@extends('layouts.app')
@section('content')
<div class="container py-4" style="margin-top: 10vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    
    <div class="card shadow" style="border-radius: 20px;">
        <div class="card-body p-4">
            <h2 class="text-center mb-4" style="color: #388e3c; font-weight: 700;">
                Form Komplain
            </h2>
            
            @guest
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Anda harus <a href='{{ route('login') }}' class="alert-link">login</a> untuk mengirim komplain.
                </div>
            @else
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Mohon perbaiki kesalahan berikut:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('complaint.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-edit me-1"></i>Deskripsi Komplain
                        </label>
                        <textarea 
                            name="description" 
                            class="form-control @error('description') is-invalid @enderror" 
                            rows="5" 
                            placeholder="Jelaskan detail masalah atau keluhan Anda..."
                            required
                        >{{ old('description') }}</textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Maksimal 1000 karakter. Jelaskan dengan detail agar kami dapat membantu dengan lebih baik.
                        </div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-image me-1"></i>Upload Gambar Bukti <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="file" 
                            name="photo_proof" 
                            class="form-control @error('photo_proof') is-invalid @enderror" 
                            accept="image/*" 
                            required
                        >
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Format: JPG, JPEG, PNG. Maksimal 10MB. Bukti foto akan membantu kami memahami masalah dengan lebih baik.
                        </div>
                        @error('photo_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong> Setelah komplain dikirim, tim kami akan menghubungi Anda melalui WhatsApp untuk menangani masalah ini.
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100 py-3" style="font-weight: 600;">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Komplain
                    </button>
                </form>
            @endguest
        </div>
    </div>
</div>
@endsection 