@extends('church.layouts.master')
@section('title', 'Church Name : '.$church->church_name)

@push('style')

@endpush

@section('breadcrumb-title')
    {{-- <h1>Church: {{ $church->church_name }}</h1> --}}
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item active" aria-current="page">{{ $church->church_name }}</li>
@stop

@section('content')
    @include('church.components.breadcrumb')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Name : {{$church->church_name}}</h3>
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
                                        <th><a href="{{ route('church.edit') }}" class="btn btn-primary">Edit <i class="fa fa-edit"></i></a></th>
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
@endsection

@push('script')
<script>
</script>
@endpush