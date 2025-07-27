<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kegiatan;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::latest()->take(3)
            ->where('status', 1)
            ->get();

        return view('beranda.index', compact('pengumumans'));
    }
}
