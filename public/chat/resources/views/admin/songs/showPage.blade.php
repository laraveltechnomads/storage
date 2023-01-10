@extends('admin.layouts.master')
@section('title', 'Show Blog List')
@push('style')
@endpush
@section('breadcrumb-title')
    <h1>Blog</h1>
    <a href="{{ route('admin.blogs.index') }}" tooltip="Blogs List" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.blogs.index') }}">{{ __('Blogs')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Show')}}</li>
@stop
@section('content')
    @include('admin.components.breadcrumb')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Blog : {{$blog->title}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <th style="width: 15%;">{{ __('Author Name')}}</th>
                                        <td>: {{$blog->author}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Title')}}</th>
                                        <td>: {{$blog->title}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Meta Title')}}</th>
                                        <td>: {{ $blog->meta_title}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Meta Description')}}</th>
                                        <td>: {{ $blog->meta_description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tags</th>
                                        <td>: {{ tag_name($blog->tag_id)->implode(', ') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Image')}}</th>
                                        <td>:</td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td>
                                            <img src="{{ asset('images/blogs')}}/{{$blog->feature_image}}" height="200px" width="200px" alt="your image">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Description')}}</th>
                                        <td>:</td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td> {!! $blog->description !!} </td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
    </script>
@endpush