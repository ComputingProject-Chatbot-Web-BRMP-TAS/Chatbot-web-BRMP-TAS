<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class create_faq extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faqs')->insert([
            ['question' => 'Bagaimana cara memesan benih lewat website ini?', 'answer' => 'Anda dapat memesan benih lewat menu Pemesanan di website.'],
            ['question' => 'Apa saja metode pembayaran yang diterima?', 'answer' => 'Kami menerima pembayaran melalui transfer bank dan kartu kredit.'],
            ['question' => 'Berapa lama waktu pengiriman benih?', 'answer' => 'Waktu pengiriman biasanya memakan waktu 3-5 hari kerja tergantung lokasi Anda.'],
            ['question' => 'Apakah ada diskon untuk pembelian dalam jumlah besar?', 'answer' => 'Ya, kami menawarkan diskon khusus untuk pembelian dalam jumlah besar. Silakan hubungi layanan pelanggan kami untuk informasi lebih lanjut.'],
            ['question' => 'Bagaimana cara melacak status pesanan saya?', 'answer' => 'Anda dapat melacak status pesanan Anda melalui menu Akun Saya di website kami.'],
        ]);
    }
}
