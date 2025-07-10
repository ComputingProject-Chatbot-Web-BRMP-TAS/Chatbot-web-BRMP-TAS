@extends('layouts.app')

@section('content')
<style>
    body { background: #f8f9fa; }
    .profile-tabs {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 32px;
        margin-top: 64px;
        justify-content: flex-start;
    }
    .profile-tab {
        padding: 16px 36px 12px 36px;
        font-weight: 500;
        color: #222;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-size: 1.1rem;
        transition: color 0.2s, border 0.2s;
        text-decoration: none;
    }
    .profile-tab.active {
        color: #4CAF50;
        border-bottom: 3px solid #4CAF50;
        font-weight: 700;
    }
    .addresses-container {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 32px 32px 24px 32px;
        margin-top: 32px;
        justify-items: center;
    }
    .address-add-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }
    .btn-add-address {
        background: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 40%;
        font-weight: 600;
        font-size: 1rem;
        transition: background 0.2s;
        cursor: pointer;
        white-space: nowrap;
    }
    .btn-add-address:hover {
        background: #388E3C;
    }
    .address-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 48px;
        margin-bottom: 48px;
    }
    .address-empty-img {
        width: 220px;
        margin-bottom: 18px;
    }
    .address-empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 8px;
        text-align: center;
    }
    .address-empty-desc {
        color: #666;
        font-size: 1.08rem;
        text-align: center;
    }
    @media (max-width: 900px) {
        .addresses-container { padding: 18px 8px; }
        .profile-tabs { margin-top: 32px; }
    }
</style>
<div class="profile-tabs">
    <a href="{{ route('profile') }}" class="profile-tab @if(Route::currentRouteName() == 'profile') active @endif">Biodata Diri</a>
    <a href="{{ route('addresses') }}" class="profile-tab @if(Route::currentRouteName() == 'addresses') active @endif">Daftar Alamat</a>
</div>
<div class="addresses-container">
    <div class="address-add-row">
        <button class="btn-add-address">+ Tambah Alamat Baru</button>
    </div>
    <div class="address-empty">
        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="Alamat kosong" class="address-empty-img">
        <div class="address-empty-title">Ops!, alamat tidak tersedia</div>
        <div class="address-empty-desc">Kamu bisa tambah alamat baru dengan mengklik tombol di atas.</div>
    </div>
</div>
@endsection 