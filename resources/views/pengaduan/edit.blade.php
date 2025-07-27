@extends('layouts.master')
@section('title')
    Edit Pengaduan
@endsection
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pengaduan
        @endslot
        @slot('li_2')
            Data Pengaduan
        @endslot
        @slot('title')
            Edit Pengaduan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Edit Pengaduan</h3>
                <div class="pull-right box-tools">
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Kesalahan Validasi!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal" action="{{ route('pengaduan.update', $pengaduan->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    @if (Auth::user()->role == 'admin')
                        <div class="form-group">
                            <label for="pelanggan_id" class="col-sm-2 control-label">Pelanggan <span
                                    class="text-red">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2 @error('pelanggan_id') is-invalid @enderror"
                                    id="pelanggan_id" name="pelanggan_id" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}"
                                            {{ old('pelanggan_id', $pengaduan->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                            {{ $pelanggan->nama_pelanggan }} -
                                            {{ $pelanggan->nomor_sambungan ?? 'Belum Ada No. Sambungan' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pelanggan_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @elseif (Auth::user()->role == 'pelanggan')
                        <input type="hidden" name="pelanggan_id" value="{{ session('pelanggan_id') }}">
                    @endif

                    <div class="form-group">
                        <label for="deskripsi" class="col-sm-2 control-label">Deskripsi Pengaduan <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                                placeholder="Jelaskan detail pengaduan..." required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lokasi" class="col-sm-2 control-label">Lokasi</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                    id="lokasi" name="lokasi" value="{{ old('lokasi', $pengaduan->lokasi) }}"
                                    placeholder="Latitude,Longitude (contoh: -6.2088,106.8456)">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat" id="btn-ambil-lokasi">Ambil Lokasi
                                        Otomatis</button>
                                </span>
                            </div>
                            <small class="text-muted">Klik tombol untuk mengambil lokasi dari GPS Anda.</small>
                            @error('lokasi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            @if ($pengaduan->lokasi)
                                <p class="help-block">
                                    <a href="https://www.google.com/maps?q={{ $pengaduan->lokasi }}" target="_blank"
                                        class="btn btn-xs btn-primary">
                                        <i class="fa fa-map-marker"></i> Lihat di Google Maps
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="pending"
                                    {{ old('status', $pengaduan->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="proses"
                                    {{ old('status', $pengaduan->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai"
                                    {{ old('status', $pengaduan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group" id="alasan-penyelesaian-section"
                        style="display: {{ old('status', $pengaduan->status) == 'selesai' ? 'block' : 'none' }};">
                        <label for="alasan_penyelesaian" class="col-sm-2 control-label">Alasan Penyelesaian <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('alasan_penyelesaian') is-invalid @enderror" id="alasan_penyelesaian"
                                name="alasan_penyelesaian" rows="3" placeholder="Jelaskan bagaimana pengaduan diselesaikan...">{{ old('alasan_penyelesaian', $pengaduan->alasan_penyelesaian) }}</textarea>
                            <small class="text-muted">Wajib diisi jika status selesai.</small>
                            @error('alasan_penyelesaian')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-save"></i>
                                Update</button>
                        </div>
                    </div>
                    <p><span class="text-red">*</span> Wajib diisi.</p>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <!-- Select2 -->
    <script src="{{ URL::asset('build/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //Initialize Select2 Elements
            $('#pelanggan_id').select2();

            const btnAmbilLokasi = document.getElementById('btn-ambil-lokasi');
            const inputLokasi = document.getElementById('lokasi');
            const statusSelect = document.getElementById('status');
            const alasanPenyelesaianSection = document.getElementById('alasan-penyelesaian-section');

            // Event listener untuk tombol ambil lokasi
            btnAmbilLokasi.addEventListener('click', function() {
                if (navigator.geolocation) {
                    btnAmbilLokasi.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Mengambil lokasi...';
                    btnAmbilLokasi.disabled = true;

                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        inputLokasi.value = latitude.toFixed(6) + ',' + longitude.toFixed(6);
                        btnAmbilLokasi.innerHTML = 'Ambil Lokasi Otomatis';
                        btnAmbilLokasi.disabled = false;
                        alert('Lokasi berhasil diambil!');
                    }, function(error) {
                        // console.log('Geolocation error:', error);

                        let errorMessage = 'Gagal mengambil lokasi. ';
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Izin akses lokasi ditolak.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Informasi lokasi tidak tersedia.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Waktu permintaan lokasi habis.';
                                break;
                            default:
                                errorMessage += 'Terjadi kesalahan yang tidak diketahui.';
                                break;
                        }

                        // Fallback menggunakan lokasi berdasarkan IP
                        fetch('http://ip-api.com/json')
                            .then(res => res.json())
                            .then(data => {
                                if (!data.lat || !data.lon) {
                                    throw new Error("Data lokasi IP tidak ditemukan.");
                                }
                                inputLokasi.value = data.lat + ',' + data.lon;
                                // alert('Lokasi berdasarkan IP telah diambil.');
                            })
                            .catch(err => {
                                console.error('Fallback IP API error:', err);
                                alert(errorMessage + '\nDan gagal mengambil lokasi dari IP.');
                            })
                            .finally(() => {
                                btnAmbilLokasi.innerHTML = 'Ambil Lokasi Otomatis';
                                btnAmbilLokasi.disabled = false;
                            });
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    });
                } else {
                    alert('Geolocation tidak didukung oleh browser Anda.');
                }
            });

            // btnAmbilLokasi.addEventListener('click', function() {
            //     if (navigator.geolocation) {
            //         btnAmbilLokasi.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Mengambil lokasi...';
            //         btnAmbilLokasi.disabled = true;

            //         navigator.geolocation.getCurrentPosition(function(position) {
            //             const latitude = position.coords.latitude;
            //             const longitude = position.coords.longitude;
            //             inputLokasi.value = latitude.toFixed(6) + ',' + longitude.toFixed(6);
            //             btnAmbilLokasi.innerHTML = 'Ambil Lokasi Otomatis';
            //             btnAmbilLokasi.disabled = false;
            //             alert('Lokasi berhasil diambil!');
            //         }, function(error) {
            //             btnAmbilLokasi.innerHTML = 'Ambil Lokasi Otomatis';
            //             btnAmbilLokasi.disabled = false;
            //             let errorMessage = 'Gagal mengambil lokasi. ';
            //             switch (error.code) {
            //                 case error.PERMISSION_DENIED:
            //                     errorMessage += 'Izin akses lokasi ditolak.';
            //                     break;
            //                 case error.POSITION_UNAVAILABLE:
            //                     errorMessage += 'Informasi lokasi tidak tersedia.';
            //                     break;
            //                 case error.TIMEOUT:
            //                     errorMessage += 'Waktu permintaan lokasi habis.';
            //                     break;
            //                 default:
            //                     errorMessage += 'Terjadi kesalahan yang tidak diketahui.';
            //                     break;
            //             }
            //             alert(errorMessage);
            //         });
            //     } else {
            //         alert('Geolocation tidak didukung oleh browser Anda.');
            //     }
            // });

            // Event listener untuk perubahan status
            statusSelect.addEventListener('change', function() {
                if (this.value === 'selesai') {
                    alasanPenyelesaianSection.style.display = 'block';
                } else {
                    alasanPenyelesaianSection.style.display = 'none';
                }
            });
        });
    </script>
@endpush
