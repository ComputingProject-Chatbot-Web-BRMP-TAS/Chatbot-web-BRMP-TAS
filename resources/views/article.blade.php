
@extends('layouts.app')

@section('content')
<div style="max-width:900px;margin:120px auto 40px auto;padding:32px;background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <h1 style="font-size:2.2rem;font-weight:700;margin-bottom:18px;">Artikel Terbaru</h1>
    <div style="margin-bottom:32px;">
        <h2 style="font-size:1.3rem;font-weight:600;">Cara Menanam Benih yang Baik</h2>
        <p style="color:#444;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque euismod, nisi eu consectetur consectetur, nisl nisi consectetur nisi, eu consectetur nisl nisi euismod nisi.</p>
    </div>
    <div style="margin-bottom:32px;">
        <h2 style="font-size:1.3rem;font-weight:600;">Tips Memilih Benih Berkualitas</h2>
        <p style="color:#444;">Suspendisse potenti. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit.</p>
    </div>
    <div>
        <h2 style="font-size:1.3rem;font-weight:600;">Mengenal Jenis-jenis Benih Unggul</h2>
        <p style="color:#444;">Curabitur ac lacus arcu. Sed vehicula varius lectus auctor viverra. Nulla vehicula, sapien non hendrerit dapibus, enim urna suscipit urna.</p>
    </div>
</div>
@endsection

@section('after_content')
    @include('partials.mitra_footer')
@endsection