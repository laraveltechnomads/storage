@extends('admin.layouts.master')
@section('title', 'Work with Us')

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('breadcrumb-title')
    <h1>Work with Us</h1>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page">{{ __('Work with Us')}}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Index')}}</li>
@stop

@section('content')
    @include('admin.components.breadcrumb')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="work-with-data-table" class="work-with-data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div>

@endsection

@push('script')
<!-- DataTables  & Plugins -->
<script src="{{asset('/')}}assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/jszip/jszip.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    var deleteRoute = "{{route('admin.single.work.with.us.delete')}}";

    $(function () {
        var table = $('.work-with-data-table').DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.workus.index') }}",
            columns: [
                {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                {data: 'email', name: 'email'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        }).buttons().container().appendTo('#work-with-data-table .col-md-6:eq(0)');
    });
</script>
@endpush