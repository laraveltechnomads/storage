@extends('admin.layouts.master')
@section('title', 'Edit Product')

@section('breadcrumb-title')
    <h1>Edit Product</h1>
    <a href="{{ route('admin.products.index') }}" tooltip="Category List" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.products.index') }}">{{ __('Products')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')}}</li>
@stop
@section('content')
@include('admin.components.breadcrumb')

{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}
<div class="container-fluid">
    <div class="col-md-6">
        <div class="card card-body">
            {!! Form::model($product, array('route' => ['admin.products.update', encrypt($product->id)],'method' => 'PUT', 'files' => true,"autocomplete"=>"off")) !!}
                <div class="form-group">
                    <label for="input">select Category</label>
                    <div class="select2-purple">
                        <select class="form-control" name="cat_id">
                            <option>-- Select Category --</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{ (old('cat_id', $product->cat_id) == $category->id) ? 'selected' : "" }} >{{$category->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-red">{{ $errors->first('cat_id') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title">{{ __('Product Name')}}</label>
                    {{ Form::text('product_name', old('product_name', $product->product_name), ['class'=>'form-control','placeholder'=>'Enter Product Name']); }}
                    <span class="text-red">{{ $errors->first('product_name') }}</span>
                </div>
                <div class="form-group">
                    <label for="title">{{ __('Product Slug')}}</label>
                    {{ Form::text('product_slug', old('product_slug', $product->product_slug), ['class'=>'form-control','placeholder'=>'Enter Product Slug']); }}
                    <span class="text-red">{{ $errors->first('product_slug') }}</span>
                </div>
                <div class="form-group">
                    <label for="title">{{ __('Product Description')}}</label>
                    <textarea row="3" class="form-control @error('product_description') is-invalid @enderror" name="product_description" placeholder="Enter Product Description">{{old('product_description', $product->product_description)}}</textarea>
                    <span class="text-red">{{ $errors->first('product_description') }}</span>
                </div>
                <div class="form-group">
                    <label for="img">{{ __('Product Image')}} 300*300</label>
                    <input type="file" class="form-control" id="product_image" name="product_image" value="{{old('product_image', $product->product_image)}}" onchange="readURL(this);">
                    <span class="text-red">{{ $errors->first('product_image') }}</span>
                </div>
                <div class="form-group">
                    <div class="col-md-3 show-img">
                        @if(!empty($product->product_image))
                            <img src="{{ product_file_show($product->product_image) }}" width="100">
                        @else
                            <img src="{{ asset('No-Image.png') }}" width="100">
                        @endif
                    </div>
                    <div class="col-md-6 show-img">
                    </div>
                </div>
                <div class="form-group">
                    <img id="blah" src="" height="100" width="100" alt="your image">
                    <div id="show_div"><br>
                    <span><span id="response" class="text-red"></span><br></span>
                    <span id="width_lable">Width: <span id="width"></span>px<br></span>
                    <span id="height_lable">Height: <span id="height"></span>px<br></span>  
                    </div>
                </div>
                <div class="col-md-6 mb-2 pl-0">
                    <label for="customFile">Status</label>
                    <div class="input-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="status" id="status" value="1" {{ ($product->status == 1) ? 'checked' : '' }}>
                            <label for="status" class="custom-control-label mr-3">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="status" id="status1" value="0" {{ ($product->status == 0) ? 'checked' : '' }}>
                            <label for="status1" class="custom-control-label">InActive</label>
                        </div>
                    </div>
                    <span class="text-red">{{ $errors->first('status') }}</span>
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
            var fileName = document.getElementById("product_image").value;
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
                document.getElementById("product_image").value = null;
                $('#blah').attr('src', '')
                alert("Only jpg/jpeg and png Image are allowed!");
            }
        }
        
        $(document).ready(function(){

            var _URL = window.URL || window.webkitURL;

            $("#width_lable").hide();
            $("#height_lable").hide();
            $("#response").hide();
            $("#show_div").hide();

            $('#product_image').change(function () {
                $("#show_div").show();
                var file = $(this)[0].files[0];

                img = new Image();
                var imgwidth = 0;
                var imgheight = 0;
                var maxwidth = 300;
                var maxheight = 300;

                img.src = _URL.createObjectURL(file);
                img.onload = function() {
                        imgwidth = this.width;
                        imgheight = this.height;
                        $("#width_lable").show();
                        $("#height_lable").show();
                        

                        $("#width").text(imgwidth);
                        $("#height").text(imgheight);
                        if(imgwidth == maxwidth && imgheight == maxheight)
                        {
                                $("#height_lable").show();
                                $("#height_lable").show();
                                $("#response").hide();


                            //    var formData = new FormData();
                            //    formData.append('fileToUpload', $('#file')[0].files[0]);

                            //    $.ajax({
                            //          url: 'upload_image.php',
                            //          type: 'POST',
                            //          data: formData,
                            //          processData: false,
                            //          contentType: false,
                            //          dataType: 'json',
                            //          success: function (response) {
                            //                if(response.status == 1){
                            //                    $("#prev_img").attr("src","upload/"+response.returnText);
                            //                    $("#prev_img").show();
                            //                    $("#response").text("Upload successfully");
                            //                }else{
                            //                    $("#response").text(response.returnText);
                            //                } 
                            //          }
                            //     });
                        }else{
                            $("#response").show();
                            $("#response").text("* Image size must be "+maxwidth+"X"+maxheight);
                        }
                };
                img.onerror = function() {
                        $("#response").show();
                        $("#response").text("not a valid file: " + file.type);
                    }

            });
        });
    </script>
@endpush
