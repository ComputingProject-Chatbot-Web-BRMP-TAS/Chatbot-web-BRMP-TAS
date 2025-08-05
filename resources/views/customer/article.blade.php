@extends('layouts.app')

@section('content')
<div style="max-width:1200px;margin:120px auto 40px auto;">
    <h1 style="font-size:2rem;font-weight:700;margin-bottom:32px;">Artikel Terbaru</h1>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));gap:32px;">
        @forelse($articles as $article)
            <div style="background:#fff;border-radius:24px;box-shadow:0 2px 12px rgba(0,0,0,0.04);padding-bottom:24px;">
                @if($article->image)
                    <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->headline }}" style="width:100%;height:220px;object-fit:cover;border-radius:24px 24px 0 0;">
                @else
                    <div style="width:100%;height:220px;background:#eee;border-radius:24px 24px 0 0;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:2rem;">
                        Tidak ada gambar
                    </div>
                @endif
                <div style="padding:24px;">
                    <h2 style="font-size:1.35rem;font-weight:700;margin-bottom:10px;">{{ $article->headline }}</h2>
                    <p style="color:#444;font-size:1rem;line-height:1.6;">
                        {{ \Illuminate\Support\Str::limit(strip_tags($article->body), 90) }}
                    </p>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1;text-align:center;color:#888;">Belum ada artikel.</div>
        @endforelse
    </div>
</div>
@endsection

@section('after_content')
    @include('customer.partials.mitra_footer')
@endsection