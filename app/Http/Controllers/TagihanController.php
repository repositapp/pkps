<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        if (Auth::user()->role == 'admin') {
            $tagihans = Tagihan::with('pelanggan');
        } else {
            $tagihans = Tagihan::with('pelanggan')->where('pelanggan_id', session('pelanggan_id'));
        }


        // Filter berdasarkan pencarian
        if ($search) {
            $tagihans->whereHas('pelanggan', function ($query) use ($search) {
                $query->where('nama_pelanggan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $search . '%')
                    ->orWhere('pembaca_meter', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan bulan dan tahun
        if ($bulan && $tahun) {
            $tagihans->whereYear('periode', $tahun)
                ->whereMonth('periode', $bulan);
        } elseif ($tahun) {
            $tagihans->whereYear('periode', $tahun);
        }

        $tagihans = $tagihans->latest()->paginate(10)->appends([
            'search' => $search,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        // Data untuk dropdown filter
        $tahunList = Tagihan::selectRaw('YEAR(periode) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('tagihan.index', compact('tagihans', 'search', 'bulan', 'tahun', 'tahunList'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::with('pemasangan')
            ->whereHas('pemasangan', function ($query) {
                $query->where('status', 'disetujui');
            })
            ->get();

        return view('tagihan.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'periode' => 'required|date_format:Y-m',
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|min:0|gte:meter_awal',
            'biaya_administrasi' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|boolean',
            'pembaca_meter' => 'required|string|max:255',
        ], [
            'meter_akhir.gte' => 'Meter akhir harus lebih besar atau sama dengan meter awal.',
            'periode.date_format' => 'Format periode tidak valid. Gunakan format YYYY-MM (contoh: 2024-01).',
        ]);

        // Tmabah Tanggal Pada Periode
        $validatedData['periode'] = $validatedData['periode'] . '-01';

        // Hitung volume air dan biaya air
        $validatedData['volume_air'] = $validatedData['meter_akhir'] - $validatedData['meter_awal'];

        // Contoh perhitungan biaya air (bisa disesuaikan dengan tarif PDAM)
        // Misal: Rp 5.000 per meter kubik
        $tarif_per_meter = 5000;
        $validatedData['biaya_air'] = $validatedData['volume_air'] * $tarif_per_meter;

        // Hitung total tagihan
        $validatedData['total_tagihan'] = $validatedData['biaya_administrasi'] + $validatedData['biaya_air'];

        Tagihan::create($validatedData);

        return redirect()->route('tagihan.index')->with('success', 'Data tagihan berhasil ditambahkan.');
    }

    public function edit(Tagihan $tagihan)
    {
        $pelanggans = Pelanggan::with('pemasangan')
            ->whereHas('pemasangan', function ($query) {
                $query->where('status', 'disetujui');
            })
            ->get();

        return view('tagihan.edit', compact('tagihan', 'pelanggans'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $validatedData = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'periode' => 'required|date_format:Y-m',
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|min:0|gte:meter_awal',
            'biaya_administrasi' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|boolean',
            'pembaca_meter' => 'required|string|max:255',
        ], [
            'meter_akhir.gte' => 'Meter akhir harus lebih besar atau sama dengan meter awal.',
            'periode.date_format' => 'Format periode tidak valid. Gunakan format YYYY-MM (contoh: 2024-01).',
        ]);

        // Tmabah Tanggal Pada Periode
        $validatedData['periode'] = $validatedData['periode'] . '-01';

        // Hitung volume air dan biaya air
        $validatedData['volume_air'] = $validatedData['meter_akhir'] - $validatedData['meter_awal'];

        // Contoh perhitungan biaya air
        $tarif_per_meter = 5000;
        $validatedData['biaya_air'] = $validatedData['volume_air'] * $tarif_per_meter;

        // Hitung total tagihan
        $validatedData['total_tagihan'] = $validatedData['biaya_administrasi'] + $validatedData['biaya_air'];

        $tagihan->update($validatedData);

        return redirect()->route('tagihan.index')->with('success', 'Data tagihan berhasil diperbarui.');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return redirect()->route('tagihan.index')->with('success', 'Data tagihan berhasil dihapus.');
    }

    public function cetak(Tagihan $tagihan)
    {
        // Load view struk dan passing data tagihan
        $pdf = Pdf::loadView('tagihan.struk', compact('tagihan'));

        // Nama file PDF
        $fileName = $tagihan->pelanggan->nomor_sambungan . '_' . 'struk_tagihan_' .
            Carbon::parse($tagihan->periode)->format('Y-m') . '.pdf';

        // Download PDF
        // return $pdf->download($fileName);

        // Jika ingin menampilkan di browser, gunakan:
        return $pdf->stream($fileName);
    }
}
