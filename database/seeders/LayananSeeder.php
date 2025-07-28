<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\Layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barbers = Barber::all();

        $jenisLayanan = [
            [
                'nama' => 'Cukur Rambut',
                'deskripsi' => 'Pelayanan cukur rambut dengan alat profesional',
                'harga' => 25000,
                'durasi' => 20,
            ],
            [
                'nama' => 'Pangkas Jenggot',
                'deskripsi' => 'Pangkas dan rapihkan jenggot dengan gaya terkini',
                'harga' => 20000,
                'durasi' => 15,
            ],
            [
                'nama' => 'Cuci Rambut',
                'deskripsi' => 'Cuci rambut dengan shampoo dan kondisioner premium',
                'harga' => 15000,
                'durasi' => 15,
            ],
            [
                'nama' => 'Pijat Kepala',
                'deskripsi' => 'Pijat kepala relaksasi untuk menghilangkan stres',
                'harga' => 25000,
                'durasi' => 20,
            ],
            [
                'nama' => 'Pangkas + Cuci',
                'deskripsi' => 'Paket pangkas rambut dan cuci rambut',
                'harga' => 35000,
                'durasi' => 35,
            ],
            [
                'nama' => 'Styling Rambut',
                'deskripsi' => 'Styling rambut dengan produk terbaik',
                'harga' => 30000,
                'durasi' => 25,
            ],
        ];

        foreach ($barbers as $barber) {
            foreach ($jenisLayanan as $layanan) {
                Layanan::create(array_merge($layanan, [
                    'barber_id' => $barber->id,
                    'is_active' => true,
                ]));
            }
        }
    }
}
