<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - {{ $produk['nama'] }}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background: #f8f9fa; margin: 0; color: #222; }
        .header-detail {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 50%, #CDDC39 100%);
            border-radius: 0 0 32px 32px;
            padding: 32px 0 24px 0;
            color: white;
            text-align: center;
            margin-bottom: 0;
        }
        .container { max-width: 480px; margin: 0 auto 32px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 24px; }
        .img-detail { width: 100%; height: 220px; background: #E0F2F1; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; }
        .img-detail i { color: #B2DFDB; font-size: 64px; }
        .title { font-size: 1.5rem; font-weight: 700; margin-bottom: 8px; color: #388E3C; }
        .price { color: #F9A825; background: #FFFDE7; border-radius: 8px; display: inline-block; padding: 6px 18px; font-weight: bold; font-size: 1.2rem; margin-bottom: 12px; }
        .desc { margin-bottom: 18px; color: #444; }
        .detail { background: #E8F5E9; border-radius: 8px; padding: 12px 16px; margin-bottom: 8px; }
        .label { font-weight: 500; color: #4CAF50; }
        .value { float: right; color: #333; }
        .btn-kuning { background: #FFF176; color: #388E3C; border: none; border-radius: 8px; padding: 10px 28px; font-weight: 600; font-size: 16px; cursor: pointer; margin-top: 18px; transition: all 0.2s; }
        .btn-kuning:hover { background: #FFF59D; }
    </style>
</head>
<body>
    @include('partials.appbar')
    <div class="header-detail">
        <h2>Detail Produk</h2>
    </div>
    <div class="container">
        <div class="img-detail">
            <i class="fas fa-image"></i>
        </div>
        <div class="title">{{ $produk['nama'] }}</div>
        <div class="price">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</div>
        <div class="desc">{{ $produk['deskripsi'] }}</div>
        <div class="detail"><span class="label">Kategori</span> <span class="value">{{ $produk['kategori'] }}</span></div>
        <div class="detail"><span class="label">Kondisi</span> <span class="value">{{ $produk['kondisi'] }}</span></div>
        <div class="detail"><span class="label">Style</span> <span class="value">{{ $produk['style'] }}</span></div>
        <button class="btn-kuning">Tambah ke Keranjang</button>
    </div>
</body>
</html> 