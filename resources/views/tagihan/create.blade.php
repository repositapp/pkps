@extends('layouts.master')
@section('title')
    Tambah Tagihan
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
            Tagihan
        @endslot
        @slot('li_2')
            Data Tagihan
        @endslot
        @slot('title')
            Tambah Tagihan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Tambah Tagihan</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('tagihan.index') }}" class="btn btn-social btn-sm btn-default">
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

                <form class="form-horizontal" action="{{ route('tagihan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="pelanggan_id" class="col-sm-2 control-label">Pelanggan <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control select2 @error('pelanggan_id') is-invalid @enderror"
                                id="pelanggan_id" name="pelanggan_id" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}"
                                        {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
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

                    <div class="form-group">
                        <label for="periode" class="col-sm-2 control-label">Periode <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text"
                                    class="form-control datepicker-month @error('periode') is-invalid @enderror"
                                    id="periode" name="periode" value="{{ old('periode') }}" required
                                    placeholder="yyyy-mm">
                            </div>
                            <small class="text-muted">Format: YYYY-MM (contoh: 2024-01)</small>
                            @error('periode')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="meter_awal" class="col-sm-2 control-label">Meter Awal <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control @error('meter_awal') is-invalid @enderror"
                                id="meter_awal" name="meter_awal" value="{{ old('meter_awal') }}" placeholder="0"
                                min="0" required>
                            @error('meter_awal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="meter_akhir" class="col-sm-2 control-label">Meter Akhir <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control @error('meter_akhir') is-invalid @enderror"
                                id="meter_akhir" name="meter_akhir" value="{{ old('meter_akhir') }}" placeholder="0"
                                min="0" required>
                            @error('meter_akhir')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="biaya_administrasi" class="col-sm-2 control-label">Biaya Administrasi <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01"
                                class="form-control @error('biaya_administrasi') is-invalid @enderror"
                                id="biaya_administrasi" name="biaya_administrasi"
                                value="{{ old('biaya_administrasi', 2500) }}" placeholder="0.00" min="0" required>
                            <small class="text-muted">Contoh: 2500.00</small>
                            @error('biaya_administrasi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status_pembayaran" class="col-sm-2 control-label">Status Pembayaran <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('status_pembayaran') is-invalid @enderror"
                                id="status_pembayaran" name="status_pembayaran" required>
                                <option value="0" {{ old('status_pembayaran') == '0' ? 'selected' : '' }}>Belum Lunas
                                </option>
                                <option value="1" {{ old('status_pembayaran') == '1' ? 'selected' : '' }}>Lunas
                                </option>
                            </select>
                            @error('status_pembayaran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pembaca_meter" class="col-sm-2 control-label">Pembaca Meter <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('pembaca_meter') is-invalid @enderror"
                                id="pembaca_meter" name="pembaca_meter" value="{{ old('pembaca_meter') }}"
                                placeholder="Pembaca Meteran Air" required>
                            @error('pembaca_meter')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-save"></i>
                                Simpan</button>
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
            $('.datepicker-month').datepicker({
                format: "yyyy-mm",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });

            $('#pelanggan_id').select2();

            const meterAwal = document.getElementById('meter_awal');
            const meterAkhir = document.getElementById('meter_akhir');

            function validateMeter() {
                if (meterAwal.value && meterAkhir.value) {
                    if (parseInt(meterAkhir.value) < parseInt(meterAwal.value)) {
                        meterAkhir.setCustomValidity('Meter akhir harus lebih besar atau sama dengan meter awal.');
                    } else {
                        meterAkhir.setCustomValidity('');
                    }
                }
            }

            meterAwal.addEventListener('input', validateMeter);
            meterAkhir.addEventListener('input', validateMeter);
        });
    </script>
@endpush
