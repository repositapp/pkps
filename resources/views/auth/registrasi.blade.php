<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registrasi | {{ $aplikasi->title_header }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="{{ URL::asset('build/dist/img/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('build/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/dist/css/style.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('build/plugins/iCheck/square/blue.css') }}">


    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-box-body">
            <div class="text-center">
                <div class="login-logo">
                    <h2 style="margin-top: 0px; font-weight: 600; color:#000000;">Registrasi Barber
                    </h2>
                </div>
            </div>

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

            <form action="{{ route('registrasi.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap"
                                required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama Barber"
                                required>
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="Email Aktif"
                                required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                id="telepon" name="telepon" value="{{ old('telepon') }}"
                                placeholder="Nomor Telepon Aktif" required>
                            @error('telepon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                placeholder="Alamat Barber" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3"
                                placeholder="Deskripsikan barber anda..." required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="time" class="form-control @error('waktu_buka') is-invalid @enderror"
                                id="waktu_buka" name="waktu_buka" value="{{ old('waktu_buka') }}"
                                placeholder="Waktu Buka" required>
                            <small class="text-muted">Waktu Buka</small>
                            @error('waktu_buka')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="time" class="form-control @error('waktu_tutup') is-invalid @enderror"
                                id="waktu_tutup" name="waktu_tutup" value="{{ old('waktu_tutup') }}"
                                placeholder="Waktu Tutup" required>
                            <small class="text-muted">Waktu Tutup</small>
                            @error('waktu_tutup')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') }}" id="username" name="username"
                                placeholder="username">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Password" id="password-input">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                        name="gambar" accept=".jpg,.jpeg,.png">
                    <small class="text-danger">Logo Barber, ukuran File Maksimal 1MB berekstensi .jpg, .jpeg,
                        .png</small>
                    @error('gambar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-info btn-block btn-flat">Buat Akun</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center">
                <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-center">Login Sekarang</a></p>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="{{ URL::asset('build/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ URL::asset('build/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ URL::asset('build/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
</body>

</html>
