@extends('layouts.admin')

@section('content')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="container mt-4">
    <h3>Edit Artikel</h3>
    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" id="articleForm">
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
        <!-- <div class="mb-3">
            <label>Tanggal Artikel</label>
            <textarea name="description" rows="3" class="form-control" required>{{ old('description', $article->description) }}</textarea>
        </div> -->
        <div class="mb-3">
            <label>Isi Artikel</label>
            <div id="quill-editor" style="height: 300px;">{!! old('body', $article->body) !!}</div>
            <input type="hidden" name="body" id="body">
        </div>
        <button class="btn btn-success" type="submit">Update</button>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#quill-editor', {
        theme: 'snow'
    });

    document.getElementById('articleForm').onsubmit = function() {
        document.getElementById('body').value = quill.root.innerHTML;
    };
</script>
@endsection