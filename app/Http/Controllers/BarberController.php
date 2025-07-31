<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Barber;
use App\Models\Jadwal;
use App\Models\Layanan;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class BarberController extends Controller
{
    public function index()
    {
        $barbers = Barber::with('user')->latest();
        $search = request('search');

        if ($search) {
            $barbers->where('nama', 'like', '%' . $search . '%')
                ->orWhere('nama_pemilik', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%')
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('email', 'like', '%' . $search . '%');
                });
        }

        $barbers = $barbers->paginate(10)->appends(['search' => $search]);

        return view('barber.index', compact('barbers', 'search'));
    }

    public function create()
    {
        return view('barber.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nama_pemilik' => 'required|max:255',
            'deskripsi' => 'nullable',
            'alamat' => 'required',
            'telepon' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            'waktu_buka' => 'required|date_format:H:i',
            'waktu_tutup' => 'required|date_format:H:i|after:waktu_buka',
        ], [
            'waktu_tutup.after' => 'Waktu tutup harus setelah waktu buka.',
        ]);

        $user = User::create([
            'name' => $validatedData['nama_pemilik'],
            'username' => strtolower(str_replace(' ', '_', $validatedData['nama_pemilik'])) . random_int(10, 99),
            'email' => $validatedData['email'],
            'password' => Hash::make('password'), // Password default
            'telepon' => $validatedData['telepon'],
            'alamat' => $validatedData['alamat'],
            'role' => 'admin_barber',
            'status' => true,
        ]);

        $validatedData['user_id'] = $user->id;
        $validatedData['is_active'] = true;
        $validatedData['is_verified'] = false;

        Barber::create($validatedData);

        return redirect()->route('barber.index')->with('success', 'Barber berhasil ditambahkan!');
    }

    public function edit(Barber $barber)
    {
        return view('barber.edit', compact('barber'));
    }

    public function update(Request $request, Barber $barber)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nama_pemilik' => 'required|max:255',
            'deskripsi' => 'nullable',
            'alamat' => 'required',
            'telepon' => 'required|max:20',
            'email' => 'required|email|unique:users,email,' . $barber->user_id,
            'waktu_buka' => 'required',
            'waktu_tutup' => 'required|after:waktu_buka',
        ], [
            'waktu_tutup.after' => 'Waktu tutup harus setelah waktu buka.',
        ]);

        $barber->user->update([
            'name' => $validatedData['nama_pemilik'],
            'username' => strtolower(str_replace(' ', '_', $validatedData['nama_pemilik'])) . random_int(10, 99),
            'email' => $validatedData['email'],
            'telepon' => $validatedData['telepon'],
            'alamat' => $validatedData['alamat'],
        ]);

        $barber->update($validatedData);

        return redirect()->route('barber.index')->with('success', 'Barber berhasil diperbarui!');
    }

    public function destroy(Barber $barber)
    {
        $barber->user->delete();
        $barber->delete();

        return redirect()->route('barber.index')->with('success', 'Barber berhasil dihapus!');
    }

    public function toggleStatus(string $id)
    {
        $barber = Barber::findOrFail($id);
        $barber->is_active = !$barber->is_active;
        $barber->save();

        $statusText = $barber->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with(['success' => "Barber berhasil {$statusText}!"]);
    }

    // Toggle Status Verifikasi
    public function toggleVerification(string $id)
    {
        $barber = Barber::findOrFail($id);
        $barber->is_verified = !$barber->is_verified;
        $barber->save();

        $statusText = $barber->is_verified ? 'diverifikasi' : 'batal diverifikasi';
        return redirect()->back()->with(['success' => "Barber berhasil {$statusText}!"]);
    }

    public function show()
    {
        $user = Auth::user();

        $barbers = Barber::where('is_active', true)->where('is_verified', true)->latest()->get();

        return view('mobile.barber', compact('barbers'));
    }

    public function detail(string $id)
    {
        $user = Auth::user();
        $barber = Barber::where('is_active', true)->where('is_verified', true)->findOrFail($id);
        $layanans = Layanan::where('barber_id', $barber->id)->where('is_active', true)->get();
        $jadwals = Jadwal::where('barber_id', $barber->id)->get();

        return view('mobile.barber-detail', compact('barber', 'layanans', 'jadwals'));
    }

    public function booking(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'barber_id' => 'required',
            'layanan_id' => 'required',
            'tanggal_pemesanan' => 'required|date|after_or_equal:today', // Validasi tanggal
            'waktu_pemesanan' => 'required',
            'catatan' => 'nullable|string|max:255',
        ]);

        // Validasi tambahan: pastikan layanan milik barber yang dipilih
        $layanan = Layanan::where('id', $validatedData['layanan_id'])
            ->where('barber_id', $validatedData['barber_id'])
            ->where('is_active', true)
            ->first();

        if (!$layanan) {
            return redirect()->back()->withErrors(['layanan_id' => 'Layanan tidak valid untuk barber yang dipilih.'])->withInput();
        }

        // Validasi ketersediaan slot antrian
        $tanggalBooking = Carbon::parse($validatedData['tanggal_pemesanan'])->format('Y-m-d');
        $waktuBooking = $validatedData['waktu_pemesanan'];

        // Cek apakah barber buka pada hari itu
        $hariDalamMinggu = strtolower(Carbon::parse($tanggalBooking)->locale('id')->isoFormat('dddd')); // 'monday', 'tuesday', dll
        $jadwalHariIni = Jadwal::where('barber_id', $validatedData['barber_id'])
            ->where('hari_dalam_minggu', $hariDalamMinggu)
            ->where('hari_kerja', true)
            ->first();

        if (!$jadwalHariIni) {
            return redirect()->back()->withErrors(['tanggal_pemesanan' => 'Barber tidak buka pada hari yang dipilih.'])->withInput();
        }

        // Cek apakah waktu booking berada dalam jam operasional
        if ($waktuBooking < $jadwalHariIni->waktu_buka || $waktuBooking > $jadwalHariIni->waktu_tutup) {
            return redirect()->back()->withErrors(['waktu_pemesanan' => 'Waktu booking di luar jam operasional barber.'])->withInput();
        }

        // Cek ketersediaan slot antrian (jumlah maksimum per jam)
        $jumlahBookingSudahAda = Pemesanan::where('barber_id', $validatedData['barber_id'])
            ->where('tanggal_pemesanan', $tanggalBooking)
            ->where('waktu_pemesanan', $waktuBooking)
            ->where('status', '!=', 'dibatalkan') // Jangan hitung yang dibatalkan
            ->count();

        if ($jumlahBookingSudahAda >= $jadwalHariIni->maksimum_pelanggan_per_jam) {
            return redirect()->back()->withErrors(['waktu_pemesanan' => 'Slot antrian untuk waktu ini sudah penuh. Silakan pilih waktu lain.'])->withInput();
        }

        // 1. Simpan data pemesanan
        $validatedData['tanggal_pemesanan'] = Carbon::parse($request->tanggal_pemesanan)->format('Y-m-d');
        $validatedData['user_id'] = $user->id;
        $validatedData['status'] = 'menunggu'; // Status awal
        $pemesanan = Pemesanan::create($validatedData);

        // 2. Buat antrian otomatis (opsional, bisa juga saat status berubah)
        // Untuk sementara, kita buat saat booking dengan status 'menunggu'
        // Nomor antrian bisa berdasarkan urutan pemesanan di hari itu
        $nomorAntrian = Pemesanan::where('barber_id', $validatedData['barber_id'])
            ->where('tanggal_pemesanan', $tanggalBooking)
            ->where('status', '!=', 'dibatalkan')
            ->count(); // Ini akan memberi nomor urut

        Antrian::create([
            'pemesanan_id' => $pemesanan->id,
            'barber_id' => $validatedData['barber_id'],
            'tanggal_antrian' => $tanggalBooking,
            'waktu_antrian' => $waktuBooking,
            'nomor_antrian' => $nomorAntrian,
            'status' => 'menunggu',
        ]);

        // 3. Buat transaksi terkait (opsional, bisa juga saat konfirmasi)
        Transaksi::create([
            'pemesanan_id' => $pemesanan->id,
            'user_id' => $user->id,
            'jumlah' => $layanan->harga,
            'status_pembayaran' => 'menunggu',
        ]);

        return redirect()->route('transaksi')->with(['success' => 'Booking berhasil! Silakan tunggu konfirmasi dari barber.']);
    }
}
