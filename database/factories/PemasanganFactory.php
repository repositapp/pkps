<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemasangan>
 */
class PemasanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggal_permohonan = $this->faker->dateTimeBetween('-6 months', 'now');
        $tanggal_penelitian = $this->faker->optional()->dateTimeBetween($tanggal_permohonan, '+1 week');
        $tanggal_bayar = ($tanggal_penelitian && $this->faker->boolean(70)) ?
            $this->faker->dateTimeBetween($tanggal_penelitian, '+2 weeks') : null;
        $status = 'pending';
        if ($tanggal_penelitian) $status = 'proses';
        if ($tanggal_bayar || $this->faker->boolean(50)) $status = $this->faker->randomElement(['disetujui', 'ditolak']);

        return [
            'pelanggan_id' => Pelanggan::factory(), // Membuat pelanggan baru jika belum ada
            'deskripsi' => $this->faker->sentence(),
            'lokasi' => $this->faker->latitude() . ',' . $this->faker->longitude(), // Format latitude,longitude
            'tanggal_permohonan' => $tanggal_permohonan->format('Y-m-d'),
            'tanggal_penelitian' => $tanggal_penelitian ? $tanggal_penelitian->format('Y-m-d') : null,
            'tanggal_bayar' => $tanggal_bayar ? $tanggal_bayar->format('Y-m-d') : null,
            'spk_tanggal' => $status === 'disetujui' ? $this->faker->optional()->date() : null,
            'spk_nomor' => $status === 'disetujui' ? '02/XII/SPKPI/PUDAM/' . $this->faker->year() : null,
            'ba_tanggal' => $status === 'disetujui' ? $this->faker->optional()->date() : null,
            'ba_nomor' => $status === 'disetujui' ? '02/XII/BAPIL/PUDAM/' . $this->faker->year() : null,
            'merek_meteran' => $status === 'disetujui' ? $this->faker->randomElement(['PANASONIC', 'SCHLUMBERGER', 'Itron']) : null,
            'kedudukan' => $this->faker->boolean() ? 1 : 0, // 0 atau 1
            'status_pembayaran' => $tanggal_bayar ? true : false,
            'status' => $status,
            'alasan_ditolak' => $status === 'ditolak' ? $this->faker->sentence() : null,
        ];
    }
}
