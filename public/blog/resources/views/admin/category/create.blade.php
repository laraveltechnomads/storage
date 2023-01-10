@extends('admin.layouts.master')
@section('title', 'Add Category')

@section('breadcrumb-title')
    <h1>Add Category</h1>
    <a href="{{ route('admin.category.index') }}" tooltip="Category List" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.category.index') }}">{{ __('Category')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Add')}}</li>
@stop
@section('content')
@include('admin.components.breadcrumb')

<div class="container-fluid">
    <div class="col-md-6">
        <div class="card card-body">
            <form class="forms-sample" id="blogForm" action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="title">{{ __('Category Name')}}</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Category Name" value="{{old('name')}}">
                        <span style="color: red;">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="title">{{ __('Category Description')}}</label>
                    <textarea rows="3" class="form-control" name="description" placeholder="Enter Category Description"></textarea>
                        <span style="color: red;">{{ $errors->first('description') }}</span>
                </div>
                <div class="form-group">
                    <label for="img">{{ __('Category Image')}}</label>
                    <input type="file" class="form-control" id="image" name="image" value="{{old('image')}}" onchange="readURL(this);">
                        <span style="color: red;">{{ $errors->first('image') }}</span>
                </div>
                <div class="form-group">
                    <img id="blah" src="" height="100px" width="100px" alt="your image">
                </div>
                <div class="col-md-6 mb-2 pl-0">
                    <label for="customFile">Status</label>
                    <div class="input-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="status" id="status" value="1" checked="">
                            <label for="status" class="custom-control-label mr-3">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="status" id="status1" value="0">
                            <label for="status1" class="custom-control-label">InActive</label>
                        </div>
                    </div>
                    <span style="color: red;">{{ $errors->first('status') }}</span>
                 </div>
                <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#blah').hide();
        });

        function readURL(input) {
            var fileName = document.getElementById("image").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile=="svg"){
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#blah').show();
                        $('#blah')
                            .attr('src', e.target.result)
                            .width(100)
                            .height(100);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }else{
                document.getElementById("image").value = null;
                $('#blah').attr('src', '')
                alert("Only jpg/jpeg Svg and png Image are allowed!");
            }
        }

    </script>
@endpush
