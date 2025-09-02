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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!--Font yang digunakan-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Outfit', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            font-weight: bold;
        }

        h1 {
            color: white;
        }

        h2 {
            color: #085c3d;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            width: 100%;
            box-sizing: border-box;
        }

        .product-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 0;
            margin-bottom: 0;
            transition: all 0.3s ease;
            border: 1px solid rgba(76, 175, 80, 0.1);
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            width: 100%;
        }


        .product-card:hover {
            border-color: #4CAF50;
            transform: translateY(-2px);
        }

        .product-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #4CAF50;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 10;
        }

        .product-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }


        .product-card .info {
            padding: 5px 10px 10px 10px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;

        }

        .product-card .title {
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 6px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-card .price {
            color: #388E3C;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .product-card .desc {
            color: #757575;
            font-size: 12px;
            height: 32px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-card .stock {
            font-size: 12px;
            margin-top: 8px;
        }

        @media (max-width: 1023px) {
            .product-grid {
                grid-template-columns: repeat(auto-fit, minmax(145px, 1fr));
                gap: 10px;
            }
        }

        .btn-green {
            border-radius: 8px;
            border: 2px solid #3C9A40;
            background: #4CAF50;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            padding: 10px 0;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .btn-green:hover {
            transform: translateY(-2px);
        }

        .btn-green:disabled {
            border: 2px solid #929292;
            background: #D9D9D9;
            cursor: not-allowed;
            transform: none;
        }
    </style>
    @stack('styles')
</head>

<body>
    @if (empty($hideAppbar) || !$hideAppbar)
        @include('customer.partials.appbar')
    @endif
    @php
        $routeName = Route::currentRouteName();
        $isAuth = $routeName === 'login' || $routeName === 'register' || $routeName === 'verification.notice';
    @endphp
    <div style="padding-top: 65px; margin-top:0; @if ($isAuth) padding-top:0px; @endif">
        @yield('content')
    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @yield('after_content')
</body>

</html>
