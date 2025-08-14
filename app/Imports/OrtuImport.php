<?php

namespace App\Imports;

use App\Models\Ortu;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrtuImport implements ToModel, WithHeadingRow
{
    public $successCount = 0;
    public $skippedCount = 0;

    public function model(array $row)
    {
        $siswa = Siswa::where('nisn', $row['nisn'])->first();

        if (!$siswa) {
            $this->skippedCount++;
            return null;
        }

        $user = User::create([
            'name'     => $row['nama_wali'],
            'username' => strtolower(str_replace(' ', '_', $row['nama_wali'])) . random_int(10, 200),
            'email'    => strtolower(str_replace(' ', '', $row['nama_wali'])) . random_int(10, 200) . '@ortu.com',
            'password' => Hash::make($row['password'] ?? '12345678'),
            'role'     => 'ortu',
            'status'   => true,
        ]);

        Ortu::create([
            'user_id'       => $user->id,
            'siswa_id'      => $siswa->id,
            'nama_wali'     => $row['nama_wali'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'no_hp'         => $row['no_hp'],
            'alamat'        => $row['alamat'],
        ]);

        $this->successCount++;
    }
}
