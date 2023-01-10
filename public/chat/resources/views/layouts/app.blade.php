<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" href="{{project('app_favicon_path')}}" />
        <title>{{ config('app.name') }} | @yield('title','')</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/fontawesome-free/css/all.min.css" />
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('/')}}assets/admin/dist/css/adminlte.min.css" />
        <link rel="stylesheet" href="{{asset('/')}}assets/admin/style.css" />
        <style type="text/css">
            .login-logo img {
                width: 60%;
            }
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <img src="{{project('app_logo_path')}}" />
            </div>
            <!-- /logo -->
            <div class="card">
                @yield('content')
                <!-- /content -->
            </div>
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="{{asset('/')}}assets/admin/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('/')}}assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('/')}}assets/admin/dist/js/adminlte.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            @if(Session::has('success'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                toastr.success("{{ session('success') }}");
            @endif
            @if(Session::has('status'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                toastr.success("{{ session('status') }}");
            @endif

            @if(Session::has('error'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                toastr.error("{{ session('error') }}");
            @endif

            @if(Session::has('info'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.info("{{ session('info') }}");
            @endif

            @if(Session::has('warning'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                toastr.warning("{{ session('warning') }}");
            @endif
            $('.alert').delay(3000).fadeOut();
        </script>
    </body>
</html>
