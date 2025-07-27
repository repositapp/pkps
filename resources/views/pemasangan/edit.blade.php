@extends('layouts.master')
@section('title')
    Ubah Permohonan Pemasangan
@endsection
@push('css')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ URL::asset('build/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pemasangan
        @endslot
        @slot('li_2')
            Data Pemasangan Air Baru
        @endslot
        @slot('title')
            Ubah Permohonan Pemasangan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Ubah Permohonan Pemasangan</h3>
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

                <form class="form-horizontal" action="{{ route('pemasangan.update', $pemasangan->id) }}" method="POST">
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
                                            {{ old('pelanggan_id', $pemasangan->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                            {{ $pelanggan->nama_pelanggan }}
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
                        <label for="deskripsi" class="col-sm-2 control-label">Tujuan Pemasangan <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3"
                                placeholder="Deskripsikan tujuan pemasangan..." required>{{ old('deskripsi', $pemasangan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lokasi" class="col-sm-2 control-label">Lokasi</label>
                        <div class="col-sm-10">
                            {{-- <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi"
                                name="lokasi" value="{{ old('lokasi', $pemasangan->lokasi) }}"
                                placeholder="Latitude,Longitude (contoh: -6.2088,106.8456)"> --}}
                            <div class="input-group">
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                    id="lokasi" name="lokasi" value="{{ old('lokasi', $pemasangan->lokasi) }}"
                                    placeholder="Latitude,Longitude (contoh: -6.2088,106.8456)">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat" id="btn-ambil-lokasi">Ambil Lokasi
                                        Otomatis</button>
                                </span>
                            </div>
                            <small class="text-muted">Lokasi otomatis akan diambil dari GPS Anda. Harap berada dirumah
                                tempat pemasangan akan dilakukan.</small>
                            @error('lokasi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_permohonan" class="col-sm-2 control-label">Tanggal Permohonan <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text"
                                    class="form-control datepicker @error('tanggal_permohonan') is-invalid @enderror"
                                    id="tanggal_permohonan" name="tanggal_permohonan"
                                    value="{{ old('tanggal_permohonan', $pemasangan->tanggal_permohonan) }}"
                                    placeholder="yyyy-mm-dd" required>
                            </div>
                            @error('tanggal_permohonan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_penelitian" class="col-sm-2 control-label">Tanggal Penelitian</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text"
                                    class="form-control datepicker @error('tanggal_penelitian') is-invalid @enderror"
                                    id="tanggal_penelitian" name="tanggal_penelitian"
                                    value="{{ old('tanggal_penelitian', $pemasangan->tanggal_penelitian ? $pemasangan->tanggal_penelitian : '') }}"
                                    placeholder="yyyy-mm-dd">
                            </div>
                            @error('tanggal_penelitian')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_bayar" class="col-sm-2 control-label">Tanggal Bayar</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text"
                                    class="form-control datepicker @error('tanggal_bayar') is-invalid @enderror"
                                    id="tanggal_bayar" name="tanggal_bayar"
                                    value="{{ old('tanggal_bayar', $pemasangan->tanggal_bayar ? $pemasangan->tanggal_bayar : '') }}"
                                    placeholder="yyyy-mm-dd">
                            </div>
                            @error('tanggal_bayar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="spk_tanggal" class="col-sm-2 control-label">Tanggal SPK</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text"
                                    class="form-control datepicker @error('spk_tanggal') is-invalid @enderror"
                                    id="spk_tanggal" name="spk_tanggal"
                                    value="{{ old('spk_tanggal', $pemasangan->spk_tanggal ? $pemasangan->spk_tanggal : '') }}"
                                    placeholder="yyyy-mm-dd">
                            </div>
                            @error('spk_tanggal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="spk_nomor" class="col-sm-2 control-label">Nomor SPK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('spk_nomor') is-invalid @enderror"
                                id="spk_nomor" name="spk_nomor" value="{{ old('spk_nomor', $pemasangan->spk_nomor) }}"
                                placeholder="Contoh: 02/XII/SPKPI/PUDAM/2024">
                            @error('spk_nomor')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ba_tanggal" class="col-sm-2 control-label">Tanggal B.A</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text"
                                    class="form-control datepicker @error('ba_tanggal') is-invalid @enderror"
                                    id="ba_tanggal" name="ba_tanggal"
                                    value="{{ old('ba_tanggal', $pemasangan->ba_tanggal ? $pemasangan->ba_tanggal : '') }}"
                                    placeholder="yyyy-mm-dd">
                            </div>
                            @error('ba_tanggal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ba_nomor" class="col-sm-2 control-label">Nomor B.A</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('ba_nomor') is-invalid @enderror"
                                id="ba_nomor" name="ba_nomor" value="{{ old('ba_nomor', $pemasangan->ba_nomor) }}"
                                placeholder="Contoh: 02/XII/BAPIL/PUDAM/2024">
                            @error('ba_nomor')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="merek_meteran" class="col-sm-2 control-label">Merek Meteran</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('merek_meteran') is-invalid @enderror"
                                id="merek_meteran" name="merek_meteran"
                                value="{{ old('merek_meteran', $pemasangan->merek_meteran) }}"
                                placeholder="Merek meteran yang terpasang">
                            @error('merek_meteran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kedudukan" class="col-sm-2 control-label">Kedudukan</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('kedudukan') is-invalid @enderror" id="kedudukan"
                                name="kedudukan">
                                <option value="0"
                                    {{ old('kedudukan', $pemasangan->kedudukan) == 0 ? 'selected' : '' }}>Baru</option>
                                <option value="1"
                                    {{ old('kedudukan', $pemasangan->kedudukan) == 1 ? 'selected' : '' }}>Perubahan
                                </option>
                            </select>
                            @error('kedudukan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status_pembayaran" class="col-sm-2 control-label">Status Pembayaran</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('status_pembayaran') is-invalid @enderror"
                                id="status_pembayaran" name="status_pembayaran">
                                <option value="0"
                                    {{ old('status_pembayaran', $pemasangan->status_pembayaran) == 0 ? 'selected' : '' }}>
                                    Belum Lunas</option>
                                <option value="1"
                                    {{ old('status_pembayaran', $pemasangan->status_pembayaran) == 1 ? 'selected' : '' }}>
                                    Lunas</option>
                            </select>
                            @error('status_pembayaran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('status') is-invalid @enderror" id="status"
                                name="status" required>
                                <option value="pending"
                                    {{ old('status', $pemasangan->status) == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="proses"
                                    {{ old('status', $pemasangan->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="disetujui"
                                    {{ old('status', $pemasangan->status) == 'disetujui' ? 'selected' : '' }}>Disetujui
                                </option>
                                <option value="ditolak"
                                    {{ old('status', $pemasangan->status) == 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Input Nomor Sambungan (muncul saat status disetujui) -->
                    <div id="nomor-sambungan-section"
                        style="display: {{ old('status', $pemasangan->status) == 'disetujui' ? 'block' : 'none' }};">
                        <hr>
                        <h4 class="col-sm-offset-2 col-sm-10">Nomor Sambungan (Diisi saat status disetujui)</h4>

                        <div class="form-group">
                            <label for="kode_wilayah" class="col-sm-2 control-label">Kode Wilayah <span
                                    class="text-red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('kode_wilayah') is-invalid @enderror"
                                    id="kode_wilayah" name="kode_wilayah" value="{{ old('kode_wilayah') }}"
                                    placeholder="2 digit (contoh: 01)" maxlength="2">
                                <small class="text-muted">Kode wilayah terdiri dari 2 digit.</small>
                                @error('kode_wilayah')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kode_bagian" class="col-sm-2 control-label">Kode Bagian <span
                                    class="text-red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('kode_bagian') is-invalid @enderror"
                                    id="kode_bagian" name="kode_bagian" value="{{ old('kode_bagian') }}"
                                    placeholder="2 digit (contoh: 02)" maxlength="2">
                                <small class="text-muted">Kode bagian terdiri dari 2 digit.</small>
                                @error('kode_bagian')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nomor_urut" class="col-sm-2 control-label">Nomor Urut <span
                                    class="text-red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nomor_urut') is-invalid @enderror"
                                    id="nomor_urut" name="nomor_urut" value="{{ old('nomor_urut', $nomorUrut) }}"
                                    placeholder="5 digit (contoh: 01028)" maxlength="5">
                                <small class="text-muted">Nomor urut terdiri dari 5 digit. Diisi otomatis berdasarkan
                                    urutan pemasangan.</small>
                                @error('nomor_urut')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="alasan-ditolak-section"
                        style="display: {{ old('status', $pemasangan->status) == 'ditolak' ? 'block' : 'none' }};">
                        <label for="alasan_ditolak" class="col-sm-2 control-label">Alasan Ditolak <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('alasan_ditolak') is-invalid @enderror" id="alasan_ditolak"
                                name="alasan_ditolak" rows="3" placeholder="Alasan penolakan permohonan...">{{ old('alasan_ditolak', $pemasangan->alasan_ditolak) }}</textarea>
                            <small class="text-muted">Wajib diisi jika status ditolak.</small>
                            @error('alasan_ditolak')
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
    <!-- bootstrap datepicker -->
    <script src="{{ URL::asset('build/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>

    <!-- Select2 -->
    <script src="{{ URL::asset('build/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            $('#pelanggan_id').select2();

            const btnAmbilLokasi = document.getElementById('btn-ambil-lokasi');
            const inputLokasi = document.getElementById('lokasi');
            const statusSelect = document.getElementById('status');
            const nomorSambunganSection = document.getElementById('nomor-sambungan-section');
            const alasanDitolakSection = document.getElementById('alasan-ditolak-section');
            const nomorUrutInput = document.getElementById('nomor_urut');

            if (btnAmbilLokasi) {
                btnAmbilLokasi.addEventListener('click', function() {
                    if (navigator.geolocation) {
                        btnAmbilLokasi.innerHTML =
                            '<i class="fa fa-spinner fa-spin"></i> Mengambil lokasi...';
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
                                    alert(errorMessage +
                                        '\nDan gagal mengambil lokasi dari IP.');
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
                //         btnAmbilLokasi.innerHTML =
                //             '<i class="fa fa-spinner fa-spin"></i> Mengambil lokasi...';
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
            }

            function toggleConditionalSections() {
                const value = statusSelect.value;

                if (value === 'disetujui') {
                    nomorSambunganSection.style.display = 'block';

                    // if (!nomorUrutInput.value || nomorUrutInput.value === 'Memuat...') {
                    //     fetchNomorUrut();
                    // }
                } else {
                    nomorSambunganSection.style.display = 'none';
                }

                if (value === 'ditolak') {
                    alasanDitolakSection.style.display = 'block';
                } else {
                    alasanDitolakSection.style.display = 'none';
                }
            }

            // function fetchNomorUrut() {
            //     nomorUrutInput.value = 'Memuat...';

            //     fetch("{{ route('pemasangan.get-nomor-urut') }}", {
            //             method: 'GET',
            //             headers: {
            //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
            //                     'content'),
            //                 'Accept': 'application/json'
            //             }
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             nomorUrutInput.value = data.nomor_urut;
            //         })
            //         .catch(error => {
            //             console.error('Error:', error);
            //             nomorUrutInput.value = '';
            //             alert('Gagal mengambil nomor urut otomatis. Silakan isi manual.');
            //         });
            // }

            // Jalankan saat halaman dimuat dan saat status diubah
            toggleConditionalSections();
            statusSelect.addEventListener('change', toggleConditionalSections);
        });
    </script>
@endpush
