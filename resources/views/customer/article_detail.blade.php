@extends('layouts.app')

@section('content')
<div style="max-width:800px;margin:120px auto 40px auto;">
    <h1 style="font-size:2rem;font-weight:700;">{{ $article->headline }}</h1>
    <p style="color:#888;">{{ \Carbon\Carbon::parse($article->created_at)->format('d F Y') }}</p>
    @if($article->image)
        <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->headline }}" style="width:100%;max-height:320px;object-fit:cover;border-radius:16px;margin-bottom:24px;">
    @endif
    <div style="margin-top:24px;">{!! $article->body !!}</div>
</div>
@endsection