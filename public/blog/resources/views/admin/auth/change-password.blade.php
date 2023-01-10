@extends('admin.layouts.master')
@section('title', 'Change Password')

@section('content')
<section class="content-header">   
</section>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Change Password</div>
   
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.change.password') }}">
                        @csrf 
                         <div class="form-group row">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">Current Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required value="{{old('current_password')}}">
                                <span class="text-red">{{ $errors->first('current_password') }}</span>
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" autocomplete="off" required>
                                <span class="text-red">{{ $errors->first('new_password') }}</span>
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>
    
                            <div class="col-md-6">
                                <input id="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" autocomplete="off" required>
                                <span class="text-red">{{ $errors->first('confirm_password') }}</span>
                            </div>
                        </div>
   
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{--   
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
</div> --}}
@endsection
@push('script')
@endpush
