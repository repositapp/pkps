<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Aplikasi;
use App\Models\Halaman;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@themesbrand.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
            'role' => 'admin',
            'status' => '1',
            'created_at' => now(),
        ]);
        User::updateOrCreate([
            'name' => 'Pelanggan',
            'username' => 'pelanggan',
            'email' => 'pelanggan@themesbrand.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
            'role' => 'pelanggan',
            'status' => '1',
            'created_at' => now(),
        ]);
        User::factory(29)->create();

        Aplikasi::updateOrCreate([
            'nama_lembaga' => 'Perusahaan Umum Daerah Air Minum Tirta Takawa',
            'telepon' => '(0402) 2032',
            'fax' => '(0402) 2032',
            'email' => 'pdam@gmail.com',
            'alamat' => 'Jl. Poros Lamena, Inulu, Mawasangka Tim., Kabupaten Buton, Sulawesi Tenggara 93762',
            'maps' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127108.11684361269!2d122.4583863!3d-5.3973616!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2da3871845a1de17%3A0xf2b73e8f9f4f49f0!2sKantor%20PDAM%20KABUPATEN%20BUTON%20TENGAH!5e0!3m2!1sid!2sid!4v1753603305354!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'nama_ketua' => 'Hanaruddin, S.Sos., M.Si.',
            'sidebar_lg' => 'PDAM BUTON',
            'sidebar_mini' => 'PB',
            'title_header' => 'Sistem Informasi PDAM Tirta Takawa Kabupaten Buton',
            'logo' => 'aplikasi-images/baznas.png',
        ]);

        Kategori::create([
            'name' => 'Umum',
            'slug' => 'umum',
        ]);
        Kategori::create([
            'name' => 'Teknologi',
            'slug' => 'teknologi',
        ]);
        Kategori::create([
            'name' => 'Prestasi Dan Inovasi',
            'slug' => 'prestasi-dan-inovasi',
        ]);
        Kategori::create([
            'name' => 'Ekonomi',
            'slug' => 'ekonomi',
        ]);
        Kategori::create([
            'name' => 'Olahraga',
            'slug' => 'olahraga',
        ]);
        Kategori::create([
            'name' => 'Kriminal',
            'slug' => 'kriminal',
        ]);
        Kategori::create([
            'name' => 'Sosial Kemasyarakatan',
            'slug' => 'sosial-kemasyarakatan',
        ]);
        Kategori::create([
            'name' => 'Pendidikan',
            'slug' => 'pendidikan',
        ]);
        Kategori::create([
            'name' => 'Kesehatan',
            'slug' => 'kesehatan',
        ]);
        Kategori::create([
            'name' => 'Bencana',
            'slug' => 'bencana',
        ]);
        Kategori::create([
            'name' => 'Hiburan',
            'slug' => 'hiburan',
        ]);

        Pengumuman::factory(100)->create();

        Halaman::create([
            'user_id' => 1,
            'judul' => 'Tentang Perusahaan Umum Daerah Air Minum (PERUMDA) Tirta Takawa Kabupaten Buton',
            'slug' => 'tentang-perusahaan-umum-daerah-air-minum-perumda-tirta-takawa-kabupaten-buton',
            'konten' => '<p style="text-align: justify;" data-start="151" data-end="770"><strong data-start="151" data-end="226">Perusahaan Umum Daerah Air Minum (PERUMDA) Tirta Takawa Kabupaten Buton</strong> merupakan Badan Usaha Milik Daerah (BUMD) yang bergerak di bidang penyediaan layanan air bersih bagi masyarakat di wilayah Kabupaten Buton dan sekitarnya. Berdasarkan Peraturan Daerah Kabupaten Buton Nomor 3 Tahun 2021, perusahaan ini mengalami transformasi dari PDAM menjadi PERUMDA guna memperkuat legalitas, fleksibilitas bisnis, dan peningkatan tata kelola. Perubahan ini juga menjadi tonggak komitmen Pemerintah Daerah Kabupaten Buton untuk menghadirkan pelayanan publik yang profesional, akuntabel, dan berkelanjutan di sektor air minum.</p>
                        <p style="text-align: justify;" data-start="772" data-end="1308">Seiring perubahan kelembagaan, PERUMDA Tirta Takawa terus melakukan pembenahan internal. Saat ini perusahaan dipimpin oleh Direktur Utama Usman, S.AP., M.Si yang dilantik secara definitif untuk masa jabatan 2025&ndash;2029. Di bawah kepemimpinannya, manajemen menandatangani pakta integritas dan mengusung semangat reformasi birokrasi untuk meningkatkan efisiensi, memperbaiki sistem pelayanan, serta mendorong transformasi digital. Seluruh jajaran diarahkan untuk bekerja secara profesional, transparan, dan mengedepankan kepuasan pelanggan.</p>
                        <p style="text-align: justify;" data-start="1310" data-end="1941">Dari sisi operasional, PERUMDA Tirta Takawa memiliki jaringan distribusi yang menjangkau sebagian besar wilayah Kabupaten Buton, termasuk Kecamatan Pasarwajo yang menjadi lokasi kantor pusat baru sejak Juni 2024. Sumber air utama berasal dari mata air di Desa Kancina dan Wakoko. Namun, tantangan besar dihadapi ketika memasuki musim hujan, karena air baku menjadi keruh sehingga menyebabkan terganggunya distribusi. Untuk mengatasi hal tersebut, manajemen telah merancang pembangunan Instalasi Pengolahan Air (IPA) senilai Rp50&ndash;70 miliar yang direncanakan bekerja sama dengan pemerintah pusat dan mitra internasional seperti SUEZ.</p>
                        <p style="text-align: justify;" data-start="1943" data-end="2479">Dari segi kinerja, PERUMDA Tirta Takawa tergolong perusahaan air minum daerah yang sehat. Berdasarkan audit Badan Pengawasan Keuangan dan Pembangunan (BPKP) Sulawesi Tenggara untuk tahun 2021, perusahaan ini dinilai memiliki manajemen keuangan dan pelayanan pelanggan yang baik. Jumlah pelanggan yang tercatat hingga tahun 2023 mencapai hampir 20.000 sambungan rumah. Pada tahun 2023, dilakukan penyesuaian tarif air minum pertama kali setelah tujuh tahun, untuk menyesuaikan dengan kenaikan biaya operasional, listrik, dan bahan bakar.</p>
                        <p style="text-align: justify;" data-start="2481" data-end="3100">Ke depan, PERUMDA Tirta Takawa menetapkan sejumlah agenda strategis, seperti perluasan cakupan pelayanan ke wilayah Buton Tengah dan Buton Selatan, digitalisasi layanan pelanggan berbasis aplikasi, serta program sambungan air bersih gratis untuk rumah ibadah dan warga tidak mampu. Dengan visi menjadi perusahaan air minum yang unggul dan mandiri, Tirta Takawa terus berbenah untuk menjawab tantangan pelayanan publik yang berkualitas, adil, dan merata. Dukungan dari pemerintah daerah dan kepercayaan pelanggan menjadi modal penting untuk menjadikan perusahaan ini sebagai salah satu BUMD terbaik di Sulawesi Tenggara.</p>',
            'status' => 1,
        ]);

        Halaman::create([
            'user_id' => 1,
            'judul' => 'Visi Misi',
            'slug' => 'visi-misi',
            'konten' => '<h3 data-start="266" data-end="278"><strong>Visi</strong></h3>
                        <blockquote data-start="796" data-end="980">
                        <p data-start="798" data-end="980"><em data-start="798" data-end="980">Menjadi perusahaan air minum yang mandiri, profesional, dan unggul dalam memberikan layanan air bersih yang berkualitas dan berkelanjutan di wilayah Kabupaten Buton dan sekitarnya.</em></p>
                        </blockquote>
                        <h3 data-start="934" data-end="946"><strong data-start="938" data-end="946">Misi</strong></h3>
                        <ol>
                        <li data-start="999" data-end="1082">
                        <p data-start="1002" data-end="1082">Meningkatkan cakupan dan kualitas layanan distribusi air bersih bagi masyarakat.</p>
                        </li>
                        <li data-start="1083" data-end="1146">
                        <p data-start="1086" data-end="1146">Menyediakan layanan pelanggan yang transparan dan responsif.</p>
                        </li>
                        <li data-start="1147" data-end="1212">
                        <p data-start="1150" data-end="1212">Membangun manajemen perusahaan yang profesional dan akuntabel.</p>
                        </li>
                        <li data-start="1213" data-end="1280">
                        <p data-start="1216" data-end="1280">Mengembangkan sistem keuangan perusahaan yang sehat dan efisien.</p>
                        </li>
                        <li data-start="1281" data-end="1392">
                        <p data-start="1284" data-end="1392">Menjalin kemitraan strategis dengan pemerintah, swasta, dan masyarakat dalam pengembangan sektor air bersih.</p>
                        </li>
                        </ol>',
            'status' => 1,
        ]);

        Halaman::create([
            'user_id' => 1,
            'judul' => 'Tujuan Stategis',
            'slug' => 'tujuan-stategis',
            'konten' => '<h4 style="text-align: justify;" data-start="216" data-end="273">1. <strong data-start="224" data-end="273">Meningkatkan Aksesibilitas Layanan Air Bersih</strong></h4>
                        <p style="text-align: justify;" data-start="274" data-end="705">Tujuan ini menekankan pada perluasan cakupan layanan air minum ke seluruh wilayah Kabupaten Buton, termasuk daerah-daerah yang selama ini belum terjangkau jaringan pipa distribusi. Upaya ini mencakup pembangunan jaringan baru, optimalisasi sambungan rumah, serta integrasi sistem suplai air antar wilayah. Dengan meningkatnya aksesibilitas, masyarakat akan memperoleh hak dasar atas air bersih sebagai bagian dari pelayanan publik.</p>
                        <h4 style="text-align: justify;" data-start="712" data-end="770">2. <strong data-start="720" data-end="770">Menjamin Kualitas dan Keberlanjutan Sumber Air</strong></h4>
                        <p style="text-align: justify;" data-start="771" data-end="1155">Untuk memastikan kelayakan air yang didistribusikan, perusahaan menargetkan pembangunan Instalasi Pengolahan Air (IPA) yang modern serta pengelolaan sumber air baku secara berkelanjutan. Tujuan ini juga mencakup peningkatan kualitas air sesuai standar Kementerian Kesehatan, penanganan air keruh saat musim hujan, dan perlindungan mata air dari pencemaran atau eksploitasi berlebihan.</p>
                        <h4 style="text-align: justify;" data-start="1162" data-end="1237">3. <strong data-start="1170" data-end="1237">Mewujudkan Tata Kelola Perusahaan yang Transparan dan Akuntabel</strong></h4>
                        <p style="text-align: justify;" data-start="1238" data-end="1615">Tujuan ini mengarah pada pembentukan sistem manajemen perusahaan yang berbasis prinsip good corporate governance (GCG), yaitu transparansi, akuntabilitas, dan partisipasi. Implementasinya mencakup digitalisasi pelayanan pelanggan, pelaporan keuangan yang tertib, sistem pengaduan yang responsif, serta komitmen terhadap pakta integritas oleh seluruh jajaran manajemen dan staf.</p>
                        <h4 style="text-align: justify;" data-start="1622" data-end="1692">4. <strong data-start="1630" data-end="1692">Meningkatkan Efisiensi dan Kemandirian Keuangan Perusahaan</strong></h4>
                        <p style="text-align: justify;" data-start="1693" data-end="2086">PERUMDA Tirta Takawa menargetkan penguatan struktur pendapatan dan pengelolaan biaya operasional secara efisien. Tujuan ini akan dicapai melalui optimalisasi pendapatan pelanggan, pembaruan sistem billing, pengendalian kebocoran air (non-revenue water), serta pengurangan ketergantungan terhadap subsidi APBD. Dengan demikian, perusahaan dapat tumbuh secara mandiri dan sehat secara finansial.</p>
                        <h4 style="text-align: justify;" data-start="2093" data-end="2152">5. <strong data-start="2101" data-end="2152">Meningkatkan Kepuasan dan Kepercayaan Pelanggan</strong></h4>
                        <p style="text-align: justify;" data-start="2153" data-end="2577">Fokus pada kepuasan pelanggan menjadi prioritas strategis yang diwujudkan melalui pelayanan yang cepat, tanggap, dan mudah diakses. Melalui penguatan unit layanan pelanggan, peluncuran aplikasi aduan berbasis digital, edukasi pelanggan, serta komunikasi aktif melalui media sosial dan kanal resmi, perusahaan ingin membangun citra sebagai penyedia layanan air bersih yang terpercaya dan peduli terhadap kebutuhan masyarakat.</p>',
            'status' => 1,
        ]);

        Halaman::create([
            'user_id' => 1,
            'judul' => 'Tugas Pokok dan Fungsi',
            'slug' => 'tugas-pokok-dan-fungsi',
            'konten' => '<h3 style="text-align: justify;" data-start="1246" data-end="1268"><strong data-start="1250" data-end="1268">A. Tugas Pokok</strong></h3>
                        <p style="text-align: justify;" data-start="1270" data-end="1316">PERUMDA Tirta Takawa memiliki tugas pokok:</p>
                        <blockquote data-start="1318" data-end="1429">
                        <p style="text-align: left;" data-start="1320" data-end="1429"><strong data-start="1320" data-end="1429">"Menyelenggarakan pelayanan umum di bidang penyediaan dan pendistribusian air minum yang sehat, layak, dan berkelanjutan kepada masyarakat, serta menjalankan usaha secara profesional guna meningkatkan Pendapatan Asli Daerah (PAD)."</strong></p>
                        </blockquote>
                        <p style="text-align: justify;" data-start="1431" data-end="1608">Tugas pokok ini menempatkan Perumda Tirta Takawa sebagai institusi publik sekaligus entitas bisnis daerah. Sebagai penyelenggara pelayanan publik, perusahaan bertanggung jawab menyediakan air bersih bagi masyarakat Kabupaten Buton. Di sisi lain, sebagai BUMD, perusahaan memiliki kewajiban untuk menghasilkan pendapatan dan dikelola secara profesional agar berkontribusi terhadap perekonomian daerah.</p>
                        <h3 data-start="1615" data-end="1632"><strong data-start="1619" data-end="1632">B. Fungsi</strong></h3>
                        <h4 data-start="989" data-end="1037">1. <strong data-start="997" data-end="1037">Penyediaan dan Pengelolaan Air Minum</strong></h4>
                        <blockquote data-start="1038" data-end="1176">
                        <p data-start="1040" data-end="1176">Menyediakan air minum yang memenuhi standar kualitas dan kuantitas melalui pengambilan, pengolahan, dan distribusi air kepada pelanggan.</p>
                        </blockquote>
                        <p data-start="1178" data-end="1424">Fungsi ini mencakup kegiatan teknis seperti pemanfaatan mata air baku (seperti dari Kancina dan Wakoko), pembangunan jaringan distribusi, serta pengelolaan Instalasi Pengolahan Air (IPA) untuk memastikan kualitas air layak konsumsi.</p>
                        <hr data-start="1426" data-end="1429">
                        <h4 data-start="1431" data-end="1482">2. <strong data-start="1439" data-end="1482">Pelayanan Publik dan Kepuasan Pelanggan</strong></h4>
                        <blockquote data-start="1483" data-end="1585">
                        <p data-start="1485" data-end="1585">Memberikan layanan yang adil, mudah diakses, dan tanggap terhadap kebutuhan serta keluhan pelanggan.</p>
                        </blockquote>
                        <p data-start="1587" data-end="1854">Perumda Tirta Takawa berfungsi sebagai penyedia layanan dasar, sehingga dituntut untuk menjaga hubungan baik dengan pelanggan, menyediakan informasi tagihan, sistem pengaduan yang responsif, dan pelayanan lapangan (perbaikan, sambungan baru) yang cepat.</p>
                        <hr data-start="1856" data-end="1859">
                        <h4 data-start="1861" data-end="1913">3. <strong data-start="1869" data-end="1913">Pengelolaan Keuangan dan Aset Perusahaan</strong></h4>
                        <blockquote data-start="1914" data-end="2019">
                        <p data-start="1916" data-end="2019">Mengelola keuangan, aset tetap, serta sumber daya perusahaan secara efisien, transparan, dan akuntabel.</p>
                        </blockquote>
                        <p data-start="2021" data-end="2260">Fungsi ini melibatkan pengaturan tarif, pembukuan keuangan, pengendalian biaya operasional, serta perencanaan investasi. Manajemen juga bertanggung jawab atas pelaporan keuangan berkala dan audit oleh inspektorat maupun BPKP.</p>
                        <hr data-start="2262" data-end="2265">
                        <h4 data-start="2267" data-end="2309">4. <strong data-start="2275" data-end="2309">Pengembangan Usaha dan Inovasi</strong></h4>
                        <blockquote data-start="2310" data-end="2439">
                        <p data-start="2312" data-end="2439">Melakukan inovasi dan perluasan usaha untuk meningkatkan cakupan pelayanan, efektivitas operasional, dan kemandirian finansial.</p>
                        </blockquote>
                        <p data-start="2441" data-end="2714">Fungsi ini mencakup perluasan jaringan ke wilayah baru (seperti Buton Tengah), penerapan sistem digital (billing online, aduan pelanggan), serta pengembangan usaha non-layanan seperti air curah, pengelolaan IPA kemitraan, atau layanan sambungan sosial gratis.</p>
                        <hr data-start="2716" data-end="2719">
                        <h4 data-start="2721" data-end="2781">5. <strong data-start="2729" data-end="2781">Pelaksanaan Tata Kelola dan SDM yang Profesional</strong></h4>
                        <blockquote data-start="2782" data-end="2935">
                        <p data-start="2784" data-end="2935">Membangun organisasi yang sehat dengan struktur kelembagaan jelas, sumber daya manusia (SDM) yang kompeten, serta sistem kerja yang berorientasi hasil.</p>
                        </blockquote>
                        <p data-start="2937" data-end="3167">Fungsi ini mengarahkan Perumda Tirta Takawa untuk menerapkan prinsip good corporate governance (GCG), menetapkan SOP layanan dan teknis, serta melakukan pelatihan, rotasi, dan evaluasi kinerja pegawai secara berkala.</p>',
            'status' => 1,
        ]);

        Halaman::create([
            'user_id' => 1,
            'judul' => 'Struktur Organisasi',
            'slug' => 'struktur-organisasi',
            'konten' => '<h4 data-start="1513" data-end="1545"><strong data-start="1524" data-end="1545">1. Dewan Pengawas</strong></h4>
                        <ul data-start="1546" data-end="1780">
                        <li data-start="1546" data-end="1672">
                        <p data-start="1548" data-end="1672"><strong data-start="1548" data-end="1558">Tugas:</strong> Mengawasi dan memberikan rekomendasi terhadap jalannya operasional perusahaan serta mengevaluasi kinerja Direksi.</p>
                        </li>
                        <li data-start="1673" data-end="1707">
                        <p data-start="1675" data-end="1707"><strong data-start="1675" data-end="1693">Diangkat oleh:</strong> Kepala Daerah</p>
                        </li>
                        <li data-start="1708" data-end="1780">
                        <p data-start="1710" data-end="1780"><strong data-start="1710" data-end="1724">Komposisi:</strong> Unsur profesional independen dan perwakilan pemerintah.</p>
                        </li>
                        </ul>
                        <hr data-start="1782" data-end="1785">
                        <h4 data-start="1787" data-end="1827"><strong data-start="1798" data-end="1827">2. Direktur Utama (Dirut)</strong></h4>
                        <ul data-start="1828" data-end="2031">
                        <li data-start="1828" data-end="1961">
                        <p data-start="1830" data-end="1961"><strong data-start="1830" data-end="1840">Tugas:</strong> Pemimpin eksekutif tertinggi perusahaan. Bertanggung jawab penuh terhadap operasional, keuangan, dan pengembangan usaha.</p>
                        </li>
                        <li data-start="1962" data-end="2031">
                        <p data-start="1964" data-end="2031"><strong data-start="1964" data-end="1990">Saat ini dijabat oleh:</strong> <em data-start="1991" data-end="2011">Usman, S.AP., M.Si</em> (periode 2025&ndash;2029)</p>
                        </li>
                        </ul>
                        <hr data-start="2033" data-end="2036">
                        <h4 data-start="2038" data-end="2094"><strong data-start="2046" data-end="2094">3. Bagian Administrasi &amp; Pelayanan Pelanggan</strong></h4>
                        <ul data-start="2095" data-end="2275">
                        <li data-start="2095" data-end="2194">
                        <p data-start="2097" data-end="2194">Mengelola data pelanggan, sambungan baru, pemutusan, pengaduan, serta sistem billing (penagihan).</p>
                        </li>
                        <li data-start="2195" data-end="2275">
                        <p data-start="2197" data-end="2275">Bertugas menjaga kepuasan pelanggan dan responsif terhadap keluhan masyarakat.</p>
                        </li>
                        </ul>
                        <hr data-start="2277" data-end="2280">
                        <h4 data-start="2282" data-end="2319"><strong data-start="2290" data-end="2319">4. Bagian Keuangan &amp; Aset</strong></h4>
                        <ul data-start="2320" data-end="2518">
                        <li data-start="2320" data-end="2418">
                        <p data-start="2322" data-end="2418">Mengelola keuangan perusahaan: budgeting, laporan keuangan, pembayaran gaji, dan pencatatan PAD.</p>
                        </li>
                        <li data-start="2419" data-end="2518">
                        <p data-start="2421" data-end="2518">Memonitor dan mencatat aset tetap, seperti kendaraan, pipa, instalasi air, serta bangunan kantor.</p>
                        </li>
                        </ul>
                        <hr data-start="2520" data-end="2523">
                        <h4 data-start="2525" data-end="2569"><strong data-start="2533" data-end="2569">5. Bagian Teknik Operasional Air</strong></h4>
                        <ul data-start="2570" data-end="2810">
                        <li data-start="2570" data-end="2756">
                        <p data-start="2572" data-end="2595">Bertanggung jawab atas:</p>
                        <ul data-start="2598" data-end="2756">
                        <li data-start="2598" data-end="2647">
                        <p data-start="2600" data-end="2647">Produksi air bersih (pengambilan dari mata air)</p>
                        </li>
                        <li data-start="2650" data-end="2682">
                        <p data-start="2652" data-end="2682">Pengolahan air (instalasi IPA)</p>
                        </li>
                        <li data-start="2685" data-end="2719">
                        <p data-start="2687" data-end="2719">Distribusi melalui jaringan pipa</p>
                        </li>
                        <li data-start="2722" data-end="2756">
                        <p data-start="2724" data-end="2756">Perawatan dan perbaikan jaringan</p>
                        </li>
                        </ul>
                        </li>
                        <li data-start="2757" data-end="2810">
                        <p data-start="2759" data-end="2810">Merespons gangguan teknis di lapangan secara cepat.</p>
                        </li>
                        </ul>
                        <hr data-start="2812" data-end="2815">
                        <h4 data-start="2817" data-end="2867"><strong data-start="2825" data-end="2867">6. Bagian Umum, Kepegawaian, dan Hukum</strong></h4>
                        <ul data-start="2868" data-end="3084">
                        <li data-start="2868" data-end="2933">
                        <p data-start="2870" data-end="2933">Mengelola kepegawaian (rekrutmen, evaluasi kinerja, pelatihan).</p>
                        </li>
                        <li data-start="2934" data-end="3007">
                        <p data-start="2936" data-end="3007">Menangani administrasi umum, tata usaha, serta urusan hukum perusahaan.</p>
                        </li>
                        <li data-start="3008" data-end="3084">
                        <p data-start="3010" data-end="3084">Menyusun SOP, regulasi internal, dan penyelesaian sengketa hukum jika ada.</p>
                        </li>
                        </ul>',
            'status' => 1,
        ]);

        Menu::create([
            'name' => 'Profil',
            'slug' => 'profil',
            'type' => 'halaman',
            'target_id' => null,
            'parent_id' => null,
            'order' => 1,
            'status' => 1,
        ]);
        Menu::create([
            'name' => 'Tentang',
            'slug' => 'tentang',
            'type' => 'halaman',
            'target_id' => 1,
            'parent_id' => 1,
            'order' => 1,
            'status' => 1,
        ]);
        Menu::create([
            'name' => 'Visi Misi',
            'slug' => 'visi-misi',
            'type' => 'halaman',
            'target_id' => 2,
            'parent_id' => 1,
            'order' => 2,
            'status' => 1,
        ]);
        Menu::create([
            'name' => 'Tujuan Stategis',
            'slug' => 'tujuan-strategis',
            'type' => 'halaman',
            'target_id' => 3,
            'parent_id' => 1,
            'order' => 3,
            'status' => 1,
        ]);
        Menu::create([
            'name' => 'Tugas Pokok & Fungsi',
            'slug' => 'tugas-pokok-&-fungsi',
            'type' => 'halaman',
            'target_id' => 4,
            'parent_id' => 1,
            'order' => 4,
            'status' => 1,
        ]);
        Menu::create([
            'name' => 'Struktur Organisasi',
            'slug' => 'struktur-organisasi',
            'type' => 'halaman',
            'target_id' => 5,
            'parent_id' => 1,
            'order' => 5,
            'status' => 1,
        ]);
        Menu::create([
            'name' => 'Pengumuman',
            'slug' => 'pengumuman',
            'type' => 'pengumuman',
            'target_id' => null,
            'parent_id' => null,
            'order' => 2,
            'status' => 1,
        ]);

        $this->call([
            PelangganSeeder::class,
            TagihanSeeder::class,
            PengaduanSeeder::class,
            PemasanganSeeder::class,
            PemutusanSeeder::class,
        ]);
    }
}
