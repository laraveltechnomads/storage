@extends('author.layouts.master') 
@section('title', 'Create Blog')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.css') }}">
    @endpush
    
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
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Create Blog')}}</h5>
                            {{-- <span>{{ __('lorem ipsum dolor sit amet, consectetur adipisicing elit')}}</span> --}}
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
                                <a href="{{ route('author.blogs.index') }}">Blogs</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card">
                    <div class="card-body">
                        <form class="forms-sample" id="blogForm" action="{{ route('author.blogs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-6">
                                <label for="title">{{ __('Title')}}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{old('title')}}" required="">
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label for="sub_title">{{ __('Sub Title')}}</label>
                                <input type="text" class="form-control @error('sub_title') is-invalid @enderror" id="sub_title" name="sub_title" placeholder="Sub Title"  value="{{old('sub_title')}}">
                                @error('sub_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="form-group col-md-6">
                                <label for="meta_title">{{ __('Meta Title')}}</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" placeholder="Meta Title" value="{{old('meta_title')}}" required="">
                                @error('meta_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="meta_description">{{ __('Meta Description')}}</label> 
                                <textarea class="form-control" rows="2" id="meta_description" name="meta_description" required=""></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="input">Type to select a tag</label>
                                <span type="button" class="badge badge-primary click_new_tag" data-toggle="modal" data-target="#newTagModalCenter"  style="cursor: pointer;">Add to new tag <i class="fa fa-plus"></i></span><span id="addedFa"><i class="fa fa-check-circle" style="font-size:24px;color:green;"></i>New Tag Added! </span> <br>
                                <select class="form-control col-md-12 select2 js-example-basic-single" multiple="multiple" name="tags[]", id="tags" required="">
                                    @forelse($tags as $tag)
                                        <option value="{{$tag->id}}">{{$tag->tag}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="img">{{ __('Image')}}</label> 
                                <input type="file" class="form-control-file" id="image" name="image" onchange="readURL(this);" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <img id="blah" src="" height="200px" width="200px" alt="your image" style="display: none;"> 
                            </div>
                            <div class="form-group col-md-12">
                                <label for="img">{{ __('Description *')}}</label>
                           
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            {{-- <div class="card-header"><h3>{{ __('Description *')}}</h3></div> --}}
                                            <div class="card-body">
                                                <textarea class="form-control html-editor" rows="10" id="description" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                            <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
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

    <!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script> --}}
        <script type="text/javascript">
            $(document).ready(function() {
                document.getElementById("addedFa").style.display = "none";
                $('.js-example-basic-single').select2();
                $('#blah').hide();
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


            // juery form validation
            // $(document).ready(function () {
            //     $('#blogForm').validate({ 
            //         rules: {
            //             title: {
            //                 required: true,
            //                 remote:{
            //                     url:"{{ route('author.blogs.check') }}",
            //                     type:"get"
            //                 }
            //             },
            //             sub_title: {
            //                 required: true,
            //             },
            //             meta_title: {
            //                 required: true,
            //                 remote:{
            //                     url:"{{ route('author.blogs.check') }}",
            //                     type:"get"
            //                 }
            //             },
            //             meta_description: {
            //                 required: true
            //             },
            //             tags: {
            //                 required: true
            //             },
            //             image: {
            //                 required: true,
            //                 extension: "jpg|jpeg|png|ico|bmp"
            //             },
            //             description: {
            //                 required: true
            //             },
            //         },
            //         messages: {
            //             title:
            //             {
            //                 remote:"The Title has already been taken."
            //             },
            //             meta_title:
            //             {
            //                 remote:"The Mata Title has already been taken."
            //             }
            //         },
            //         submitHandler: function(form) {
            //             $('#blogForm').attr("disabled", true);  
            //             // $(form).ajaxSubmit();
            //             // form.submit();
            //         },
            //         errorElement: 'span',
            //             errorPlacement: function (error, element) {
            //             error.addClass('invalid-feedback');
            //             element.closest('.form-group').append(error);
            //         },
            //         highlight: function (element, errorClass, validClass) {
            //             $(element).addClass('is-invalid');
            //         },
            //         unhighlight: function (element, errorClass, validClass) {
            //             $(element).removeClass('is-invalid');
            //         }
            //     });
            // }); 
            $("#image").rules("add", {
                accept: "jpg|jpeg|png|ico|bmp"
            });
        </script>
    @endpush
@endsection
      
