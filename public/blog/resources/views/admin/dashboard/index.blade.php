@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('breadcrumb-title')
<h1>Dashboard</h1>
@stop

@section('breadcrumb-items')
<li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard')}}</li>
@stop

@section('content')
@include('admin.components.breadcrumb')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <h5 class="mb-2">Home Menu</h5>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <a href="#">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-dark">Total Our Clients</span>
                            <span class="info-box-number text-dark"></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <a href="#">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-trophy"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-dark">Total Our Achievement</span>
                            <span class="info-box-number text-dark"></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <a href="#">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-dark">Total Clients Review</span>
                            <span class="info-box-number text-dark"></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <a href="#">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-bell"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-dark">Total Subscribe</span>
                            <span class="info-box-number text-dark"></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection