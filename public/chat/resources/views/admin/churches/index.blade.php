@extends('admin.layouts.master')
@section('title', 'All Churches')

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('breadcrumb-title')
    <h1>All Churches</h1>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page">{{ __('Churches')}}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Index')}}</li>
@stop

@section('content')
    @include('admin.components.breadcrumb')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if(!$church)
                            <a href="{{route('admin.churches.create')}}" class="btn btn-primary">{{ __('Add Church')}} <i class="fa fa-plus" aria-hidden="true"></i></a>
                        @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="church-data-table" class="church-data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Email</th>
                                    <th>UniqId</th>
                                    <th>Church Name</th>
                                    <th>Location</th>
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
    var deleteRoute = "{{route('admin.church.destroy.id')}}";
    var statusRoute = "{{route('admin.church.status.change.id')}}";
    $(function () {
        var table = $('.church-data-table').DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.churches.index') }}",
            columns: [
                {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                {data: 'email', name: 'email'},
                {data: 'uniqid', name: 'uniqid'},
                {data: 'church_name', name: 'church_name'},
                {data: 'location', name: 'location'},
                { data: 'status', name: 'status',
                    render: function( status, type, full, meta ) {
                        if(status != null)
                        {   
                            return '<span class="badge badge-danger">Inactive</span>';
                        }else{
                            return '<span class="badge badge-success">Active</span>';
                        }
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        }).buttons().container().appendTo('#song-data-table .col-md-6:eq(0)');
    });
</script>
@endpush