<?php

namespace App\Exports;

use App\Models\Pemutusan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PemutusanExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data['pemutusans'])->map(function ($pemutusan) {
            return [
                $pemutusan->pelanggan->nama_pelanggan,
                $pemutusan->pelanggan->alamat,
                $pemutusan->pelanggan->nomor_sambungan ?? '-',
                Carbon::parse($pemutusan->created_at)->format('d F Y'),
                'Rp ' . number_format($pemutusan->total_tagihan ?? 0, 2, ',', '.'),
                $pemutusan->deskripsi,
                $pemutusan->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'Alamat',
            'Nomor Sambungan',
            'Tanggal Permohonan',
            'Jumlah Tunggakan',
            'Alasan Pemutusan',
            'Status',
        ];
    }

    /**
     * @return array<class-string, \Closure>
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Header Laporan (Baris 1–5)
                $sheet->mergeCells('A1:G1')->setCellValue('A1', 'PEMERINTAH KABUPATEN BUTON');
                $sheet->mergeCells('A2:G2')->setCellValue('A2', 'PERUSAHAAN UMUM DAERAH AIR MINUM TIRTA TAKAWA');
                $sheet->mergeCells('A3:G3')->setCellValue('A3', 'Jl. Sultan Hasanuddin No. 42, Baubau, Buton Selatan');
                $sheet->mergeCells('A4:G4')->setCellValue('A4', 'LAPORAN PEMUTUSAN SAMBUNGAN');
                $sheet->mergeCells('A5:G5')->setCellValue('A5', 'BULAN ' . Carbon::now()->translatedFormat('F Y'));

                foreach (range(1, 5) as $row) {
                    $sheet->getStyle("A{$row}")->applyFromArray([
                        'font' => ['bold' => true],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    $sheet->getRowDimension($row)->setRowHeight(20);
                }

                // Heading kolom (baris ke-6)
                $sheet->getStyle('A6:G6')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Baris tanda tangan setelah data
                $lastRow = $sheet->getHighestRow() + 2;

                $sheet->mergeCells("A{$lastRow}:G{$lastRow}")->setCellValue("A{$lastRow}", 'Dibuat oleh:');
                $sheet->mergeCells("A" . ($lastRow + 1) . ":G" . ($lastRow + 1))->setCellValue("A" . ($lastRow + 1), 'Kepala Cabang Baubau');
                $sheet->mergeCells("A" . ($lastRow + 2) . ":G" . ($lastRow + 2))->setCellValue("A" . ($lastRow + 2), 'HARUMAN, S.H.');
                $sheet->mergeCells("A" . ($lastRow + 3) . ":G" . ($lastRow + 3))->setCellValue("A" . ($lastRow + 3), 'PLT Direktur PERUMDA Air Minum Tirta Takawa Kabupaten Buton');

                foreach (range(0, 3) as $i) {
                    $sheet->getStyle("A" . ($lastRow + $i))->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    $sheet->getRowDimension($lastRow + $i)->setRowHeight(20);
                }
            },
        ];
    }
}
