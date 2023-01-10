@extends('admin.layouts.master')
@section('title', 'Add Blog')

@push('style')
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/dropzone/min/dropzone.min.css">
@endpush

@section('breadcrumb-title')
    <h1>Add Blog</h1>
    <a href="{{ route('admin.blogs.index') }}" tooltip="Blogs List" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.blogs.index') }}">{{ __('Blogs')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Add')}}</li>
@stop
@section('content')
    @include('admin.components.breadcrumb')

    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card card">
                    <div class="card-body">
                        <form class="forms-sample" id="blogForm" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h4><b><u>Meta Details</u></b></h4>
                            <div class="form-group col-md-6">
                                <label for="meta_title">{{ __('Author')}}</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" placeholder="Author" value="{{ auth()->user()->name }}" disabled>
                                @error('author')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="category">{{ __('Category')}}</label>
                                <select class="form-control" name="category" id="category">
                                    <option value="Article">Article</option>
                                    <option value="Article">Article</option>
                                    <option value="Article">Article</option>
                                    <option value="Article">Article</option>
                                    <option value="Article">Article</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="meta_title">{{ __('Meta Title')}}</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" placeholder="Meta Title" value="{{old('meta_title')}}" required="">
                                @error('meta_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="meta_description">{{ __('Meta Description')}}</label> 
                                <textarea class="form-control" rows="2" id="meta_description" name="meta_description" required="">{{old('meta_description')}}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="meta_keywords">{{ __('Meta Keywords')}}</label> 
                                <textarea class="form-control" rows="2" id="meta_keywords" name="meta_keywords" required="">{{old('meta_keywords')}}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="publish_date">{{ __('Publish Date')}}</label>
                                <input type="date" class="form-control @error('publish_date') is-invalid @enderror" id="publish_date" name="publish_date" placeholder="" value="{{old('publish_date')}}" required="">
                                @error('publish_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--  <div class="form-group  col-md-6">
                                <label>{{ __('Schedule')}}</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input @error('schedule') is-invalid @enderror" id="schedule" name="schedule" placeholder="Schedule" value="{{old('schedule')}}" required="" autocomplete="off" data-target="#reservationdatetime" />
                                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                @error('schedule')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                            </div>  --}}

                            <br/>
                            
                            <h4><b><u>General Details</u></b></h4>
                            <div class="form-group col-md-6">
                                <label for="title">{{ __('Title')}}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{old('title')}}" required="">
                                    <span></span>
                                <span class="text-red hide" id="title-error"; role="alert"></span>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="input">Type to select a tag</label>
                                <span type="button" class="badge badge-primary click_new_tag" data-toggle="modal" data-target="#newTagModalCenter"  style="cursor: pointer;">Add to new tag <i class="fa fa-plus"></i></span><span id="addedFa"><i class="fa fa-check-circle" style="font-size:24px;color:green;"></i>New tag added! </span> <br>
                                <div class="select2-purple">
                                    <select class="form-control select2 js-example-basic-single" multiple="multiple" name="tags[]", id="tags" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;" required="">
                                       @forelse(@$tags as $tag)
                                            <option value="{{$tag->id}}">{{$tag->tag}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="img">{{ __('Image')}}</label>
                                <input type="file" class="form-control-file" id="image" name="image" value="{{old('feature_image')}}" onchange="readURL(this);" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <img id="blah" src="" height="200px" width="200px" alt="your image"> 
                            </div>
                            <div class="form-group col-md-12">
                                <label for="img">{{ __('Description')}}</label> 
                           
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            {{-- <div class="card-header"><h3>{{ __('Description')}}</h3></div> --}}
                                            <div class="card-body">
                                                <textarea class="form-control html-editor" rows="10" id="description" name="description">{{old('description')}}</textarea>
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

    <!-- jQuery -->
    <script src="{{asset('/')}}assets/admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('/')}}assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="{{asset('/')}}assets/admin/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{asset('/')}}assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="{{asset('/')}}assets/admin/plugins/moment/moment.min.js"></script>
    <script src="{{asset('/')}}assets/admin/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="{{asset('/')}}assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="{{asset('/')}}assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('/')}}assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="{{asset('/')}}assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="{{asset('/')}}assets/admin/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="{{asset('/')}}assets/admin/plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('/')}}assets/admin/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('/')}}assets/admin/dist/js/demo.js"></script>
    
    
    <script type="text/javascript">
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        $(document).ready(function() {
            document.getElementById("addedFa").style.display = "none";
            $('.js-example-basic-single').select2();
            $('#blah').hide();
            //Date and time picker
            
        });
        

        $(function () {
            

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
              theme: 'bootstrap4'
            })

            // $("#image").rules("add", {
            //     accept: "jpg|jpeg|png|ico|bmp"
            // });

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

        // $("#title").keyup(function(){
        //     console.log('keyup');
        //         // $("#inputId").blur();
        //         // $("#inputId").focus();
        // });

        $("#title").change(function(e){
            // e.preventDefault();
            var title = document.getElementById("title").value;

            $.ajax({
                url: "{{ route('blog.check')}}?title="+title, 
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


        // juery form validation
        // $(document).ready(function () {
        //     $('#blogForm').validate({ 
        //         rules: {
        //             title: {
        //                 required: true,
        //                 remote:{
        //                     url:"{{ route('admin.blogs.check') }}",
        //                     type:"get"
        //                 }
        //             },
        //             sub_title: {
        //                 required: true,
        //             },
        //             meta_title: {
        //                 required: true,
        //                 remote:{
        //                     url:"{{ route('admin.blogs.check') }}",
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
        
    </script>
@endpush
