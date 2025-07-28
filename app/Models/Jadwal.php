<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'hari_kerja' => 'boolean',
        'maksimum_pelanggan_per_jam' => 'integer',
    ];

    // Relasi
    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
