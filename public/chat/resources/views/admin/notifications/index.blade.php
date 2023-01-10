@extends('admin.layouts.master')
@section('title', 'All Notifications')

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('breadcrumb-title')
    <h1>All Notifications</h1>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"> <a href="{{route('admin.users.index')}}">{{ __('Users')}}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Notifications')}}</li>
@stop

@section('content')
    @include('admin.components.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>New Users List</h4>        
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul class="list-group">    
                            @foreach ($admNotifications as $notify)
                                <li class="list-group-item new-users-list">
                                    <div class="row">
                                        <p class="text-right"><b>Name:</b> {{ userTable($notify->data['user_id'])->name }}, <b>Email:</b> {{  userTable($notify->data['user_id'])->email }}</p>
                                        <p class="text-right">&nbsp;&nbsp;
                                            <button class="btn btn-primary btn-sm"><a href="{{ route("admin.users.show", [$notify->data['user_id']]) }}" class="new-users-list">Show</a></button> &nbsp;
                                            <form action="{{route('admin.single.notification.delete') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="notification_id" value="{{ $notify->id }}">
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                            
                                        </p>  
                                    </div>
                                </li>
                            @endforeach      
                        </ul>
                        <br>
                        {{ $admNotifications->links() }}                  
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    var deleteRoute = "{{route('admin.single.notification.delete')}}";
</script>
@endpush