<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jumlah' => $this->faker->randomElement([25000, 30000, 35000, 40000, 45000, 50000]),
            'metode_pembayaran' => $this->faker->randomElement(['tunai', 'transfer', 'dompet_elektronik']),
            'status_pembayaran' => $this->faker->randomElement(['menunggu', 'dibayar', 'gagal']),
            'referensi_pembayaran' => $this->faker->optional()->uuid(),
            'tanggal_pembayaran' => $this->faker->optional()->dateTimeThisMonth(),
        ];
    }

    /**
     * Transaksi menunggu pembayaran
     */
    public function menunggu(): static
    {
        return $this->state(fn(array $attributes) => [
            'status_pembayaran' => 'menunggu',
            'tanggal_pembayaran' => null,
        ]);
    }

    /**
     * Transaksi sudah dibayar
     */
    public function dibayar(): static
    {
        return $this->state(fn(array $attributes) => [
            'status_pembayaran' => 'dibayar',
            'tanggal_pembayaran' => now(),
        ]);
    }

    /**
     * Transaksi gagal
     */
    public function gagal(): static
    {
        return $this->state(fn(array $attributes) => [
            'status_pembayaran' => 'gagal',
        ]);
    }
}
