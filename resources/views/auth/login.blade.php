<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | {{ $aplikasi->title_header }}</title>
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
    <!-- Toastr style -->
    <link rel="stylesheet" href="{{ URL::asset('build/plugins/toastr/toastr.min.css') }}">


    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-box-body">
            <div class="text-center">
                <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="logo" class="login-logo" width="80">
                <div class="login-logo">
                    <h2 style="margin-top: 0px; font-weight: 600; color:#000000;">{{ $aplikasi->nama_lembaga }}
                    </h2>
                </div>
            </div>

            @if (session()->has('loginError'))
                <div class="alert alert-danger material-shadow" role="alert">
                    {{ session('loginError') }}
                </div>
            @endif

            <form action="{{ route('authentication') }}" method="POST">
                @csrf
                <div class="form-group has-feedback">
                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username', 'admin') }}" id="username" name="username" placeholder="username">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        placeholder="Password" id="password-input" value="12345678">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-info btn-block btn-flat">Login</button>
                    </div>
                </div>
            </form>
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
    <!-- TOASTR -->
    <script src="{{ URL::asset('build/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}')
        @elseif (session()->has('error'))
            toastr.error('{{ session('error') }}')
        @endif

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
