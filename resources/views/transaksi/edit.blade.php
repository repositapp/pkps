@extends('layouts.master')
@section('title')
    Ubah Transaksi #{{ $transaksi->id }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manajemen Transaksi
        @endslot
        @slot('li_2')
            Daftar Transaksi
        @endslot
        @slot('title')
            Ubah Transaksi
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Ubah Transaksi</h3>
                <div class="pull-right box-tools">
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="form-group">
                        <label for="metode_pembayaran" class="col-sm-2 control-label">Metode Pembayaran <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('metode_pembayaran') is-invalid @enderror"
                                id="metode_pembayaran" name="metode_pembayaran">
                                <option value="">-- Pilih Metode --</option>
                                <option value="tunai" @if (old('metode_pembayaran', $transaksi->metode_pembayaran) == 'tunai') selected @endif>Tunai</option>
                                <option value="transfer" @if (old('metode_pembayaran', $transaksi->metode_pembayaran) == 'transfer') selected @endif>Transfer Bank
                                </option>
                                <option value="dompet_elektronik" @if (old('metode_pembayaran', $transaksi->metode_pembayaran) == 'dompet_elektronik') selected @endif>Dompet
                                    Elektronik</option>
                            </select>
                            @error('metode_pembayaran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-save"></i> Simpan
                                Perubahan</button>
                        </div>
                    </div>
                    <p><span class="text-red">*</span> Wajib diisi.</p>
                </form>
            </div>
        </div>
    </section>
@endsection
--}}
