<?php

namespace Database\Seeders;

use App\Models\Pemesanan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemesanans = Pemesanan::all();
        $users = User::all();

        foreach ($pemesanans as $pemesanan) {
            Transaksi::factory()->create([
                'pemesanan_id' => $pemesanan->id,
                'user_id' => $pemesanan->user_id,
                'jumlah' => $pemesanan->layanan->harga ?? 30000,
            ]);
        }

        // Transaksi tambahan
        Transaksi::factory(5)->create([
            'pemesanan_id' => Pemesanan::inRandomOrder()->first()->id,
            'user_id' => $users->where('role', 'pelanggan')->random()->id,
        ]);
    }
}
