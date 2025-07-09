@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <style>
        body { font-family: 'Roboto', sans-serif; background: #f8f9fa; margin: 0; color: #222; }
        .header-profile {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 50%, #CDDC39 100%);
            border-radius: 0 0 32px 32px;
            padding: 32px 0 24px 0;
            color: white;
            text-align: center;
        }
        .header-profile-margin {
            margin: 60px 0 0 0;
        }
        .container { max-width: 520px; margin: 0 auto 32px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 32px; }
        .profile-pic {
            width: 110px;
            height: 110px;
            background: #E0F2F1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px auto;
            position: relative;
        }
        .profile-pic i {
            color: #4CAF50;
            font-size: 60px;
        }
        .edit-photo-btn {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: #FFF176;
            color: #388E3C;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .profile-name {
            font-size: 1.6rem;
            font-weight: 700;
            color: #388E3C;
            text-align: center;
            margin-bottom: 2px;
        }
        .profile-username {
            color: #888;
            text-align: center;
            margin-bottom: 18px;
            font-size: 1rem;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
            background: #E8F5E9;
            border-radius: 10px;
            padding: 12px 0;
        }
        .stat {
            flex: 1;
            text-align: center;
        }
        .stat .count {
            font-size: 1.2rem;
            font-weight: bold;
            color: #388E3C;
        }
        .stat .label {
            color: #888;
            font-size: 0.95rem;
        }
        .menu-list {
            margin-bottom: 28px;
        }
        .menu-item {
            display: flex;
            align-items: center;
            padding: 13px 0;
            border-bottom: 1px solid #f0f0f0;
            color: #222;
            text-decoration: none;
            font-size: 1.08rem;
            transition: background 0.15s;
        }
        .menu-item:last-child { border-bottom: none; }
        .menu-item i {
            margin-right: 16px;
            font-size: 1.2rem;
            color: #4CAF50;
        }
        .menu-item:hover { background: #F9FBE7; }
        .menu-item.logout {
            color: #d32f2f;
        }
        .biodata-box {
            background: #E8F5E9;
            border-radius: 10px;
            padding: 18px 20px;
            margin-top: 18px;
        }
        .biodata-title {
            color: #388E3C;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 1.1rem;
        }
        .biodata-row {
            display: flex;
            margin-bottom: 8px;
        }
        .biodata-label {
            width: 120px;
            color: #888;
            font-weight: 500;
        }
        .biodata-value {
            color: #222;
        }
        .choose-photo-btn {
            background: #FFF176;
            color: #388E3C;
            border: none;
            border-radius: 8px;
            padding: 7px 18px;
            font-weight: 600;
            font-size: 15px;
            margin-top: 10px;
            cursor: not-allowed;
            opacity: 0.7;
        }
        @media (max-width: 600px) {
            .container { padding: 16px; }
            .biodata-box { padding: 12px 8px; }
        }
    </style>
    <div class="header-profile header-profile-margin">
        <h2>Profil Saya</h2>
    </div>
    <div class="container">
        <div class="profile-pic">
            <i class="fas fa-user-circle"></i>
            <a href="{{ route('profile.edit') }}" class="edit-photo-btn" title="Edit Profil"><i class="fas fa-pen" style="font-size:10px;"></i></a>
        </div>
        <div class="profile-name">{{ session('user.name') }}</div>
        <div class="profile-username">{{ '@' . strtolower(str_replace(' ', '', session('user.name'))) }}</div>
        <div class="stats">
            <div class="stat"><div class="count">0</div><div class="label">Pengolahan</div></div>
            <div class="stat"><div class="count">0</div><div class="label">Dikirim</div></div>
            <div class="stat"><div class="count">1</div><div class="label">Selesai</div></div>
        </div>
        <div class="menu-list">
            <a href="#" class="menu-item"><i class="fas fa-store"></i>Katalog Saya</a>
            <a href="#" class="menu-item"><i class="fas fa-id-card"></i>Biodata Toko</a>
            <a href="#" class="menu-item"><i class="fas fa-question-circle"></i>Bantuan</a>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="menu-item logout" style="width:100%;text-align:left;background:none;border:none;padding:13px 0;"> <i class="fas fa-sign-out-alt"></i>Keluar</button>
            </form>
        </div>
        <div class="biodata-box">
            <div class="biodata-title">Biodata Diri</div>
            <div class="biodata-row"><div class="biodata-label">Nama</div><div class="biodata-value">{{ session('user.name') }}</div></div>
            <div class="biodata-row"><div class="biodata-label">Email</div><div class="biodata-value">{{ session('user.email') }}</div></div>
            <div class="biodata-row"><div class="biodata-label">Nomor HP</div><div class="biodata-value">{{ session('user.phone') }}</div></div>
            <button class="choose-photo-btn" disabled>Pilih Foto</button>
        </div>
    </div>
@endsection 