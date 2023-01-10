@extends('author.layouts.master')
@section('title', 'Edit Blog')

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush

@section('breadcrumb-title')
    <h1>Edit Blog</h1>
    <a href="{{ route('author.blogs.index') }}" tooltip="Blogs List" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('author.blogs.index') }}">{{ __('Blogs')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')}}</li>
@stop
@section('content')
    @include('author.components.breadcrumb')

    <div class="container-fluid">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card">
                    <div class="card-body">
                        <form class="forms-sample" id="blogForm" action="{{ route('author.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-6">
                                <label for="title">{{ __('Title')}}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{old('title', @$blog->title)}}" required="">
                                <span class="text-red hide" id="title-error"; role="alert"></span>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label for="sub_title">{{ __('Sub Title')}}</label>
                                <input type="text" class="form-control @error('sub_title') is-invalid @enderror" id="sub_title" name="sub_title" placeholder="Sub Title"  value="{{old('sub_title', @$blog->sub_title)}}">
                                @error('sub_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="form-group col-md-6">
                                <label for="meta_title">{{ __('Meta Title')}}</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" placeholder="Meta Title" value="{{old('meta_title', @$blog->meta_title)}}" required="">
                                @error('meta_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="meta_description">{{ __('Meta Description')}}</label> 
                                <textarea class="form-control" rows="2" id="meta_description" name="meta_description" required="">{{old('meta_description', @$blog->meta_description)}}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="input">Type to select a tag</label>
                                <span type="button" class="badge badge-primary click_new_tag" data-toggle="modal" data-target="#newTagModalCenter"  style="cursor: pointer;">Add to new tag <i class="fa fa-plus"></i></span><span id="addedFa"><i class="fa fa-check-circle" style="font-size:24px;color:green;"></i>New tag added! </span> <br>
                                <div class="select2-purple">
                                    <select class="form-control select2 js-example-basic-single" multiple="multiple" name="tags[]", id="tags" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;" >
                                       @forelse(@$tags as $tag)
                                            <option value="{{$tag->id}}" @if($blog->tag_id) {{ in_array($tag->id,$blog->tag_id)?'selected':'' }} @endif>{{$tag->tag}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="img">{{ __('Image')}}</label>
                                <input type="file" class="form-control-file" id="image" name="image" value="{{old('feature_image', @$blog->feature_image)}}" onchange="readURL(this);">
                            </div>
                            <div class="form-group col-md-6">
                                <img id="blah" src="{{ asset('images/blogs')}}/{{$blog->feature_image}}" height="200px" width="200px" alt="your image"> 
                            </div>
                            <div class="form-group col-md-12">
                                <label for="img">{{ __('Description')}}</label> 
                           
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            {{-- <div class="card-header"><h3>{{ __('Description')}}</h3></div> --}}
                                            <div class="card-body">
                                                <textarea class="form-control html-editor" rows="10" id="description" name="description">{{old('description', @$blog->description)}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                            <button type="submit" class="btn btn-primary mr-2">{{ __('Update')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="newTagModalCenter" tabindex="-1" role="dialog" aria-labelledby="newTagModalCenterLabel" aria-hidden="true"  data-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newTagModalCenterLabel">{{ __('New Tag')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="newTagForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tagnew">{{ __('Tag Name')}}</label>
                            <input type="text" class="form-control" id="tagnew" name="tagnew" placeholder="New">
                                <div class="alert alert-danger" id="tagnew_error_message" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script src="{{asset('/')}}assets/admin/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="{{asset('/')}}assets/admin/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript">
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
              theme: 'bootstrap4'
            })

            $('body').on('keydown', 'input', function(e) {
                if (e.which === 32 &&  e.target.selectionStart === 0) {
                    return false;
                }  
            });
            $('body').on('keydown', 'textarea', function(e) {
                if (e.which === 32 &&  e.target.selectionStart === 0) {
                    return false;
                }  
            });
        });
        $(document).ready(function() {
            document.getElementById("addedFa").style.display = "none";
            $('.js-example-basic-single').select2();
        });

        $('.html-editor').summernote({
          height: 200,
          tabsize: 2
        });

        // new tag submit function
        $('.click_new_tag').click(function() {
            var element = document.getElementById("tagnew");
            element.classList.remove("is-invalid");
            document.getElementById("tagnew_error_message").style.display = "none";
            document.getElementById("addedFa").style.display = "none";
            $('#tagnew_error_message').html('')
            $('#tagnew').val('')
        });
        $('#newTagForm').on('submit', function(e){
            // console.log('form submit new');
            e.preventDefault();
            var tag = $('#tagnew').val();
            var formdata = $("#newTagForm").serialize()
            // console.log('formdata:', formdata)
            // console.log('tag:', tag)
            if(tag)
            {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('tags.store') }}",
                    type: "POST",
                    data: formdata,
                    success: function(response){
                        // console.log('response:', response)
                        if(response.status == '200')
                        {
                            $('#newTagModalCenter').modal('hide');
                            document.getElementById("addedFa").style.display = "block";
                            var list = {
                                id: response.data.id,
                                text: response.data.tag,
                                value: response.data.id,
                                color: "#c5efd0"
                            };

                            var newOption = new Option(list.text, list.id, list.value, list.color, false, false);
                            $('.js-example-basic-single').append(newOption).trigger('change');
                            // console.log(response.message);
                        
                        }else{
                            var v = document.getElementById("tagnew");
                            v.className += " is-invalid";
                            $('#tagnew_error_message').show()
                            $('#tagnew_error_message').html(response.message)
                            // console.log(response.message);
                            document.getElementById("addedFa").style.display = "none";
                        }
                    },
                    errors: function(errors){
                        console.log('errors:', errors)
                        alert("not submitted.")
                    }
                });
            }
        });


        function readURL(input) {
            var fileName = document.getElementById("image").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#blah').show();
                        $('#blah')
                            .attr('src', e.target.result)
                            .width(200)
                            .height(200);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }else{
                document.getElementById("image").value = null;
                $('#blah').attr('src', '')
                alert("Only jpg/jpeg and png Image are allowed!");
            }   
        }

        $("#title").change(function(e){
            // e.preventDefault();
            var title = document.getElementById("title").value;

            $.ajax({
                url: "{{ route('blog.check')}}?title="+title+"&blog_id="+"{{$blog->id}}", 
                success: function(response){
                    if(response.status == '200')
                    {
                        document.getElementById("title-error").classList.add("hide");
                    }else{
                        document.getElementById("title").value = "";
                        document.getElementById("title-error").classList.remove("hide");
                        document.getElementById("title-error").innerHTML = response.message;
                    
                    }
                },errors: function(errors){
                    console.log('errors:', errors)
                    alert("errors:.", errors)
                }
            });
        });
    </script>
@endpush
