@extends('admin.layouts.master') @section('title', 'Edit Church') @push('style')
<style type="text/css">
    audio {
        width: none !important;
        height: none !important;
    }
</style>
@endpush 
@section('breadcrumb-title')
<h1>Edit Church</h1>
<a href="{{ route('admin.churches.index') }}" tooltip="Blogs List" class="badge badge-primary"><i class="fa fa-arrow-left"></i></a>
<span>{{ __('Back')}}</span>
@stop 
@section('breadcrumb-items')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.churches.index') }}">{{ __('Churches')}}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Edit')}}</li>
@stop @section('content') @include('admin.components.breadcrumb')
<div class="container-fluid">
    <div class="row">
        <!-- right column -->
        <div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Church Details Edit</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form class="forms-sample" id="blogForm" action="{{ route('admin.churches.update', [$church->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label for="email">{{ __('Email')}}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{old('email', @$church->email)}}" required="" readonly=""/>
                                    <span></span>
                                    <span class="text-red hide" id="email-error" ; role="alert"></span>
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mobile_number">{{ __('Mobile Number')}}</label>
                                    <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number" name="mobile_number" placeholder="Mobile Number" value="{{old('mobile_number', @$church->mobile_number)}}" required="" autocomplete="off" onkeypress="return [48, 49, 50, 51, 52, 53, 54, 55, 56, 57].includes(event.charCode);" maxlength="18">
                                      <span></span>
                                    <span class="text-red hide" id="church-name-error"; role="alert"></span>
                                    @error('mobile_number')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{--  <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">{{ __('Password')}}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" value="{{old('password')}}" autocomplete="off" minlength="8"/>
                                    <span></span>
                                    <span class="text-red hide" id="password-error" ; role="alert"></span>
                                    @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password_confirmation">{{ __('Confirm Password')}}</label>
                                    <input
                                        type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="Confirm Password"
                                        value="{{old('password_confirmation')}}"                                        
                                        autocomplete="off"
                                        minlength="8"
                                    />
                                    <span></span>
                                    <span class="text-red hide" id="password_confirmation-error" ; role="alert"></span>
                                    @error('password_confirmation')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="checkbox" id="showPass"> Show Password
                                </div>
                            </div>  --}}
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label for="church_name">{{ __('Church Name')}}</label>
                                    <input
                                        type="text"
                                        class="form-control @error('church_name') is-invalid @enderror"
                                        id="church_name"
                                        name="church_name"
                                        placeholder="Church Name"
                                        value="{{old('church_name', @$church->church_name)}}"
                                        required=""
                                    />
                                    <span></span>
                                    <span class="text-red hide" id="church-name-error" ; role="alert"></span>
                                    @error('church_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label for="website_url">{{ __('Website Url')}}</label>
                                    <input type="text" class="form-control @error('website_url') is-invalid @enderror" id="website_url" name="website_url" placeholder="Website Url" value="{{old('website_url', @$church->website_url)}}" required="" autocomplete="off" />
                                    <span></span>
                                    <span class="text-red hide" id="church-name-error" ; role="alert"></span>
                                    @error('website_url')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <!-- textarea -->
                                <div class="form-group">
                                  <label for="website_url">{{ __('Latitude')}} <a href="https://www.maps.ie/coordinates.html" target="_blank"> check latitude and longitude</a></label>
                                  <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" placeholder="Latitude" value="{{old('latitude', @$church->longitude)}}" required="" autocomplete="off" onkeypress="return [45, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57].includes(event.charCode);">
                                      <span></span>
                                  <span class="text-red hide" id="latitude-error"; role="alert"></span>
                                  @error('latitude')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <!-- textarea -->
                                <div class="form-group">
                                  <label for="website_url">{{ __('Longitude')}}</label>
                                  <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" placeholder="Longitude" value="{{old('longitude', @$church->longitude)}}" required="" autocomplete="off" onkeypress="return [45, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57].includes(event.charCode);">
                                      <span></span>
                                  <span class="text-red hide" id="longitude-error"; role="alert"></span>
                                  @error('longitude')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Church Location')}}</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter location" name="location" id="location" placeholder="Church Location">{{old('location', @$church->location)}}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label>{{ __('Church Image')}}</label>
                                <input type="file" class="form-control @error('church_image') is-invalid @enderror" id="church_image" name="church_image" placeholder="Website Url" value="{{old('church_image')}}" onchange="readURL(this);">
                                @error('church_image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                              </div>
                              <div class="form-group col-md-6">
                                    <img id="blah" src="{{ asset('storage/church') }}/{{$church->church_image}}" height="200px" width="200px" alt="your image"> 
                              </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">{{ __('Update')}}</button>
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
@endsection 
@push('script')
<script type="text/javascript">
    var routeLatitude = "{{ route('churches.check')}}?latitude=";
    var routeLongitude = "{{ route('churches.check')}}?longitude=";
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
    });

    $("#email").change(function(e){
        e.preventDefault();
        var email = document.getElementById("email").value;
        $.ajax({
            url: "{{ route('churches.check')}}?email="+email+"&church_id={{$church->id}}", 
            success: function(response){
                if(response.status == '200')
                {
                    document.getElementById("email-error").classList.add("hide");
                }else{
                    document.getElementById("email").value = "";
                    document.getElementById("email-error").classList.remove("hide");
                    document.getElementById("email-error").innerHTML = response.message;
                }
            },errors: function(errors){
                console.log('errors:', errors)
                alert("errors:.", errors)
            }
        });
    });

    $("#password").change(function(e){
          passwordCheck();
    });
    $("#password_confirmation").change(function(e){
          passwordCheck();
    });
    function passwordCheck(){
        var password = document.getElementById("password").value;
        var password_confirmation = document.getElementById("password_confirmation").value;


        if(password_confirmation && password && (password_confirmation != password) )
        {
            // document.getElementById("password").value = "";
            document.getElementById("password_confirmation").value = "";
            document.getElementById("password-error").classList.remove("hide");
            document.getElementById("password-error").innerHTML = "The password confirmation does not match.";
        }else{
            document.getElementById("password-error").classList.add("hide");
        }
    }

    function readURL(input) {
        var fileName = document.getElementById("church_image").value;
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
            document.getElementById("church_image").value = null;
            $('#blah').attr('src', '')
            alert("Only jpg/jpeg and png Image are allowed!");
        }   
    }   

    $(document).ready(function(){
          
       $('#showPass').on('click', function(){
          var passInput=$("#password");
          if(passInput.attr('type')==='password')
            {
              passInput.attr('type','text');
          }else{
             passInput.attr('type','password');
          }
          var passInput=$("#password_confirmation");
          if(passInput.attr('type')==='password')
            {
              passInput.attr('type','text');
          }else{
             passInput.attr('type','password');
          }
      })
    })
</script>
@endpush
