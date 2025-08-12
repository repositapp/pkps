<?php

namespace Database\Seeders;

use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Perilaku;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsensiPerilakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Ambil data yang sudah ada
        $siswas = Siswa::all();
        $kelass = Kelas::all();
        $pelajarans = Pelajaran::all();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        // Jika tidak ada tahun ajaran aktif, gunakan yang pertama
        $tahunAjaran = $tahunAjaranAktif ?? TahunAjaran::first();

        if (!$siswas->count() || !$kelass->count() || !$pelajarans->count() || !$tahunAjaran) {
            $this->command->warn('Pastikan data Siswa, Kelas, Pelajaran, dan Tahun Ajaran sudah di-seed terlebih dahulu.');
            return;
        }

        // Buat data dummy kehadiran
        $this->command->info('Seeding Kehadiran...');
        foreach ($siswas as $siswa) {
            // Ambil kelas siswa dari relasi kelas_siswas
            $kelasSiswa = $siswa->kelasSiswas()->with('kelas')->first();
            $kelas = $kelasSiswa ? $kelasSiswa->kelas : $kelass->random();

            for ($i = 0; $i < rand(5, 15); $i++) {
                Kehadiran::create([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelas->id,
                    'pelajaran_id' => $pelajarans->random()->id,
                    'tanggal' => now()->subDays(rand(0, 30)),
                    'status_kehadiran' => $faker->randomElement(['hadir', 'izin', 'sakit', 'tidak_hadir']),
                    'keterangan' => in_array($faker->randomElement(['izin', 'sakit']), ['izin', 'sakit']) ? $faker->sentence(3) : null,
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ]);
            }
        }

        // Buat data dummy perilaku
        $this->command->info('Seeding Perilaku...');
        foreach ($siswas as $siswa) {
            $kelasSiswa = $siswa->kelasSiswas()->with('kelas')->first();
            $kelas = $kelasSiswa ? $kelasSiswa->kelas : $kelass->random();

            for ($i = 0; $i < rand(3, 10); $i++) {
                Perilaku::create([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelas->id,
                    'pelajaran_id' => $pelajarans->random()->id,
                    'tanggal' => now()->subDays(rand(0, 30)),
                    'kategori_perilaku' => $faker->randomElement(['taat', 'disiplin', 'melanggar']),
                    'catatan' => $faker->sentence(5),
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ]);
            }
        }

        $this->command->info('✅ Seeding Absensi & Perilaku berhasil!');
    }
}
