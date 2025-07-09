<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #eaffea; }
    </style>
</head>
<body>
    @include('partials.appbar')
    @php
        $routeName = Route::currentRouteName();
        $isHome = request()->is('/') || $routeName === 'home';
        $isCart = $routeName === 'cart';
        $isKategori = in_array($routeName, ['kategori.tumbuhan','kategori.rempah','kategori.buah','kategori.sayuran','kategori.bunga']);
    @endphp
    <div style="min-height:80vh; margin-top: 96px; @if($isHome)padding-top: 24px;@else padding-top: 0;@endif">
        @yield('content')
    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 