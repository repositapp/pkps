<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_antrian' => 'date',
        'waktu_antrian' => 'datetime:H:i',
    ];

    // Relasi
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    // Scope
    public function scopeBerdasarkanTanggal($query, $tanggal)
    {
        return $query->where('tanggal_antrian', $tanggal);
    }

    public function scopeBerdasarkanStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
