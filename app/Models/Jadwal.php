<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $appends = ['nama_hari'];

    protected $casts = [
        'hari_kerja' => 'boolean',
        'maksimum_pelanggan_per_jam' => 'integer',
    ];

    // Relasi
    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function getNamaHariAttribute()
    {
        $hariIndonesia = [
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu',
        ];

        return $hariIndonesia[$this->hari_dalam_minggu] ?? ucfirst($this->hari_dalam_minggu);
    }
}
