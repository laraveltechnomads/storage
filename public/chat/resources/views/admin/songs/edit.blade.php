@extends('admin.layouts.master')
@section('title', 'Edit Song')

@push('style')
@endpush

@section('breadcrumb-title')
    <h1>Edit Song</h1>
    <a href="{{ route('admin.songs.index') }}" tooltip="Songs List" class="badge badge-primary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.songs.index') }}">{{ __('Songs')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')}}</li>
@stop
@section('content')
    @include('admin.components.breadcrumb')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card">
                    <div class="card-body">
                        <form class="forms-sample" id="blogForm" action="{{ route('admin.songs.update', [$song->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group col-md-6">
                                <label for="song_name">{{ __('Song Name')}}</label>
                                <input type="text" class="form-control @error('song_name') is-invalid @enderror" id="song_name" name="song_name" placeholder="Song Name" value="{{old('song_name', @$song->song_name)}}" required="">
                                    <span></span>
                                <span class="text-red hide" id="song-name-error"; role="alert"></span>
                                @error('song_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="song_link">{{ __('Song Link')}}</label>
                                <input type="text" class="form-control @error('song_link') is-invalid @enderror" id="song_link" name="song_link" placeholder="Song Link" value="{{old('song_link', @$song->song_link)}}" required="">
                                    <span></span>
                                <span class="text-red hide" id="song-name-error"; role="alert"></span>
                                @error('song_link')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">{{ __('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#blah').hide();
            // $('.note').hide();
        });

        $(function () {
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

        $("#song_name").change(function(e){
            // e.preventDefault();
            var song_name = document.getElementById("song_name").value;
            console.log('song_name:', song_name)
            $.ajax({
                url: "{{ route('songs.check')}}?song_name="+song_name+"&song_id={{$song->id}}", 
                success: function(response){
                    if(response.status == '200')
                    {
                        document.getElementById("song-name-error").classList.add("hide");
                    }else{
                        document.getElementById("song_name").value = "";
                        document.getElementById("song-name-error").classList.remove("hide");
                        document.getElementById("song-name-error").innerHTML = response.message;
                    }
                },errors: function(errors){
                    console.log('errors:', errors)
                    alert("errors:.", errors)
                }
            });
        });
    </script>
@endpush
