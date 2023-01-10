@extends('admin.layouts.master')
@section('title', 'All Songs')

@push('style')
@endpush

@section('breadcrumb-title')
    <h1>All Songs</h1>
    <a href="#" tooltip="Blogs List" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page">{{ __('Songs')}}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Index')}}</li>
@stop

@section('content')
    @include('admin.components.breadcrumb')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="#" class="btn btn-primary">{{ __('Add Song')}} <i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        
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
    <script>
    </script>
@endpush