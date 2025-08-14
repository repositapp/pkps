<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    public $successCount = 0;
    public $skippedCount = 0;

    public function model(array $row)
    {
        // Cek jika guru dengan NIP sudah ada → skip
        if (!empty($row['nip']) && Guru::where('nip', $row['nip'])->exists()) {
            $this->skippedCount++;
            return null;
        }

        // Buat akun user untuk guru
        $user = User::create([
            'name'     => $row['nama_lengkap'],
            'username' => strtolower(str_replace(' ', '_', $row['nama_lengkap'])) . random_int(10, 200),
            'email'    => strtolower(str_replace(' ', '', $row['nama_lengkap'])) . random_int(10, 200) . '@guru.com',
            'password' => Hash::make($row['password'] ?? '12345678'),
            'role'     => 'guru',
            'status'   => true,
        ]);

        // Simpan data guru
        Guru::create([
            'user_id'       => $user->id,
            'nama_lengkap'  => $row['nama_lengkap'],
            'nip'           => $row['nip'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'],
            'no_hp'         => $row['no_hp'] ?? null,
            'alamat'        => $row['alamat'] ?? null,
        ]);

        $this->successCount++;
    }
}
