@extends('layouts.master')
@section('title')
    Ubah Pelanggan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('li_2')
            Pelanggan
        @endslot
        @slot('title')
            Ubah Pelanggan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Ubah Pelanggan</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-social btn-sm btn-default">
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

                <form class="form-horizontal" action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="nama_pelanggan" class="col-sm-2 control-label">Nama Lengkap <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                id="nama_pelanggan" name="nama_pelanggan"
                                value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" placeholder="Nama Lengkap"
                                required>
                            @error('nama_pelanggan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jenis_kelamin" class="col-sm-2 control-label">Jenis Kelamin <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                name="jenis_kelamin" required>
                                <option value="">-- Pilih --</option>
                                <option value="L"
                                    {{ old('jenis_kelamin', $pelanggan->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P"
                                    {{ old('jenis_kelamin', $pelanggan->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat" class="col-sm-2 control-label">Alamat <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                placeholder="Alamat Lengkap" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                            @error('alamat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nomor_telepon" class="col-sm-2 control-label">Nomor Telepon <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                id="nomor_telepon" name="nomor_telepon"
                                value="{{ old('nomor_telepon', $pelanggan->nomor_telepon) }}" placeholder="Nomor Telepon"
                                required>
                            @error('nomor_telepon')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $pelanggan->user->email) }}"
                                placeholder="Alamat Email" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nomor_sambungan" class="col-sm-2 control-label">Nomor Sambungan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nomor_sambungan') is-invalid @enderror"
                                id="nomor_sambungan" name="nomor_sambungan"
                                value="{{ old('nomor_sambungan', $pelanggan->nomor_sambungan) }}"
                                placeholder="Nomor Sambungan">
                            @error('nomor_sambungan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="file_ktp" class="col-sm-2 control-label">File KTP <br><small>(JPG, PNG,
                                PDF)</small></label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('file_ktp') is-invalid @enderror"
                                id="file_ktp" name="file_ktp" accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-danger">Ukuran File Maksimal 2MB</small>
                            @error('file_ktp')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            @if ($pelanggan->file_ktp)
                                <p class="help-block">File KTP saat ini:</p>
                                @php
                                    $extension = pathinfo(
                                        public_path('storage/' . $pelanggan->file_ktp),
                                        PATHINFO_EXTENSION,
                                    );
                                @endphp
                                @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/' . $pelanggan->file_ktp) }}"
                                        alt="KTP {{ $pelanggan->nama_pelanggan }}" class="img-thumbnail"
                                        style="max-height: 100px;">
                                @elseif(strtolower($extension) === 'pdf')
                                    <a href="{{ asset('storage/' . $pelanggan->file_ktp) }}" target="_blank"
                                        class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i> Lihat PDF KTP</a>
                                @else
                                    <span>File tidak dikenali</span>
                                @endif
                                <p class="help-block"><small>Upload file baru untuk mengganti.</small></p>
                            @endif
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
