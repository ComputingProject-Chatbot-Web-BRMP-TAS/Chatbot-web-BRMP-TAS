<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dummy</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background: #f8f9fa; margin: 0; color: #222; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 32px; }
        h2 { color: #388E3C; text-align: center; margin-bottom: 24px; }
        .form-group { margin-bottom: 18px; }
        label { font-weight: 500; color: #388E3C; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; font-size: 16px; }
        .btn { background: #FFF176; color: #388E3C; border: none; border-radius: 8px; padding: 10px 28px; font-weight: 600; font-size: 16px; cursor: pointer; width: 100%; }
        .btn:hover { background: #FFF59D; }
        .error { color: #d32f2f; margin-bottom: 10px; }
        .success { color: #388E3C; margin-bottom: 10px; }
        .link { display: block; text-align: center; margin-top: 18px; color: #388E3C; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Dummy</h2>
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('dummy.login') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <a href="{{ route('dummy.register') }}" class="link">Belum punya akun? Daftar di sini</a>
    </div>
</body>
</html> 