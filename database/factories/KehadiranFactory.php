<?php

namespace Database\Factories;

use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kehadiran>
 */
class KehadiranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Kehadiran::class;

    public function definition()
    {
        return [
            'siswa_id' => Siswa::factory(),
            'kelas_id' => Kelas::factory(),
            'pelajaran_id' => Pelajaran::factory(),
            'tanggal' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status_kehadiran' => $this->faker->randomElement(['hadir', 'tidak_hadir', 'izin', 'sakit']),
            'keterangan' => $this->faker->sentence(),
            'tahun_ajaran_id' => TahunAjaran::factory(),
        ];
    }
}
