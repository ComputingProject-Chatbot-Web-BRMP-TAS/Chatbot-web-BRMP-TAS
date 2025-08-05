# Visualisasi Penyebaran Produk di Indonesia

## Deskripsi
Visualisasi ini menampilkan penyebaran produk benih di seluruh provinsi Indonesia menggunakan peta interaktif dengan GeoJSON. Fitur ini tersedia di dashboard admin.

## Fitur Utama

### 1. Peta Interaktif
- Menggunakan Leaflet.js untuk menampilkan peta Indonesia
- GeoJSON dengan 34 provinsi Indonesia
- Warna provinsi berdasarkan jumlah produk yang terjual
- Hover untuk melihat detail provinsi

### 2. Statistik Penyebaran
- Total provinsi dengan transaksi
- Total produk terjual
- Total quantity terjual
- Total nilai transaksi

### 3. Detail Provinsi
- Informasi lengkap per provinsi saat hover
- Daftar produk yang terjual di provinsi tersebut
- Quantity dan nilai transaksi per produk

## Cara Akses

1. Login sebagai admin
2. Klik menu "Peta" di navbar admin
3. Atau klik card "Penyebaran Produk" di dashboard admin

## Struktur Data

### Tabel yang Terlibat
- `transactions` - Data transaksi dengan `province_id`
- `transaction_items` - Item dalam transaksi
- `products` - Data produk
- `reg_provinces` - Data provinsi

### Mapping Data
- `province_id` di tabel `transactions` (string) dicocokkan dengan `KODE_PROV` di GeoJSON dan `id` di `reg_provinces` (integer)
- Data produk diambil dari `transaction_items` yang terkait dengan transaksi

## Teknologi yang Digunakan

### Frontend
- **Leaflet.js** - Library peta interaktif
- **Bootstrap** - Styling dan layout
- **JavaScript** - Interaktivitas dan data handling

### Backend
- **Laravel** - Framework PHP
- **MySQL** - Database
- **GeoJSON** - Format data geografis

## File yang Dibuat/Dimodifikasi

### Controller
- `app/Http/Controllers/admin/AdminDashboardController.php`
  - Method `productDistribution()` untuk mengambil data

### Routes
- `routes/admin.php`
  - Route untuk visualisasi produk

### Views
- `resources/views/admin/product_distribution.blade.php`
  - View utama visualisasi

### Assets
- `storage/app/geojson/provinces.json`
  - Data GeoJSON provinsi Indonesia (sudah ada)

### Navigation
- `resources/views/admin/partials/appbar.blade.php`
  - Menambahkan link "Peta"
- `resources/views/admin/dashboard.blade.php`
  - Menambahkan card visualisasi

### Tests
- `tests/Feature/ProductDistributionTest.php`
  - Test untuk memastikan fungsionalitas

## Cara Kerja

1. **Data Collection**: Controller mengambil data transaksi yang sudah selesai (bukan cancelled)
2. **Data Processing**: Mengelompokkan data berdasarkan provinsi dan produk
3. **Visualization**: Menampilkan data dalam bentuk peta dengan warna yang berbeda
4. **Interaction**: User dapat hover untuk melihat detail produk per provinsi

## Warna Peta
- **Merah Tua** (#800026): > 10 produk
- **Merah** (#BD0026): 8-10 produk
- **Merah Muda** (#E31A1C): 6-8 produk
- **Oranye** (#FC4E2A): 4-6 produk
- **Oranye Muda** (#FD8D3C): 2-4 produk
- **Kuning** (#FEB24C): 1-2 produk
- **Kuning Muda** (#FED976): 0 produk

## Troubleshooting

### Jika Peta Tidak Muncul
1. Pastikan file `provinces.json` ada di folder `storage/app/geojson/`
2. Periksa console browser untuk error JavaScript
3. Pastikan koneksi internet untuk loading Leaflet.js

### Jika Data Tidak Muncul
1. Pastikan ada data transaksi di database
2. Periksa apakah `province_id` di tabel `transactions` sesuai dengan `id` di `reg_provinces`
3. Pastikan transaksi tidak berstatus 'cancelled'

## Pengembangan Selanjutnya

1. **Filter Waktu**: Menambahkan filter berdasarkan periode waktu
2. **Filter Produk**: Menampilkan penyebaran produk tertentu
3. **Export Data**: Kemampuan untuk export data dalam format CSV/PDF
4. **Detail Transaksi**: Menampilkan detail transaksi per provinsi
5. **Trend Analysis**: Menampilkan trend penjualan per provinsi 