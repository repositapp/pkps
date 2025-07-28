<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_pemesanan' => 'date',
        'waktu_pemesanan' => 'datetime:H:i',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'pemesanan_id');
    }

    public function antrian()
    {
        return $this->hasOne(Antrian::class, 'pemesanan_id');
    }

    // Accessor untuk mendapatkan waktu lengkap
    public function getWaktuPemesananLengkapAttribute()
    {
        return $this->tanggal_pemesanan->format('Y-m-d') . ' ' . $this->waktu_pemesanan;
    }

    // Scope
    public function scopeBerdasarkanStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeMendatang($query)
    {
        return $query->where('tanggal_pemesanan', '>=', now()->toDateString())
            ->where('status', '!=', 'dibatalkan')
            ->orderBy('tanggal_pemesanan')
            ->orderBy('waktu_pemesanan');
    }
}
