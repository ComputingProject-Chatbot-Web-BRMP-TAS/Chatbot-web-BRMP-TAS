{{-- resources/views/admin/articles/create.blade.php --}}
@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <h3>Tambah Artikel</h3>
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Headline</label>
            <input type="text" name="headline" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label>Isi Artikel3</label>
            <textarea name="body" rows="5" class="form-control" required></textarea>
        </div>
        <button class="btn btn-success" type="submit">Simpan</button>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection