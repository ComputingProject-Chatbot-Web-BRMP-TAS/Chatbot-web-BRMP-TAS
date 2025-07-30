@extends('layouts.admin')
@section('content')
<div class="container" style="max-width:600px;padding-top: 80px;">
    <div class="card shadow" style="border-radius:20px;">
        <div class="card-body p-4">
            <h2 class="text-center mb-4" style="color:#388e3c;font-weight:700;">Detail Komplain</h2>
            <div class="mb-3">
                <b>Nama:</b> {{ $complaint->user->name ?? '-' }}<br>
                <b>No. Telepon:</b> {{ $complaint->user->phone ?? '-' }}
            </div>
            <div class="mb-4">
                <b>Deskripsi Komplain:</b>
                <div style="margin-top:8px;min-height:80px;">{{ $complaint->description }}</div>
            </div>
            <div class="mb-4 text-center">
                <b>Bukti Gambar:</b><br>
                @if($complaint->photo_proof)
                    <img src="{{ asset('storage/'.$complaint->photo_proof) }}" alt="Bukti Komplain" style="max-width:100%;max-height:340px;border-radius:14px;margin-top:10px;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                @else
                    <div style="color:#888;">Tidak ada gambar</div>
                @endif
            </div>
            @if($complaint->user && $complaint->user->phone)
            <div class="text-center mt-4">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$complaint->user->phone) }}" target="_blank" class="btn btn-success" style="font-size:1.1rem;padding:12px 32px;border-radius:10px;">
                    <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 