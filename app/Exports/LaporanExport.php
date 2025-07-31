<?php

namespace App\Exports;

use App\Models\Pemesanan;
use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Auth;

class LaporanExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $dariTanggal;
    protected $sampaiTanggal;
    protected $jenisLaporan;
    protected $barberId;

    public function __construct($dariTanggal, $sampaiTanggal, $jenisLaporan, $barberId)
    {
        $this->dariTanggal = $dariTanggal;
        $this->sampaiTanggal = $sampaiTanggal;
        $this->jenisLaporan = $jenisLaporan;
        $this->barberId = $barberId;
    }

    public function view(): View
    {
        $data = collect();
        $judul = '';

        if ($this->jenisLaporan == 'pemesanan') {
            $judul = 'Data Pemesanan Selesai';
            $data = Pemesanan::with(['user', 'layanan'])
                ->where('barber_id', $this->barberId)
                ->where('status', 'selesai')
                ->whereDate('created_at', '>=', $this->dariTanggal)
                ->whereDate('created_at', '<=', $this->sampaiTanggal)
                ->orderBy('created_at', 'ASC')
                ->get();
        } elseif ($this->jenisLaporan == 'keuangan') {
            $judul = 'Data Transaksi (Pendapatan)';
            $data = Transaksi::with(['pemesanan.layanan', 'user', 'pemesanan.user'])
                ->whereHas('pemesanan', function ($q) {
                    $q->where('barber_id', $this->barberId)
                        ->where('status', 'selesai');
                })
                ->where('status_pembayaran', 'dibayar')
                ->whereDate('created_at', '>=', $this->dariTanggal)
                ->whereDate('created_at', '<=', $this->sampaiTanggal)
                ->orderBy('created_at', 'ASC')
                ->get();
        }

        return view('admin-barber.laporan.excel', [
            'data' => $data,
            'judul' => $judul,
            'dariTanggal' => $this->dariTanggal,
            'sampaiTanggal' => $this->sampaiTanggal,
            'jenisLaporan' => $this->jenisLaporan
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold
            1    => ['font' => ['bold' => true]],
        ];
    }
}
