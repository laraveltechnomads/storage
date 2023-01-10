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

        <div class="col-md-6">
            <div class="card-body template-demo">
                <button type="button" class="btn btn-primary"><a href="{{route('blogs.create')}}">{{ __('New')}}</a></button>
             </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Blog List')}}</h3></div>
                    <div class="card-body">
                        <table id="data_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Title')}}</th>
                                    <th class="nosort">{{ __('Image')}}</th>
                                    <th>{{ __('Tag')}}</th>
                                    <th>{{ __('author')}}</th>
                                    <th class="nosort">{{ __('&nbsp;')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blogs as $blog)
                                    <tr>
                                        <td>{{ $blog->title}}</td>
                                        <td><img src="{{ asset('/') }}img/user.jpg" class="table-user-thumb" alt=""></td>
                                        <td>{{ $blog->tag_name }}</td>
                                        <td>{{ $blog->author }}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- push external js -->
    @push('script')
        <script type="text/javascript" src="{{ asset('admin/js/datatables/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admin/js/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admin/js/custom.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugins/summernote/dist/summernote-bs4.min.js') }}"></script>

        <script type="text/javascript">
            var modalRoutesShow = "{{route('admin.product.show')}}";    
            var deleteRoute = "{{route('admin.product.destroy.id')}}";
        </script>
    @endpush
@endsection
      
