@extends('admin.layouts.master')
@section('title', 'All Users')

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('breadcrumb-title')
    <h1>All Users</h1>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page">{{ __('Users')}}</li>
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
                        <table id="user-data-table" class="user-data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>UniqId</th>
                                    {{--  <th>Email</th>  --}}
                                    <th>Status</th>
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
    var statusRoute = "{{route('admin.user.status.id')}}";
    $(function () {
        var table = $('.user-data-table').DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.users.index') }}",
            columns: [
                {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                {data: 'name', name: 'name'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'uniqid', name: 'uniqid'},
                // {data: 'email', name: 'email'},
                { data: 'status', name: 'status',
                    render: function( status, type, full, meta ) {
                        if(status != 0)
                        {   
                            return (status != null ? '<span class="badge badge-danger">Inactive</span>' : '<span class="badge badge-success">Active</span>' );
                        }else{
                            return '<span class="badge badge-warning">Not Verified</span>';
                        }
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        }).buttons().container().appendTo('#song-data-table .col-md-6:eq(0)');
    });
</script>
@endpush