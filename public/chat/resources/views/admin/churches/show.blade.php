@extends('admin.layouts.master')
@section('title', 'Church Name : '.$church->church_name)

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('breadcrumb-title')
    {{-- <h1>Church: {{ $church->church_name }}</h1> --}}
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"> <a href="{{route('admin.churches.index')}}">{{ __('Churches')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page"></li>
@stop

@section('content')
    @include('admin.components.breadcrumb')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Church Name: {{$church->church_name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <th style="width: 15%;">{{ __('Church Name')}}</th>
                                        <td>: {{$church->church_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('UUID')}}</th>
                                        <td>: {{$church->uniqid}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Email')}}</th>
                                        <td>: {{$church->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Latitude')}}</th>
                                        <td>: {{$church->latitude}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Longitude')}}</th>
                                        <td>: {{$church->longitude}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Location')}}</th>
                                        <td>: {{$church->location}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Mobile Number')}}</th>
                                        <td>: {{$church->mobile_number}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Website Url')}}</th>
                                        <td>: {{$church->website_url}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.churches.edit', [$church->id]) }}" class="btn btn-primary">Edit <i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                            <table>
                                <tbody>
                                    
                                    <tr>
                                        <th>{{ __('Image')}}</th>
                                        <td>: </tD>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td> 
                                            @if (File::exists(store_church_path().$church->church_image)) 
                                                <img src="{{ church_path().$church->church_image }}" width="200px" height="200px">
                                            @endif 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('events.create', ['church_user_id' => $church->user->id, 'login' => 'ADM', 'page' => 'admin_church_show'])}}" class="btn btn-primary">{{ __('Add Event')}} <i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="event-data-table" class="event-data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Schedule</th>
                                    <th>Desctiption</th>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('banners.create', ['u_type' => $u_type, 'church_id' => $church_id])}}" class="btn btn-primary">{{ __('Add Banner')}} <i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="banner-data-table" class="banner-data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Church Name</th>
                                    <th>Serial Number</th>
                                    <th>Banner Image</th>
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
    var deleteRoute = "{{route('event.destroy.id')}}";
    $(function () {
        console.log('id:', "{{$church->id}}");
        var table = $('.event-data-table').DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            processing: true,
            serverSide: true,
            ajax: "{{ route("admin.churches.show", [$church->id]) }}",
            columns: [
                {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                {data: 'title', name: 'title'},
                {data: 'schedule', name: 'schedule'},
                {data: 'description', name: 'desctiption', 'orderable': false, 'searchable': false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        }).buttons().container().appendTo('#event-data-table .col-md-6:eq(0)');
    });

    var deleteRoute = "{{route('banner.destroy')}}";
    // var statusRoute = "{{route('admin.church.status.change.id')}}";
    $(function () {
        var table = $('.banner-data-table').DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            processing: true,
            serverSide: true,
            ajax: "{{ route('banners.index', ['u_type' => $u_type, 'church_id' => $church_id]) }}",
            columns: [
                {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                {data: 'church_name', name: 'church_name'},
                {data: 'serial_number', name: 'serial_number'},
                {data: 'banner_image', name: 'banner_image'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        }).buttons().container().appendTo('#banner-data-table .col-md-6:eq(0)');
    });
</script>
@endpush