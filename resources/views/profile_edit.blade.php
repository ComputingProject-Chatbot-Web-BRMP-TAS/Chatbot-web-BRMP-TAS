<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background: #f8f9fa; margin: 0; color: #222; }
        .header-profile {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 50%, #CDDC39 100%);
            border-radius: 0 0 32px 32px;
            padding: 32px 0 24px 0;
            color: white;
            text-align: center;
            margin-bottom: 0;
        }
        .container { max-width: 420px; margin: 0 auto 32px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 32px; }
        .profile-pic {
            width: 90px;
            height: 90px;
            background: #E0F2F1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px auto;
            position: relative;
        }
        .profile-pic i {
            color: #4CAF50;
            font-size: 48px;
        }
        .edit-photo-btn {
            position: absolute;
            bottom: 4px;
            right: 4px;
            background: #FFF176;
            color: #388E3C;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            cursor: not-allowed;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        h2 { color: #388E3C; text-align: center; margin-bottom: 24px; }
        .form-group { margin-bottom: 18px; }
        label { font-weight: 500; color: #388E3C; }
        input[type="text"], input[type="email"], input[type="file"] { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; font-size: 16px; }
        .btn { background: #FFF176; color: #388E3C; border: none; border-radius: 8px; padding: 10px 28px; font-weight: 600; font-size: 16px; cursor: pointer; width: 100%; }
        .btn:hover { background: #FFF59D; }
        .error { color: #d32f2f; margin-bottom: 10px; }
        .back-link { display: block; text-align: center; margin-top: 18px; color: #388E3C; text-decoration: none; }
    </style>
</head>
<body>
    @include('partials.appbar')
    <div class="header-profile">
        <h2>Edit Profil</h2>
    </div>
    <div class="container">
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('profile.edit') }}" enctype="multipart/form-data">
            @csrf
            <div class="profile-pic">
                <i class="fas fa-user-circle"></i>
                <span class="edit-photo-btn" title="Ganti Foto"><i class="fas fa-pen"></i></span>
            </div>
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', session('user.name')) }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', session('user.email')) }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Nomor HP</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', session('user.phone')) }}" required>
            </div>
            <div class="form-group">
                <label for="photo">Foto Profil (dummy)</label>
                <input type="file" id="photo" name="photo" disabled>
            </div>
            <button type="submit" class="btn">Simpan Perubahan</button>
        </form>
        <a href="{{ route('profile') }}" class="back-link">Kembali ke Profil</a>
    </div>
</body>
</html> 