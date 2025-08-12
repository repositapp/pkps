<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Perilaku;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perilaku>
 */
class PerilakuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Perilaku::class;

    public function definition()
    {
        return [
            'siswa_id' => Siswa::factory(),
            'kelas_id' => Kelas::factory(),
            'pelajaran_id' => Pelajaran::factory(),
            'tanggal' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'kategori_perilaku' => $this->faker->randomElement(['taat', 'disiplin', 'melanggar']),
            'catatan' => $this->faker->sentence(),
            'tahun_ajaran_id' => TahunAjaran::factory(),
        ];
    }
}
