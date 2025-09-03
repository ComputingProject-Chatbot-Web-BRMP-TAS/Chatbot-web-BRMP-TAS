<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        DB::table('articles')->insert([
            [
                'headline' => 'Panduan Cerdas Budidaya Tebu untuk Hasil Gula Terbaik',
                'image' => 'Budidaya-Tebu.png',
                'image2' => 'Tebu.png',
                'body' => <<<HTML
<b>Tebu (<i>Saccharum officinarum</i>)</b> adalah tanaman penting sebagai sumber utama sukrosa atau gula. Budidaya tebu yang sukses tidak hanya berfokus pada kuantitas panen, tetapi juga pada kualitas rendemen (kandungan gula) yang tinggi.<br><br>
Berikut adalah panduan singkat untuk budidaya tebu secara optimal.<br>
<b>1. Persiapan Lahan dan Bibit</b><br>
<ul>
    <li><b>Pemilihan Lahan:</b> Tebu membutuhkan lahan yang subur, gembur, dan memiliki aerasi serta drainase yang baik. Tanah jenis latosol atau andosol sangat cocok. Lakukan pengolahan lahan yang dalam, seperti pembajakan dan penggaruan, untuk memecah bongkahan tanah.</li>
    <li><b>Persiapan Bibit (Stek):</b> Bibit tebu biasanya berasal dari potongan batang tebu yang sehat dan sudah matang. Bibit ini disebut <i>stek</i>. Pilih batang tebu yang bebas dari hama dan penyakit, lalu potong sepanjang 2-3 ruas dengan mata tunas yang sehat.</li>
    <li><b>Penanaman Bibit:</b> Buat alur tanam atau lubang dengan kedalaman sekitar 20-30 cm. Letakkan <i>stek</i> bibit secara berbaris dan tutup dengan tanah. Jarak tanam yang ideal penting untuk pertumbuhan optimal.</li>
</ul>
<b>2. Pemeliharaan Tanaman Tebu</b><br>
<ul>
    <li><b>Penyulaman:</b> Lakukan penyulaman (penanaman kembali bibit) pada 1-2 minggu setelah tanam untuk mengganti bibit yang tidak tumbuh.</li>
    <li><b>Penyingangan:</b> Bersihkan gulma secara rutin, terutama pada fase awal pertumbuhan, untuk mengurangi persaingan unsur hara, air, dan sinar matahari.</li>
    <li><b>Pengairan:</b> Tebu adalah tanaman yang membutuhkan banyak air, terutama pada fase pertumbuhan vegetatif (fase <i>grand growth</i>). Berikan pengairan yang cukup, namun pastikan lahan tidak tergenang air karena dapat menyebabkan busuk akar.</li>
    <li><b>Pemupukan:</b> Berikan pupuk sesuai dosis dan jadwal yang tepat. Pupuk dasar diberikan saat penanaman, dan pupuk susulan (biasanya pupuk nitrogen dan kalium) diberikan pada fase awal hingga pertengahan pertumbuhan untuk mendukung pembesaran batang.</li>
    <li><b>Pengendalian Hama dan Penyakit:</b> Hama seperti penggerek batang tebu dan penyakit seperti <i>mosaic virus</i> merupakan ancaman utama. Lakukan pemantauan rutin dan terapkan metode pengendalian terpadu.</li>
</ul>
<b>3. Panen dan Pascapanen</b><br>
<ul>
    <li><b>Masa Panen:</b> Waktu panen tebu sangat krusial untuk mendapatkan rendemen gula tertinggi. Tebu biasanya dipanen pada usia 12-14 bulan. Ciri-ciri tebu siap panen adalah daun terbawah mulai mengering, dan rendemennya sudah mencapai puncaknya (dapat diukur dengan alat khusus seperti refraktometer).</li>
    <li><b>Metode Panen:</b> Tebu dipanen dengan cara memotong batang sedekat mungkin dengan permukaan tanah, karena bagian bawah batang memiliki kandungan gula tertinggi.</li>
    <li><b>Pascapanen:</b> Setelah dipanen, tebu harus segera diangkut ke pabrik gula. Penundaan dapat menyebabkan penyusutan rendemen (kandungan gula menurun) akibat proses respirasi dan fermentasi.</li>
</ul>
Dengan memperhatikan setiap detail dari proses budidaya, mulai dari pemilihan bibit unggul, pemeliharaan yang konsisten, hingga panen yang tepat waktu, petani dapat memaksimalkan produksi gula dan mendapatkan hasil yang menguntungkan.
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'headline' => 'Cara Sukses Menanam Tembakau Lokal',
                'image' => 'Cara-Menanam-Tembakau.png',
                'image2' => 'Tembakau.png',
                'body' => <<<HTML
<b>Tembakau</b> adalah komoditas pertanian strategis yang membutuhkan perawatan intensif dan metode budidaya yang tepat untuk menghasilkan kualitas terbaik. Keberhasilan panen tembakau sangat dipengaruhi oleh setiap tahapan, mulai dari persiapan lahan hingga proses pascapanen.<br>
Berikut adalah panduan singkat cara sukses menanam tembakau.<br>
<b>1. Persiapan Lahan dan Bibit (Pesemaian)</b><br>
<ul>
    <li><b>Pemilihan Lahan:</b> Pilih lahan yang subur, gembur, dan memiliki drainase yang baik. Tembakau menyukai tanah dengan pH ideal antara 5.5 - 6.5. Pastikan lahan mendapatkan sinar matahari yang cukup sepanjang hari.</li>
    <li><b>Persiapan Bibit:</b> Bibit berkualitas menjadi kunci. Gunakan benih bersertifikat atau beli bibit dari petani tepercaya. Bibit disemai terlebih dahulu di lahan khusus (pesemaian) selama 40-50 hari hingga memiliki 4-6 helai daun.</li>
</ul>
<b>2. Penanaman dan Pemeliharaan Intensif</b><br>
<ul>
    <li><b>Penanaman:</b> Pindahkan bibit dari pesemaian ke lahan tanam utama pada sore hari untuk menghindari stres panas. Tanam dengan jarak tanam yang ideal (umumnya 60x70 cm atau 70x90 cm) agar setiap tanaman mendapatkan sirkulasi udara dan sinar matahari yang cukup.</li>
    <li><b>Penyiraman:</b> Lakukan pengairan secara teratur, terutama di awal penanaman. Frekuensi pengairan disesuaikan dengan kondisi cuaca dan kelembaban tanah.</li>
    <li><b>Pemupukan:</b> Berikan pupuk sesuai dosis dan jadwal yang tepat. Pupuk dasar diberikan sebelum tanam, sedangkan pupuk susulan diberikan pada fase pertumbuhan (vegetatif) untuk mendukung perkembangan daun.</li>
    <li><b>Penyingangan:</b> Bersihkan gulma secara rutin yang dapat bersaing dengan tanaman tembakau dalam menyerap unsur hara.</li>
    <li><b>Perompesan (Topping dan Suckering):</b> Ini adalah tahap krusial untuk kualitas daun.
        <ul>
            <li><b>Topping (Potes Pucuk):</b> Potes bagian bunga dan pucuk tanaman saat bunga mulai muncul. Tujuannya agar nutrisi fokus ke pembesaran daun, bukan ke bunga.</li>
            <li><b>Suckering (Buang Tunas Samping):</b> Potes tunas-tunas baru yang tumbuh dari ketiak daun. Lakukan secara rutin agar daun tidak berebut nutrisi.</li>
        </ul>
    </li>
</ul>
<b>3. Panen dan Pascapanen</b><br>
<ul>
    <li><b>Panen:</b> Panen dilakukan secara bertahap, dimulai dari daun terbawah yang sudah tua dan matang. Ciri-ciri daun siap panen adalah warnanya mulai menguning, daun menjadi tebal, dan kaku.</li>
    <li><b>Pascapanen (Pengeringan):</b> Daun tembakau yang baru dipanen memiliki kadar air tinggi dan belum siap diolah. Lakukan proses pengeringan atau <i>curing</i> untuk mengurangi kadar air, mematangkan warna, dan mengembangkan aroma.
        <ul>
            <li><b>Pengeringan Matahari:</b> Metode tradisional dengan menjemur daun di bawah sinar matahari.</li>
            <li><b>Pengeringan Oven (Flue Curing):</b> Menggunakan oven khusus dengan suhu terkontrol untuk menghasilkan kualitas yang lebih seragam.</li>
        </ul>
    </li>
</ul>
<b>4. Pengendalian Hama dan Penyakit</b><br>
<ul>
    <li>Lakukan pemantauan rutin untuk mendeteksi serangan hama (seperti ulat <i>grayak</i>) atau penyakit (seperti busuk batang).</li>
    <li>Terapkan metode pengendalian terpadu, mulai dari cara alami hingga penggunaan pestisida yang diizinkan sesuai dosis yang dianjurkan.</li>
</ul>
Dengan mengikuti tahapan budidaya dan perawatan yang tepat, Anda dapat meminimalkan risiko gagal panen dan menghasilkan daun tembakau dengan kualitas tinggi yang bernilai jual optimal.
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'headline' => 'Budidaya Stevia: Tanaman Pemanis Alami Bebas Kalori',
                'image' => 'Budidaya-Stevia.png',
                'image2' => 'Stevia.png',
                'body' => <<<HTML
<b>Stevia (<i>Stevia rebaudiana</i>)</b> adalah tanaman yang daunnya dikenal sebagai pemanis alami dan sehat, menjadi alternatif pengganti gula tanpa kalori. Budidaya stevia semakin diminati seiring dengan meningkatnya kesadaran akan gaya hidup sehat.<br><br>
Berikut adalah panduan singkat cara sukses menanam stevia.<br>
<b>1. Persiapan Lahan dan Bibit</b><br>
<ul>
    <li><b>Pemilihan Lahan:</b> Stevia tumbuh optimal di lahan yang subur, gembur, dan memiliki drainase yang sangat baik. Tanaman ini tidak tahan genangan air. Kisaran pH tanah yang ideal adalah 6.5 - 7.5. Pastikan lahan mendapatkan paparan sinar matahari yang cukup.</li>
    <li><b>Persiapan Bibit:</b> Bibit stevia paling umum diperbanyak secara vegetatif melalui <i>stek</i> (potongan batang). Ambil potongan batang dari tanaman induk yang sehat, lalu tanam di media semai hingga berakar sebelum dipindahkan ke lahan tanam utama. Perbanyakan dari biji kurang efektif karena biji stevia memiliki daya tumbuh yang rendah.</li>
    <li><b>Penanaman Bibit:</b> Pindahkan bibit stevia yang sudah kuat ke lahan tanam dengan jarak yang ideal (umumnya sekitar 30-45 cm antar tanaman).</li>
</ul>
<b>2. Pemeliharaan Tanaman Stevia</b><br>
<ul>
    <li><b>Pengairan:</b> Stevia membutuhkan air yang cukup dan konsisten, terutama pada fase awal pertumbuhan. Namun, hindari penyiraman berlebihan yang bisa menyebabkan media tanam terlalu basah.</li>
    <li><b>Pemupukan:</b> Berikan pupuk organik seperti kompos atau pupuk kandang untuk menjaga kesuburan tanah. Pada fase pertumbuhan, pemupukan tambahan dengan pupuk NPK dapat mendukung pertumbuhan daun.</li>
    <li><b>Penyiangan:</b> Lakukan penyiangan secara rutin untuk membersihkan gulma yang dapat merebut nutrisi dari tanaman stevia.</li>
    <li><b>Pemangkasan (<i>Pruning</i>):</b> Ini adalah tahap penting untuk meningkatkan hasil panen. Lakukan pemangkasan pada bagian atas tanaman untuk mendorong pertumbuhan tunas-tunas baru dari samping. Semakin banyak cabang, semakin banyak daun yang bisa dipanen.</li>
</ul>
<b>3. Panen dan Pascapanen</b><br>
<ul>
    <li><b>Panen:</b> Panen daun stevia dapat dilakukan secara berulang. Pemanenan terbaik dilakukan sebelum tanaman mulai berbunga, karena pada saat itu kandungan stevioside (senyawa yang memberikan rasa manis) berada di puncaknya. Petik daun-daun yang sudah tua, biasanya pada bagian atas dan tengah tanaman.</li>
    <li><b>Pascapanen (Pengeringan):</b> Segera setelah dipanen, daun stevia harus dikeringkan untuk mempertahankan kualitas dan rasa manisnya.
        <ul>
            <li><b>Pengeringan Alami:</b> Keringkan daun dengan cara diangin-anginkan di tempat teduh. Hindari menjemur langsung di bawah sinar matahari karena dapat merusak senyawa pemanis dan mengurangi kualitasnya.</li>
            <li><b>Pengeringan Oven:</b> Gunakan oven atau pengering makanan (<i>food dehydrator</i>) pada suhu rendah (sekitar 40-50°C) hingga daun benar-benar kering dan rapuh.</li>
        </ul>
    </li>
    <li><b>Penyimpanan:</b> Simpan daun stevia kering dalam wadah kedap udara untuk menjaga kualitasnya.</li>
</ul>
Dengan budidaya yang tepat, pemangkasan yang rutin, dan proses panen serta pengeringan yang cermat, petani dapat memaksimalkan potensi hasil dan rasa manis dari daun stevia.
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'headline' => 'Panduan Singkat Budidaya Biji Wijen',
                'image' => 'Budidaya-Wijen.png',
                'image2' => 'Biji Wijen.png',
                'body' => <<<HTML
<b>Wijen</b> adalah tanaman penghasil minyak yang membutuhkan teknik budidaya khusus. Keberhasilan panen wijen sangat ditentukan oleh manajemen yang cermat dari awal hingga akhir.<br><br>
<b>1. Persiapan Tanam:</b><br>
<ul>
    <li>Gunakan benih wijen unggul bersertifikat.</li>
    <li>Tanam di lahan yang gembur dan memiliki drainase yang baik, dengan kedalaman tanam 1-2 cm.</li>
</ul>
<b>2. Pemeliharaan:</b><br>
<ul>
    <li>Lakukan penjarangan (menghilangkan beberapa tanaman) untuk menjaga jarak ideal.</li>
    <li>Bersihkan gulma secara rutin.</li>
    <li>Berikan air yang cukup, terutama saat fase pembungaan dan pengisian polong, namun hindari genangan air.</li>
</ul>
<b>3. Panen dan Pascapanen:</b><br>
<ul>
    <li>Panen dilakukan saat daun bawah mulai menguning dan polong pecah, karena polong tidak matang serentak.</li>
    <li>Setelah dipanen, ikat batang tanaman dan jemur di tempat yang teduh.</li>
    <li>Setelah kering, biji wijen dirontokkan dengan cara diguncangkan, lalu dibersihkan dari kotoran.</li>
</ul>
Dengan pemilihan benih yang tepat dan panen yang cermat, budidaya biji wijen dapat menghasilkan panen yang optimal dan berkualitas tinggi.
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}