<?php

namespace App\Exports;

use App\Models\Pemasangan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PemasanganExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data['pemasangans'])->map(function ($pemasangan) {
            return [
                $pemasangan->pelanggan->nama_pelanggan,
                $pemasangan->pelanggan->alamat,
                $pemasangan->pelanggan->nomor_sambungan ?? '-',
                Carbon::parse($pemasangan->tanggal_permohonan)->format('d F Y'),
                Carbon::parse($pemasangan->tanggal_penelitian)->format('d F Y'),
                Carbon::parse($pemasangan->tanggal_bayar)->format('d F Y'),
                Carbon::parse($pemasangan->spk_tanggal)->format('d F Y'),
                $pemasangan->spk_nomor,
                Carbon::parse($pemasangan->ba_tanggal)->format('d F Y'),
                $pemasangan->ba_nomor,
                $pemasangan->merek_meteran ?? '-',
                $pemasangan->kedudukan == 1 ? 'Perubahan' : 'Baru',
                $pemasangan->status,
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
            'Tanggal Penelitian',
            'Tanggal Bayar',
            'Tanggal SPK Pemasangan',
            'Nomor SPK Pemasangan',
            'Tanggal B.A. Pemasangan',
            'Nomor B.A. Pemasangan',
            'Merek Meteran',
            'Kedudukan',
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

                // Merge dan isi header laporan (baris 1-5)
                $sheet->mergeCells('A1:M1')->setCellValue('A1', 'PEMERINTAH KABUPATEN BUTON');
                $sheet->mergeCells('A2:M2')->setCellValue('A2', 'PERUSAHAAN UMUM DAERAH AIR MINUM TIRTA TAKAWA');
                $sheet->mergeCells('A3:M3')->setCellValue('A3', 'Jl. Sultan Hasanuddin No. 42, Baubau, Buton Selatan');
                $sheet->mergeCells('A4:M4')->setCellValue('A4', 'LAPORAN PEMASANGAN BARU CABANG BAUBAU');
                $sheet->mergeCells('A5:M5')->setCellValue('A5', 'BULAN ' . Carbon::now()->translatedFormat('F Y'));

                // Format setiap baris header
                foreach (range(1, 5) as $row) {
                    $sheet->getStyle("A{$row}")->applyFromArray([
                        'font' => ['bold' => true],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    $sheet->getRowDimension($row)->setRowHeight(20);
                }

                // Bold untuk heading tabel (baris 6)
                $sheet->getStyle('A6:M6')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Cari baris terakhir data
                $lastRow = $sheet->getHighestRow() + 2;

                // Tanda tangan (baris setelah data)
                $sheet->mergeCells("A{$lastRow}:M{$lastRow}")->setCellValue("A{$lastRow}", 'Dibuat oleh:');
                $sheet->mergeCells("A" . ($lastRow + 1) . ":M" . ($lastRow + 1))->setCellValue("A" . ($lastRow + 1), 'Kepala Cabang Baubau');
                $sheet->mergeCells("A" . ($lastRow + 2) . ":M" . ($lastRow + 2))->setCellValue("A" . ($lastRow + 2), 'HARUMAN, S.H.');
                $sheet->mergeCells("A" . ($lastRow + 3) . ":M" . ($lastRow + 3))->setCellValue("A" . ($lastRow + 3), 'PLT Direktur PERUMDA Air Minum Tirta Takawa Kabupaten Buton');

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
