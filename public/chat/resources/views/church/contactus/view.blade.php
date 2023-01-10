@extends('admin.layouts.master')
@section('title', 'Contact Us Details')

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('breadcrumb-title')
    <h1>Contact Us Details</h1>
    <a href="{{ route('church.contactus.index') }}" tooltip="Contact Us" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"> <a href="{{route('church.contactus.index')}}">{{ __('Contact us')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page"></li>
@stop

@section('content')
    @include('admin.components.breadcrumb')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Name : {{$contact->first_name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table>
                            <tbody>
                                 <tr>
                                    <th>{{ __('Email')}}</th>
                                    <td>: {{ $contact->email}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('First Name')}}</th>
                                    <td>: {{ $contact->first_name}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Last Name')}}</th>
                                    <td>: {{ $contact->last_name}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Mobile Number')}}</th>
                                    <td>: {{ $contact->mobile_number}}</td>
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
                                    <td> {!! nl2br($contact->description) !!} </td>
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