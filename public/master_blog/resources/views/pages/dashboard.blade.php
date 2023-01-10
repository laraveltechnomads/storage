@extends('author.layouts.master') 
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-box bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Author Dashboard')}}</h5>
                            <span>{{ __('All message’s log into admin panel, Author will only see messages for them.')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('author.dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Dashboard')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Default')}}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <!-- page statustic chart start -->
                <div class="col-xl-3 col-md-6">
                    <div class="card card-red text-white">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="mb-0">{{ __('2,563')}}</h4>
                                    <p class="mb-0">{{ __('Blogs')}}</p>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="fas fa-cube f-30"></i>
                                </div>
                            </div>
                            <div id="Widget-line-chart1" class="chart-line chart-shadow"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-blue text-white">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="mb-0">{{ __('3,612')}}</h4>
                                    <p class="mb-0">{{ __('Pendiing')}}</p>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="ik ik-shopping-cart f-30"></i>
                                </div>
                            </div>
                            <div id="Widget-line-chart2" class="chart-line chart-shadow" ></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-green text-white">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="mb-0">{{ __('865')}}</h4>
                                    <p class="mb-0">{{ __('Approve')}}</p>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="ik ik-user f-30"></i>
                                </div>
                            </div>
                            <div id="Widget-line-chart3" class="chart-line chart-shadow"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-yellow text-white">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="mb-0">{{ __('35,500')}}</h4>
                                    <p class="mb-0">{{ __('Publish')}}</p>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="ik f-30">৳</i>
                                </div>
                            </div>
                            <div id="Widget-line-chart4" class="chart-line chart-shadow" ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection             
