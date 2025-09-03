@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:32px; margin-bottom:40px;">
        <h2>{{ $article->headline }}</h2>
        <p style="color:#888;">{{ \Carbon\Carbon::parse($article->created_at)->format('d F Y') }}</p>
        @if ($article->image2)
            <img src="{{ asset('images/' . $article->image2) }}" alt="{{ $article->headline }} - gambar 2"
                style="width:100%;height:420px;object-fit:cover;border-radius:16px;display:block;margin-bottom:24px;">
        @endif
        <div style="margin-top:24px;padding-inline:8px;">{!! $article->body !!}</div>
    </div>
@endsection
