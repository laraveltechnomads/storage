@extends('admin.layouts.master') @section('title', 'Add Banner') @push('style')
<style type="text/css">
    audio {
        width: none !important;
        height: none !important;
    }
</style>
@endpush @section('breadcrumb-title')
<h1>Add Banner</h1>
@if($u_type == 'ADM')
<a href="{{ route('admin.churches.show', [$church->id]) }}" title="Church List" class="badge badge-primary"><i class="fa fa-arrow-left"></i></a>
@endif @if($u_type == 'CHR')
<a href="{{ route('banners.list', ['u_type' => $u_type, 'church_id' => $church->id]) }}" title="Church List" class="badge badge-primary"><i class="fa fa-arrow-left"></i></a>
@endif

<span>{{ __('Back')}}</span>
@stop @section('breadcrumb-items')
<li class="breadcrumb-item" aria-current="page">{{ __('Church')}}</li>
@if($u_type == 'ADM')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.churches.show', [$church->id]) }}" title="Church List"> {{ church_name_helper($church->id) }}</a></li>
@endif @if($u_type == 'CHR')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('church.show') }}" title="Church List"> {{ church_name_helper($church->id) }}</a></li>
@endif

<li class="breadcrumb-item" aria-current="page">{{ __('Banner')}}</li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Add')}}</li>
@stop @section('content') @include('admin.components.breadcrumb')
<div class="container-fluid">
    <div class="row">
        <!-- right column -->
        <div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Banner Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form class="forms-sample" id="bannerForm" action="{{ route('banners.store', ['u_type' => $u_type, 'church_id' => $church->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Banner Image')}}</label>
                                    <input
                                        type="file"
                                        class="form-control @error('banner_image') is-invalid @enderror"
                                        id="banner_image"
                                        name="banner_image"
                                        placeholder="Banner Image"
                                        value="{{old('banner_image')}}"
                                        required=""
                                        onchange="readURL(this);"
                                    />
                                    @error('banner_image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <img id="blah" src="" height="200px" width="300px" alt="your image" />
                                </div>
                                <br />
                                Width: <span id="width"></span><br />
                                Height: <span id="height"></span>
                                <div id="response" class="text-danger"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">{{ __('Save')}}</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection @push('script')

<script type="text/javascript">
    $(function () {
        $("body").on("keydown", "input", function (e) {
            if (e.which === 32 && e.target.selectionStart === 0) {
                return false;
            }
        });
        $("body").on("keydown", "textarea", function (e) {
            if (e.which === 32 && e.target.selectionStart === 0) {
                return false;
            }
        });
        $("#blah").hide();
    });

    function readURL(input) {
        var fileName = document.getElementById("banner_image").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#blah").show();
                    $("#blah").attr("src", e.target.result).width(300).height(200);
                };
                reader.readAsDataURL(input.files[0]);
                $("#response").text("");
            }
        } else {
            document.getElementById("banner_image").value = null;
            $("#blah").attr("src", "");
            alert("Only jpg/jpeg and png Image are allowed!");
        }
    }

    var _URL = window.URL || window.webkitURL;
    $("#banner_image").change(function () {
        var file = $(this)[0].files[0];

        img = new Image();
        var imgwidth = 0;
        var imgheight = 0;
        var maxwidth = 800;
        var maxheight = 400;

        img.src = _URL.createObjectURL(file);
        img.onload = function () {
            imgwidth = this.width;
            imgheight = this.height;

            $("#width").text(imgwidth);
            $("#height").text(imgheight);
            if (imgwidth >= maxwidth && imgheight >= maxheight) {
                $("#response").text("");
            } else {
                document.getElementById("banner_image").value = null;
                $('#blah').attr('src', '')
                $('#blah').hide()
                $("#response").text("Banner image approx at list width 800px and height 400px required!");
            }
        };
        img.onerror = function () {
            $("#response").text("not a valid file: " + file.type);
        };
    });
</script>
@endpush
