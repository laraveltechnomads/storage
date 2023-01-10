@extends('admin.layouts.master')
@section('title', 'Work with Us Details')

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('breadcrumb-title')
    <h1>Work with Us Details</h1>
    <a href="{{ route('admin.workus.index') }}" tooltip="Work with Us" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"> <a href="{{route('admin.workus.index')}}">{{ __('Work with Us')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page"></li>
@stop

@section('content')
    @include('admin.components.breadcrumb')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Name : {{$workus->first_name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table>
                            <tbody>
                                 <tr>
                                    <th>{{ __('Email')}}</th>
                                    <td>: {{ $workus->email}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('First Name')}}</th>
                                    <td>: {{ $workus->first_name}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Last Name')}}</th>
                                    <td>: {{ $workus->last_name}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Mobile Number')}}</th>
                                    <td>: {{ $workus->mobile_number}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table>
                            <tbody>
                                <tr>
                                    <th>{{ __('Description')}}</th>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td> {!! nl2br($workus->description) !!} </td>
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
@endpush