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
        @if (Auth::user()->role == 'admin_barber')
            @if (Auth::user()->barber->is_active == false && Auth::user()->barber->is_verified == false)
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-info"></i> Informasi!</h4>
                    Akun anda belum aktif dan belum diverifikasi. Silahkan lengkapi <strong>Layanan</strong> dan
                    <strong>Jadwal
                        Operasional</strong> barber anda agar dapat diverifikasi oleh admin komunitas. Untuk menu
                    <strong>Layanan</strong> dan <strong>Jadwal
                        Operasional</strong> barber dapat dilihat pada sebelah kiri halaman.
                </div>
            @endif
        @endif
        <div class="callout callout-info">
            <h4>Selamat Datang <span class="text-info">{{ session('nama') }}</span></h4>

            <p>Anda Sedang Mengakses Sistem Informasi
                {{ $aplikasi->nama_lembaga }}.
                Anda Login
                Sebagai <span class="badge bg-aqua"><i class="fa fa-user" style="margin-right: 5px;"></i>
                    @if (Auth::user()->role == 'admin_komunitas')
                        Admin Komunitas
                    @elseif (Auth::user()->role == 'admin_barber')
                        Admin Barber
                    @endif
                </span></p>
        </div>

        @if (Auth::user()->role == 'admin_komunitas')
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Barber</span>
                            <span class="info-box-number">{{ $totalBarber }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Barber Aktif</span>
                            <span class="info-box-number">{{ $barberAktif }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-shield"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Barber Terverifikasi</span>
                            <span class="info-box-number">{{ $barberTerverifikasi }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pemesanan Bulan Ini (Semua Barber)</span>
                            <span class="info-box-number">{{ $jumlahPemesananBulanIni }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Statistik Pemesanan Bulanan</h3>
                        </div>
                        <div class="box-body">
                            {{-- Placeholder untuk Chart --}}
                            <div class="chart">
                                <canvas id="barChart" style="height:250px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Auth::user()->role == 'admin_barber')
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pemesanan</span>
                            <span class="info-box-number">{{ $totalPemesanan }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-clock-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Hari Ini</span>
                            <span class="info-box-number">{{ $pemesananHariIni }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-exclamation-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Menunggu</span>
                            <span class="info-box-number">{{ $pemesananPending }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pendapatan</span>
                            <span class="info-box-number">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Pemesanan Terbaru</h3>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px;">No</th>
                                            <th>Pelanggan</th>
                                            <th>Layanan</th>
                                            <th>Tanggal & Waktu</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pemesananTerbaru as $pemesanan)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $pemesanan->user->name }}</td>
                                                <td>{{ $pemesanan->layanan->nama }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pemesanan->waktu_pemesanan)->translatedFormat('d F Y, H:i') }}
                                                </td>
                                                <td>
                                                    @switch($pemesanan->status)
                                                        @case('menunggu')
                                                            <span class="label label-warning">Menunggu</span>
                                                        @break

                                                        @case('dikonfirmasi')
                                                            <span class="label label-info">Dikonfirmasi</span>
                                                        @break

                                                        @case('dalam_pengerjaan')
                                                            <span class="label label-primary">Dalam Pengerjaan</span>
                                                        @break

                                                        @case('selesai')
                                                            <span class="label label-success">Selesai</span>
                                                        @break

                                                        @case('dibatalkan')
                                                            <span class="label label-danger">Dibatalkan</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada pemesanan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    @endsection
    @if (Auth::user()->role == 'admin_komunitas')
        @push('script')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var ctx = document.getElementById('barChart').getContext('2d');

                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov',
                                'Des'
                            ],
                            datasets: @json($barberChartData)
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Pemesanan per Bulan per Barber'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endpush
    @endif
