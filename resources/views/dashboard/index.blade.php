@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('li_2')
            Halaman Utama
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <section class="content">
        <div class="callout callout-info">
            <h4>Selamat Datang <span class="text-info">{{ session('nama') }}</span></h4>

            <p>Anda Sedang Mengakses Sistem Informasi
                {{ $aplikasi->nama_lembaga }}.
                Anda Login
                Sebagai <span class="badge bg-aqua"><i class="fa fa-user" style="margin-right: 5px;"></i>
                    Administrator
                </span>
            </p>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Siswa</span>
                        <span class="info-box-number">{{ $totalSiswa }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-building"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Kelas</span>
                        <span class="info-box-number">{{ $totalKelas }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Guru</span>
                        <span class="info-box-number">{{ $totalGuru }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Statistik Siswa</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <input type="text" class="knob" value="{{ $siswaLk }}" data-width="120"
                                    data-height="120" data-fgColor="#3c8dbc" data-readonly="true"
                                    value="{{ $siswaLk }}">
                                <div class="knob-label">Laki-laki</div>
                            </div>
                            <div class="col-md-6 text-center">
                                <input type="text" class="knob" value="{{ $siswaPr }}" data-width="120"
                                    data-height="120" data-fgColor="#f56954" data-readonly="true">
                                <div class="knob-label">Perempuan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Kehadiran Hari Ini</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <input type="text" class="knob" value="{{ $persentaseHadir }}" data-width="120"
                                    data-height="120" data-fgColor="#00a65a" data-readonly="true">
                                <div class="knob-label">Hadir (%)</div>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fa fa-circle text-green"></i> Hadir: <b>{{ $hadir }}</b></p>
                                <p><i class="fa fa-circle text-blue"></i> Izin: <b>{{ $izin }}</b></p>
                                <p><i class="fa fa-circle text-aqua"></i> Sakit: <b>{{ $sakit }}</b></p>
                                <p><i class="fa fa-circle text-red"></i> Alpa: <b>{{ $tidakHadir }}</b></p>
                                <p><i class="fa fa-circle text-gray"></i> Belum Absen: <b>{{ $siswaTanpaAbsensi }}</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafik Kehadiran 7 Hari Terakhir</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart" height="70"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi Tahun Ajaran</h3>
                    </div>
                    <div class="box-body">
                        <p><strong>Tahun Ajaran:</strong> {{ $tahunAjaran?->tahun_ajaran ?? 'Tidak tersedia' }}</p>
                        <p><strong>Semester:</strong> {{ $tahunAjaran?->semester ?? 'Tidak tersedia' }}</p>
                        <p><strong>Status:</strong>
                            @if ($tahunAjaran?->status)
                                <span class="label label-success">Aktif</span>
                            @else
                                <span class="label label-default">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
    <script>
        $(function() {
            // Knob
            $(".knob").knob();

            // Line Chart
            var area = $('#lineChart').get(0).getContext('2d');
            var lineChart = new Chart(area, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                            label: 'Hadir',
                            backgroundColor: 'rgba(0, 166, 90, 0.3)',
                            borderColor: '#00a65a',
                            pointColor: '#00a65a',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: '#00a65a',
                            data: {!! json_encode($chartHadir) !!}
                        },
                        {
                            label: 'Izin',
                            backgroundColor: 'rgba(33, 150, 243, 0.3)',
                            borderColor: '#2196f3',
                            pointColor: '#2196f3',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: '#2196f3',
                            data: {!! json_encode($chartIzin) !!}
                        },
                        {
                            label: 'Sakit',
                            backgroundColor: 'rgba(30, 136, 229, 0.3)',
                            borderColor: '#1e88e5',
                            pointColor: '#1e88e5',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: '#1e88e5',
                            data: {!! json_encode($chartSakit) !!}
                        },
                        {
                            label: 'Alpa',
                            backgroundColor: 'rgba(245, 105, 84, 0.3)',
                            borderColor: '#f56954',
                            pointColor: '#f56954',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: '#f56954',
                            data: {!! json_encode($chartAlpa) !!}
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false
                }
            });
        });
    </script>
@endpush
