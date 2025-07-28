<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'harga' => 'decimal:2',
        'durasi' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relasi
    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class);
    }
}
