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
        $tahunAktif = TahunAjaran::create([
            'tahun_ajaran' => '2023/2024',
            'semester' => 'Ganjil',
            'status' => true
        ]);

        // Tahun ajaran lain
        TahunAjaran::factory(2)->create();

        // Buat kelas
        $kelas = Kelas::factory(15)->create();

        // Buat pelajaran
        $pelajaran = Pelajaran::factory(11)->create();

        // Buat guru
        $gurus = Guru::factory(5)->create();

        // Hubungkan guru ke user
        foreach ($gurus as $guru) {
            $user = User::create([
                'name' => $guru->nama_lengkap,
                'username' => strtolower(str_replace(' ', '_', $guru->nama_lengkap)) . random_int(10, 99),
                'email' => strtolower(str_replace(' ', '', $guru->nama_lengkap)) . '@guru.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
                'role' => 'guru',
                'status' => '1',
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ]);
            $guru->update(['user_id' => $user->id]);

            // Set guru mengajar 1-2 pelajaran di 1-2 kelas
            $kelasRand = $kelas->random(rand(1, 2));
            $pelajaranRand = $pelajaran->random(rand(1, 2));

            foreach ($kelasRand as $k) {
                foreach ($pelajaranRand as $p) {
                    GuruMapel::create([
                        'guru_id' => $guru->id,
                        'pelajaran_id' => $p->id,
                        'kelas_id' => $k->id,
                        'tahun_ajaran_id' => $tahunAktif->id,
                        'hari' => $faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']),
                        'mulai' => '07:00',
                        'selesai' => '09:00',
                    ]);
                }
            }
        }

        // Buat siswa
        $siswas = Siswa::factory(10)->create();

        // Buat ortu & hubungkan
        foreach ($siswas as $siswa) {
            $ortu = Ortu::factory()->create(['siswa_id' => $siswa->id]);

            $user = User::create([
                'name' => $ortu->nama_wali,
                'username' => strtolower(str_replace(' ', '_', $ortu->nama_wali)) . random_int(10, 99),
                'email' => strtolower(str_replace(' ', '', $ortu->nama_wali)) . '@ortu.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
                'role' => 'ortu',
                'status' => '1',
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ]);
            $ortu->update(['user_id' => $user->id]);

            // Masukkan siswa ke kelas
            $kelasPilih = $kelas->random();
            KelasSiswa::create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $kelasPilih->id,
                'tahun_ajaran_id' => $tahunAktif->id
            ]);
        }

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
