@extends('author.layouts.master') 
@section('title', 'All Blogs')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/datatables/dataTables.bootstrap4.min.css') }}">
    @endpush
 
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-inbox bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('All Blogs')}}</h5>
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
                                <a href="#">Blogs</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Index</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="template-demo">
                        <a href="{{route('author.blogs.create')}}" class="btn btn-primary">{{ __('Add Blog')}} <i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">
                         <table class="table table-bordered blog-data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Meta Title</th>
                                    <th>Author</th>
                                    <th>Blog Url</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
 {{--                    <div class="card-body">
                        <table id="data_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('#')}}</th>
                                    <th>{{ __('Title')}}</th>
                                    <th>{{ __('Meta Title')}}</th>
                                    <th>{{ __('Author')}}</th>
                                    <th>{{ __('Slug')}}</th>
                                    <th class="nosort">{{ __('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blogs as $blog)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $blog->title}}</td>
                                        <td>{{ $blog->meta_title }}</td>
                                        <td>{{ $blog->author }}</td>
                                        <td>{{ $blog->slug }}</td>
                                        <td>
                                            @if($author->id == $blog->user_id) 
                                                <div class="table-actions">
                                                    <a href="#"><i class="ik ik-eye"></i></a>
                                                    <a href="#"><i class="ik ik-edit-2"></i></a>
                                                    <a href="#"><i class="ik ik-trash-2"></i></a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <p>No users</p>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    @include('components.modal')
    <!-- push external js -->
    @push('script')
        <script type="text/javascript" src="{{ asset('admin/js/datatables/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admin/js/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admin/js/custom.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
    @endpush
    <script type="text/javascript">
        var modalRoutesShow = "{{route('author.blog.show')}}";
        var deleteRoute = "{{route('author.blog.destroy.id')}}";

        $(function () {
            var table = $('.blog-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('author.blogs.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'meta_title', name: 'meta_title'},
                    {data: 'author', name: 'author'},
                    {data: 'slug', name: 'slug'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection
      
