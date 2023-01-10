@extends('admin.layouts.master')
@section('title', 'All Products')

@section('breadcrumb-title')
    <h1>All Products</h1>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page">{{ __('Products')}}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Index')}}</li>
@stop

@section('content')
    @include('admin.components.breadcrumb')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('admin.products.create')}}" class="btn btn-primary">{{ __('Add Product')}} <i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tech-data-table" class="tech-data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Product Name</th>
                                    <th>Product Description</th>
                                    <th>Product Slug</th>
                                    <th>Product Image</th>
                                    <th>Status</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script>

$(document).ajaxComplete(function(){
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
});
 $(function () {
        var table = $('.tech-data-table').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            processing: true,
            serverSide: false,
            ajax: "{{ route('admin.products.index') }}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'cat_name', name: 'cat_name'},
            {data: 'product_name', name: 'name'},
            {data: 'product_description', name: 'description'},
            {data: 'product_slug', name: 'slug'},
            {data: 'product_image', name: 'product_image'},
            {data: 'product_status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        }).buttons().container().appendTo('#tech-data-table .col-md-6:eq(0)');
    });
</script>
@endpush