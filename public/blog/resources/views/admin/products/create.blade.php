@extends('admin.layouts.master')
@section('title', 'Add Product')

@section('breadcrumb-title')
    <h1>Add Product</h1>
    <a href="{{ route('admin.products.index') }}" tooltip="Products" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.products.index') }}">{{ __('Products')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Add')}}</li>
@stop
@section('content')
@include('admin.components.breadcrumb')

<div class="container-fluid">
    <div class="col-md-6">
        <div class="card card-body">
            <form class="forms-sample" id="blogForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="input">Category</label>
                    <div class="select2-purple">
                        <select class="form-control @error('cat_id') is-invalid @enderror" name="cat_id">
                            <option>-- Select Category --</option>
                            @foreach ($categories as $categorie)
                            <option value="{{$categorie->id}}" @if(old('cat_id') == $categorie->id) selected @endif>{{$categorie->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-red">{{ $errors->first('cat_id') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="product_name">{{ __('Product Name')}}</label>
                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" placeholder="Enter Product Name" value="{{old('product_name')}}">
                    <span class="text-red">{{ $errors->first('product_name') }}</span>
                </div>
                <div class="form-group">
                    <label for="product_description">{{ __('Product Description')}}</label>
                    <textarea rows="3" class="form-control @error('product_description') is-invalid @enderror" name="product_description" placeholder="Enter Product Description">{{old('product_description')}}</textarea>
                        <span class="text-red">{{ $errors->first('product_description') }}</span>
                </div>
                <div class="form-group">
                    <label for="product_slug">{{ __('Product Slug')}}</label>
                    <input type="text" class="form-control @error('product_slug') is-invalid @enderror" name="product_slug" placeholder="Enter Product Slug" value="{{old('product_slug')}}" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)">
                    <span class="text-red">{{ $errors->first('product_slug') }}</span>
                    <p id="slug-text"></p>
                </div>
                <div class="form-group">
                    <label for="product_image">{{ __('Product Image')}}  300*300</label>
                    <input type="file" class="form-control @error('product_image') is-invalid @enderror" id="product_image" name="product_image" value="{{old('product_image')}}" onchange="readURL(this);">
                    <span class="text-red">{{ $errors->first('product_image') }}</span>
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
                            <input class="custom-control-input" type="radio" name="product_status" id="status" value="1" checked="">
                            <label for="status" class="custom-control-label mr-3">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="product_status" id="status1" value="0">
                            <label for="status1" class="custom-control-label">InActive</label>
                        </div>
                    </div>
                    <span class="text-red">{{ $errors->first('status') }}</span>
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
            
            var fileName = document.getElementById("product_image").value;
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
                document.getElementById("product_image").value = null;
                $('#blah').attr('src', '')
                alert("Only jpg/jpeg Svg and png Image are allowed!");
            }
        }
        /* Encode string to slug */
        function convertToSlug( str ) {
            // if(result = str.indexOf("?") != -1){
            //     console.log('yes', str.indexOf("?"))
            //     str = str.replace(/[`~!@#$%^*()_\-+=\[\]{};:'"\\|\/,.<>\s]/g, ' ')
            //         .toLowerCase();
            //         const text = 'str'.split('')
            //         text.some( (v, i, a) => {
            //             console.log('tes',a.lastIndexOf(v) !== i)
            //         }) // t
            // } else{
            //     console.log('no: ', str.indexOf("?"))
            //     str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
            //         .toLowerCase();

            //     // if(result = str.indexOf("?") != -1){
            //     //     console.log('yes', str.indexOf("?"))
            //     //     str = str.replace(/[`~!@#$%^*()_\-+=\[\]{};:'"\\|\/,.<>\s]/g, ' ')
            //     //         .toLowerCase();
            //     //         const text = 'str'.split('')
            //     //         text.some( (v, i, a) => {
            //     //             console.log('tes',a.lastIndexOf(v) !== i)
            //     //         }) // t
            //     // }
            // }
            // str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
            //         .toLowerCase();
            // trim spaces at start and end of string
            str = str.replace('-',' ');
            
            // replace space with dash/hyphen
            str = str.replace(/\s+/g, '-');
            document.getElementById("slug-text").innerHTML = str;
            $("input[name=product_slug]").val(str); 
            //return str;
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
