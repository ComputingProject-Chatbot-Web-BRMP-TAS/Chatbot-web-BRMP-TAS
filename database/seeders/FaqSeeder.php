<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faqs')->insert([
            // 🌾 UMUM
            [
                'question' => 'Apa itu aplikasi penjualan benih BRMP-TAS Malang?',
                'answer' => 'Aplikasi penjualan benih BRMP-TAS Malang adalah platform e-commerce resmi yang dikembangkan oleh Balai Perakitan dan Pengujian Tanaman Pemanis dan Serat (BRMP-TAS) untuk memudahkan petani membeli benih unggul secara online.',
                'keywords' => 'tentang aplikasi, brmp tas, e-commerce, benih'
            ],
            [
                'question' => 'Siapa yang mengelola aplikasi ini?',
                'answer' => 'Aplikasi ini dikelola oleh BRMP-TAS di bawah Kementerian Pertanian Republik Indonesia.',
                'keywords' => 'pengelola, kementerian pertanian, brmp tas'
            ],
            [
                'question' => 'Apakah aplikasi ini resmi dari Kementerian Pertanian?',
                'answer' => 'Ya, aplikasi ini merupakan bagian dari transformasi digital layanan publik Kementerian Pertanian melalui BRMP-TAS.',
                'keywords' => 'resmi, kementerian, pertanian, brmp'
            ],
            [
                'question' => 'Bagaimana cara mendaftar akun di aplikasi BRMP-TAS?',
                'answer' => 'Pengguna dapat mendaftar dengan mengklik tombol "Daftar" pada halaman utama, lalu mengisi data pribadi seperti nama, email, nomor HP, dan password.',
                'keywords' => 'daftar, registrasi, akun, pengguna'
            ],
            [
                'question' => 'Apakah aplikasi ini bisa digunakan di HP?',
                'answer' => 'Ya, aplikasi berbasis web ini dirancang responsif sehingga bisa diakses melalui smartphone maupun komputer.',
                'keywords' => 'mobile, hp, smartphone, akses'
            ],
            [
                'question' => 'Apakah saya perlu datang ke balai untuk membeli benih?',
                'answer' => 'Tidak perlu. Seluruh proses pembelian, pembayaran, dan pelacakan pesanan dapat dilakukan secara online melalui aplikasi.',
                'keywords' => 'beli online, tanpa datang, pembelian, jarak jauh'
            ],

            // 🛒 PEMBELIAN
            [
                'question' => 'Bagaimana cara memesan benih melalui website?',
                'answer' => 'Masuk ke akun Anda, pilih produk benih di katalog, tambahkan ke keranjang, lalu lanjutkan ke proses checkout dan konfirmasi pesanan.',
                'keywords' => 'pesan, cara membeli, order, checkout'
            ],
            [
                'question' => 'Apakah saya bisa membeli lebih dari satu jenis benih dalam satu transaksi?',
                'answer' => 'Ya, Anda dapat menambahkan beberapa jenis benih ke dalam keranjang sebelum melakukan checkout.',
                'keywords' => 'multi produk, banyak, satu transaksi, keranjang'
            ],
            [
                'question' => 'Bagaimana jika stok benih habis?',
                'answer' => 'Jika stok habis, tombol pembelian akan dinonaktifkan dan Anda dapat menandai produk untuk notifikasi saat tersedia kembali.',
                'keywords' => 'stok habis, ketersediaan, notifikasi'
            ],
            [
                'question' => 'Apakah harga benih di website sama dengan harga di balai?',
                'answer' => 'Ya, harga di website merupakan harga resmi yang ditetapkan oleh BRMP-TAS.',
                'keywords' => 'harga, resmi, sama, balai'
            ],
            [
                'question' => 'Bagaimana cara mengetahui status pesanan saya?',
                'answer' => 'Anda dapat melihat status pesanan melalui menu "Riwayat Transaksi" di dashboard akun Anda.',
                'keywords' => 'status pesanan, tracking, riwayat transaksi'
            ],

            // 💳 PEMBAYARAN
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => 'Pembayaran dapat dilakukan melalui transfer bank atau sistem pembayaran digital (payment gateway) yang terintegrasi.',
                'keywords' => 'pembayaran, metode, transfer, gateway'
            ],
            [
                'question' => 'Bagaimana cara mengonfirmasi pembayaran saya?',
                'answer' => 'Setelah transfer, unggah bukti pembayaran melalui menu “Konfirmasi Pembayaran” pada dashboard akun Anda.',
                'keywords' => 'konfirmasi, bukti pembayaran, transfer'
            ],
            [
                'question' => 'Apa yang harus dilakukan jika pembayaran saya gagal?',
                'answer' => 'Pastikan koneksi internet stabil dan saldo mencukupi. Jika tetap gagal, hubungi admin melalui halaman kontak.',
                'keywords' => 'gagal, pembayaran error, kendala transaksi'
            ],
            [
                'question' => 'Apakah saya akan mendapat bukti transaksi setelah pembayaran berhasil?',
                'answer' => 'Ya, sistem akan otomatis mengirimkan bukti pembayaran ke email Anda dan menampilkannya di halaman riwayat transaksi.',
                'keywords' => 'bukti, invoice, kwitansi, transaksi'
            ],

            // 🚚 PENGIRIMAN
            [
                'question' => 'Berapa lama waktu pengiriman benih?',
                'answer' => 'Waktu pengiriman bervariasi antara 2–7 hari kerja tergantung lokasi penerima.',
                'keywords' => 'pengiriman, durasi, lama, ekspedisi'
            ],
            [
                'question' => 'Apakah saya bisa memilih jasa ekspedisi?',
                'answer' => 'Saat ini pengiriman menggunakan mitra logistik yang bekerja sama dengan BRMP-TAS, dan akan terus ditingkatkan ke depan.',
                'keywords' => 'ekspedisi, pengiriman, jasa kirim'
            ],
            [
                'question' => 'Bagaimana cara melacak pengiriman benih saya?',
                'answer' => 'Nomor resi dan status pengiriman dapat dilihat di halaman “Riwayat Transaksi”.',
                'keywords' => 'lacak, tracking, resi, pengiriman'
            ],
            [
                'question' => 'Apa yang harus saya lakukan jika benih tidak sampai atau rusak?',
                'answer' => 'Segera hubungi admin melalui fitur komplain dan sertakan bukti foto produk yang diterima.',
                'keywords' => 'rusak, tidak sampai, komplain, bantuan'
            ],

            // 🧾 AKUN
            [
                'question' => 'Bagaimana cara mengubah data profil saya?',
                'answer' => 'Masuk ke dashboard akun dan pilih menu “Profil Saya” untuk memperbarui data pribadi Anda.',
                'keywords' => 'ubah profil, data akun, edit pengguna'
            ],
            [
                'question' => 'Bagaimana jika saya lupa password akun?',
                'answer' => 'Klik “Lupa Password” di halaman login, lalu ikuti instruksi reset melalui email Anda.',
                'keywords' => 'lupa password, reset, akun'
            ],

            // 🌱 INFORMASI BENIH
            [
                'question' => 'Apa saja jenis benih yang tersedia di BRMP-TAS?',
                'answer' => 'Aplikasi menyediakan berbagai jenis benih tanaman pemanis dan serat seperti tebu, kapas, dan rosela.',
                'keywords' => 'jenis benih, tebu, kapas, rosela'
            ],
            [
                'question' => 'Apakah benih yang dijual sudah bersertifikat?',
                'answer' => 'Ya, semua benih yang dijual melalui BRMP-TAS telah melalui proses pengujian dan sertifikasi resmi.',
                'keywords' => 'sertifikat, legal, resmi, uji benih'
            ],

            // 📞 KOMPLAIN
            [
                'question' => 'Bagaimana cara menghubungi admin BRMP-TAS?',
                'answer' => 'Anda dapat menghubungi admin melalui halaman “Hubungi Kami” atau melalui fitur komplain di dashboard.',
                'keywords' => 'hubungi admin, kontak, bantuan'
            ],
            [
                'question' => 'Bagaimana cara mengajukan komplain?',
                'answer' => 'Masuk ke akun Anda, buka menu “Komplain”, isi form beserta kategori masalah dan bukti pendukung.',
                'keywords' => 'komplain, keluhan, laporan, bantuan'
            ],

            // 🔒 KEAMANAN
            [
                'question' => 'Apakah data saya aman di aplikasi BRMP-TAS?',
                'answer' => 'Ya, data pengguna dilindungi dengan enkripsi SSL dan sistem keamanan Laravel untuk menjaga privasi Anda.',
                'keywords' => 'keamanan, ssl, privasi, data pengguna'
            ],
            [
                'question' => 'Apakah website ini menggunakan SSL?',
                'answer' => 'Ya, seluruh transaksi dan data pengguna terenkripsi melalui sertifikat SSL untuk mencegah penyalahgunaan data.',
                'keywords' => 'ssl, enkripsi, aman, data'
            ],
        ]);
    }
}
