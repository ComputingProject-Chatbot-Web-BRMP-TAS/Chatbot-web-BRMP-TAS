@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Edit Artikel</h3>
    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Headline</label>
            <input type="text" name="headline" class="form-control" value="{{ old('headline', $article->headline) }}" required>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            @if($article->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$article->image) }}" width="120">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label>Isi Artikel</label>
            <textarea name="body" rows="10" class="form-control" required>{{ old('body', $article->body) }}</textarea>
        </div>
        <button class="btn btn-success" type="submit">Update</button>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection