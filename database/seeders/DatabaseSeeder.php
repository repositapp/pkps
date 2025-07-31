<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Aplikasi;
use App\Models\Halaman;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BarberSeeder::class,
            LayananSeeder::class,
            JadwalSeeder::class,
            PemesananSeeder::class,
            AntrianSeeder::class,
            TransaksiSeeder::class,
        ]);

        Aplikasi::updateOrCreate([
            'nama_lembaga' => 'Komunitas Barber Kota Baubau',
            'telepon' => '081244547787',
            'fax' => '081244547787',
            'email' => 'barber@gmail.com',
            'alamat' => 'Jl. Wa Ode Wau, Kel. Lamangga, Kec. Murhum, Baubau, Sulawesi Tenggara 93713',
            'maps' => '<iframe src="https://www.google.com/maps/embed?pb=!1m12!1m8!1m3!1d15886.547005218941!2d122.5943561!3d-5.4719461!3m2!1i1024!2i768!4f13.1!2m1!1skomunitas%20barber%20baubau!5e0!3m2!1sid!2sid!4v1753710879985!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'nama_ketua' => 'Kamarudin',
            'sidebar_lg' => 'BARBER',
            'sidebar_mini' => 'KOB',
            'title_header' => 'Sistem Informasi Komunitas Barber Kota Baubau',
            'logo' => 'aplikasi-images/barber.png',
        ]);
    }
}
