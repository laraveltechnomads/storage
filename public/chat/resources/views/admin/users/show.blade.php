@extends('admin.layouts.master')
@section('title', 'User Name : '.$user->first_name.' '.$user->last_name)

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('breadcrumb-title')
    {{-- <h1>Church: {{ $church->church_name }}</h1> --}}
    <a href="{{ route('admin.users.index') }}" tooltip="Users List" class="badge badge-primary"><i class="fa fa-arrow-left"></i></a>
<span>{{ __('Back')}}</span>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"> <a href="{{route('admin.users.index')}}">{{ __('Users')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page"></li>
@stop

@section('content')
    @include('admin.components.breadcrumb')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Name: {{$user->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <th style="width: 15%;">{{ __('First Name')}}</th>
                                        <td>: {{$user->first_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Last Name')}}</th>
                                        <td>: {{$user->last_name}}</td>
                                    </tr>
                                    {{--  <tr>
                                        <th style="width: 15%;">{{ __('Email')}}</th>
                                        <td>: {{$user->email}}</td>
                                    </tr>  --}}
                                    <tr>
                                        <th>{{ __('UUID')}}</th>
                                        <td>: {{$user->uniqid}}</td>
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
                                            @if($image && $user->pic)
                                                <img src="{{ asset('storage/pics/').'/'.$user->pic }}" width="200px" height="200px">
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
@endsection

@push('script')
<script>
</script>
@endpush