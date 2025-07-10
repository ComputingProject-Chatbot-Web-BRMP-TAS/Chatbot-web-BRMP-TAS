@extends('layouts.app')

@section('content')
<div style="max-width:1200px;margin:120px auto 40px auto;">
    <h1 style="font-size:2rem;font-weight:700;margin-bottom:32px;">Artikel Terbaru</h1>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));gap:32px;">
        <div style="background:#fff;border-radius:24px;box-shadow:0 2px 12px rgba(0,0,0,0.04);padding-bottom:24px;">
            <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80" alt="Migrating to Linear 101" style="width:100%;height:220px;object-fit:cover;border-radius:24px 24px 0 0;">
            <div style="padding:24px;">
                <h2 style="font-size:1.35rem;font-weight:700;margin-bottom:10px;">judul artikel</h2>
                <p style="color:#444;font-size:1rem;line-height:1.6;">deskripsi singkat.</p>
            </div>
        </div>
        <div style="background:#fff;border-radius:24px;box-shadow:0 2px 12px rgba(0,0,0,0.04);padding-bottom:24px;">
            <img src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?auto=format&fit=crop&w=600&q=80" alt="Building your API Stack" style="width:100%;height:220px;object-fit:cover;border-radius:24px 24px 0 0;">
            <div style="padding:24px;">
                <h2 style="font-size:1.35rem;font-weight:700;margin-bottom:10px;">judul artikel</h2>
                <p style="color:#444;font-size:1rem;line-height:1.6;">deskripsi singkat.</p>
            </div>
        </div>
        <div style="background:#fff;border-radius:24px;box-shadow:0 2px 12px rgba(0,0,0,0.04);padding-bottom:24px;">
            <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=600&q=80" alt="Bill Walsh leadership lessons" style="width:100%;height:220px;object-fit:cover;border-radius:24px 24px 0 0;">
            <div style="padding:24px;">
                <h2 style="font-size:1.35rem;font-weight:700;margin-bottom:10px;">judul artikel</h2>
                <p style="color:#444;font-size:1rem;line-height:1.6;">deskripsi singkat.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_content')
    @include('partials.mitra_footer')
@endsection