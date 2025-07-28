<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dengan role admin_barber
        $adminBarbers = User::where('role', 'admin_barber')->get();

        foreach ($adminBarbers as $index => $admin) {
            Barber::create([
                'user_id' => $admin->id,
                'nama' => 'Barber ' . ($index + 1) . ' Baubau',
                'nama_pemilik' => $admin->name,
                'deskripsi' => 'Barber Shop terbaik di Kota Baubau dengan pelayanan profesional',
                'alamat' => 'Jl. Jenderal Sudirman No. ' . ($index + 1) . ', Baubau',
                'telepon' => '0812345678' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'email' => 'barber' . ($index + 1) . '@baubau.com',
                'gambar' => null,
                'waktu_buka' => '09:00:00',
                'waktu_tutup' => '20:00:00',
                'is_active' => true,
                'is_verified' => true,
            ]);
        }

        // Barber tambahan menggunakan factory
        Barber::factory(3)->create();
    }
}
