<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Aplikasi;
use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\Halaman;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Menu;
use App\Models\Ortu;
use App\Models\Pelajaran;
use App\Models\Pengumuman;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $this->call([
            UserSeeder::class,
        ]);

        // Buat tahun ajaran aktif
        TahunAjaran::create([
            'tahun_ajaran' => '2023/2024',
            'semester' => 'Ganjil',
            'status' => false
        ]);
        TahunAjaran::create([
            'tahun_ajaran' => '2023/2024',
            'semester' => 'Genap',
            'status' => false
        ]);
        TahunAjaran::create([
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Ganjil',
            'status' => false
        ]);
        TahunAjaran::create([
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Genap',
            'status' => false
        ]);
        TahunAjaran::create([
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Ganjil',
            'status' => true
        ]);
        TahunAjaran::create([
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Genap',
            'status' => false
        ]);

        // Tahun ajaran lain
        TahunAjaran::factory(2)->create();

        // Buat kelas
        // Kelas::factory(15)->create();
        Kelas::updateOrCreate([
            'nama_kelas' => '7A',
        ]);
        Kelas::updateOrCreate([
            'nama_kelas' => '7B',
        ]);
        Kelas::updateOrCreate([
            'nama_kelas' => '7C',
        ]);
        Kelas::updateOrCreate([
            'nama_kelas' => '8A',
        ]);
        Kelas::updateOrCreate([
            'nama_kelas' => '8B',
        ]);
        Kelas::updateOrCreate([
            'nama_kelas' => '8C',
        ]);
        Kelas::updateOrCreate([
            'nama_kelas' => '9A',
        ]);
        Kelas::updateOrCreate([
            'nama_kelas' => '9B',
        ]);
        Kelas::updateOrCreate([
            'nama_kelas' => '9C',
        ]);

        // Buat pelajaran
        // Pelajaran::factory(11)->create();
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Ilmu Pengetahuan Sosial (IPS)',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Bahasa Indonesia',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Informatika',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Seni, Budaya dan Prakarya',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Pendidikan Pancasila',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Pendidikan Agama Islam dan Budi Pekerti',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Matematika (Umum)',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Ilmu Pengetahuan Alam (IPA)',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Project Penguatan Profil Pelajar Pancasila',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Bahasa Inggris',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Muatan Lokal Potensi Daerah',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Bimbingan dan Konseling/Konselor (BP/BK)',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Kearifan Lokal',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Gaya Hidup Berkelanjutan',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Suara Demokrasi',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Bangunlah Jiwa dan Raganya',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Rekayasa dan Teknologi',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Bhineka Tunggal Ika',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Seni dan Budaya',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Prakarya',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Pendidikan Pancasila dan Kewarganegaraan',
        ]);
        Pelajaran::updateOrCreate([
            'nama_mapel' => 'Teknologi Informasi dan Komunikasi',
        ]);

        // // Buat guru
        // $gurus = Guru::factory(5)->create();

        // // Hubungkan guru ke user
        // foreach ($gurus as $guru) {
        //     $user = User::create([
        //         'name' => $guru->nama_lengkap,
        //         'username' => strtolower(str_replace(' ', '_', $guru->nama_lengkap)) . random_int(10, 99),
        //         'email' => strtolower(str_replace(' ', '', $guru->nama_lengkap)) . '@guru.com',
        //         'email_verified_at' => now(),
        //         'password' => Hash::make('12345678'),
        //         'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
        //         'role' => 'guru',
        //         'status' => '1',
        //         'remember_token' => Str::random(10),
        //         'created_at' => now(),
        //     ]);
        //     $guru->update(['user_id' => $user->id]);

        //     // Set guru mengajar 1-2 pelajaran di 1-2 kelas
        //     $kelasRand = $kelas->random(rand(1, 2));
        //     $pelajaranRand = $pelajaran->random(rand(1, 2));

        //     foreach ($kelasRand as $k) {
        //         foreach ($pelajaranRand as $p) {
        //             GuruMapel::create([
        //                 'guru_id' => $guru->id,
        //                 'pelajaran_id' => $p->id,
        //                 'kelas_id' => $k->id,
        //                 'tahun_ajaran_id' => $tahunAktif->id,
        //                 'hari' => $faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']),
        //                 'mulai' => '07:00',
        //                 'selesai' => '09:00',
        //             ]);
        //         }
        //     }
        // }

        // // Buat siswa
        // $siswas = Siswa::factory(10)->create();

        // // Buat ortu & hubungkan
        // foreach ($siswas as $siswa) {
        //     $ortu = Ortu::factory()->create(['siswa_id' => $siswa->id]);

        //     $user = User::create([
        //         'name' => $ortu->nama_wali,
        //         'username' => strtolower(str_replace(' ', '_', $ortu->nama_wali)) . random_int(10, 99),
        //         'email' => strtolower(str_replace(' ', '', $ortu->nama_wali)) . '@ortu.com',
        //         'email_verified_at' => now(),
        //         'password' => Hash::make('12345678'),
        //         'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
        //         'role' => 'ortu',
        //         'status' => '1',
        //         'remember_token' => Str::random(10),
        //         'created_at' => now(),
        //     ]);
        //     $ortu->update(['user_id' => $user->id]);

        //     // Masukkan siswa ke kelas
        //     $kelasPilih = $kelas->random();
        //     KelasSiswa::create([
        //         'siswa_id' => $siswa->id,
        //         'kelas_id' => $kelasPilih->id,
        //         'tahun_ajaran_id' => $tahunAktif->id
        //     ]);
        // }

        Aplikasi::updateOrCreate([
            'nama_lembaga' => 'SMP Negeri 9 Buton',
            'telepon' => '(0402) 021423',
            'fax' => '(0402) 021423',
            'email' => 'smpnegeri9buton@gmail.com',
            'alamat' => 'Jl. Poros Pasar Wajo Kel. Wasaga, Kec. Ps. Wajo, Kabupaten Buton, Sulawesi Tenggara 93754',
            'maps' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d508541.2595195183!2d122.9177856!3d-5.2660079!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2da4091475e56ac3%3A0x10d425c2692ddd5e!2sSMP%20Negeri%209%20Pasar%20Wajo!5e0!3m2!1sid!2sid!4v1754392394825!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'nama_ketua' => 'Kamarudin',
            'sidebar_lg' => 'PKPS',
            'sidebar_mini' => 'PKPS',
            'title_header' => 'Sistem Informasi Pelaporan Kehadiran dan Perilaku',
            'logo' => 'aplikasi-images/smp.png',
        ]);
    }
}
