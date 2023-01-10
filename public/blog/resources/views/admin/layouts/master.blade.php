<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" type="image/x-icon" href="{{asset('/')}}assets/img/logo/favicon.png">
        <title> @yield('title','') </title>
        <!-- Google Font: Source Sans Pro -->
        @include('admin.partials.css')
        <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        @stack('style')
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- ./wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            @include('admin.partials.header')

            <!-- Main Sidebar Container -->
            @include('admin.partials.sidebar')
            @include('admin.delete-modal')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @stack('breadcrumb')
               
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
        
        <!-- DataTables  & Plugins -->
        <script src="{{asset('/')}}assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/jszip/jszip.min.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="{{asset('/')}}assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

        @stack('script')
    </body>
</html>
