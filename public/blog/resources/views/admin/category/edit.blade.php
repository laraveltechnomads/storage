@extends('admin.layouts.master')
@section('title', 'Edit Category')

@section('breadcrumb-title')
    <h1>Edit Category</h1>
    <a href="{{ route('admin.category.index') }}" tooltip="Category List" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.category.index') }}">{{ __('Category')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')}}</li>
@stop
@section('content')
@include('admin.components.breadcrumb')

<div class="container-fluid">
    <div class="col-md-6">
        <div class="card card-body">
            {!! Form::model($category, array('route' => ['admin.category.update', encrypt($category->id)],'method' => 'post', 'files' => true,"autocomplete"=>"off")) !!}
                <div class="form-group">
                    <label for="title">{{ __('Category Name')}}</label>
                    {{ Form::text('name', old('name'), ['class'=>'form-control','placeholder'=>'Enter Category Name']); }}
                    <span style="color: red;">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="title">{{ __('Category Description')}}</label>
                    {{ Form::textarea('description', old('description'), ['class'=>'form-control','placeholder'=>'Enter Category Description' , 'rows' => "3"]); }}
                    <span style="color: red;">{{ $errors->first('description') }}</span>
                </div>
                <div class="form-group">
                    <label for="img">{{ __('Category Image')}}</label>
                    <input type="file" class="form-control" id="image" name="image" value="{{old('image')}}" onchange="readURL(this);">
                        <span style="color: red;">{{ $errors->first('image') }}</span>
                </div>
                <div class="form-group">
                    <div class="col-md-3 show-img">
                        @if(!empty($category->image))
                            <img src="{{ category_file_show($category->image) }}" width="70">
                        @else
                            <img src="{{ asset('No-Image.png') }}" width="100">
                        @endif
                    </div>

                    <div class="col-md-3">
                        <img id="blah" src="" height="100" width="100" alt="your image">
                    </div>
                </div>
                <div class="col-md-6 mb-2 pl-0">
                    <label for="customFile">Status</label>
                    <div class="input-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="status" id="status" value="1" {{ ($category->status == 1) ? 'checked' : '' }}>
                            <label for="status" class="custom-control-label mr-3">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="status" id="status1" value="0" {{ ($category->status == 0) ? 'checked' : '' }}>
                            <label for="status1" class="custom-control-label">InActive</label>
                        </div>
                    </div>
                    <span style="color: red;">{{ $errors->first('status') }}</span>
                </div>
                <button type="submit" class="btn btn-primary mr-2">{{ __('Update')}}</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@push('script')
    <script src="{{asset('/')}}assets/admin/plugins/select2/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

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
                        $('.show-img').hide();
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
                alert("Only jpg/jpeg and png Image are allowed!");
            }
        }
    </script>
@endpush
