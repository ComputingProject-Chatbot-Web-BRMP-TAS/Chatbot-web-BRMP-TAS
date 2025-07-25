@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width:500px; margin-top:90px;">
    <div class="card shadow" style="border-radius: 20px;">
        <div class="card-body p-4">
            <h2 class="text-center mb-4" style="color: #388e3c;">Form Komplain</h2>
            @guest
                <div class="alert alert-warning text-center">Anda harus <a href='{{ route('login') }}'>login</a> untuk mengirim komplain.</div>
            @else
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('complaint.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Komplain</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Gambar Bukti <span class="text-danger">*</span></label>
                        <input type="file" name="photo_proof" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Kirim Komplain</button>
                </form>
            @endguest
        </div>
    </div>
</div>
@endsection 