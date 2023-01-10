<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" href="{{ asset('admin/img/logo/favicon.png')}}" />
        <title> {{ config('app.name') }} | @yield('title','')</title>
        <!-- Google Font: Source Sans Pro -->
        @include('admin.partials.css') 
        @stack('style')
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            @include('admin.partials.header')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @include('admin.partials.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @stack('breadcrumb')
                {{-- @include('admin.partials.flash-message') --}}
                <!-- Main content -->
                <section class="content">
                    @yield('content')
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            @include('admin.partials.footer')
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        @include('admin.partials.js')
        @stack('script')
    </body>
</html>
