@extends('admin.layouts.master')
@section('title', 'All Contact US List')

@push('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
@endpush

@section('breadcrumb-title')
    <h1>All Contact US List</h1>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page">{{ __('Contact US List')}}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Index')}}</li>
@stop

@section('content')
    @include('admin.components.breadcrumb')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tech-data-table" class="tech-data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Service</th>
                                    <th>Message</th>
                                    <th>Status</th>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

<script>

$(document).ajaxComplete(function(){
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    $(".badge-info").click(function(){
        // $(".badge-info").css({"cursor":"pointer"});
        var id = $(this).attr("data-id");
        var url = "{{ route('admin.update_contact.index',['id']) }}";
        url = url.replace('id',id);
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                if(data.msg == true){
                    toastr.success('Contact status updated successfully');
                    setTimeout(function () {
                        location.reload(true);
                    }, 1000);
                }
            }
        });
    });
});
 $(function () {
        var table = $('.tech-data-table').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.contact.us.index') }}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'mobile_no', name: 'mobile_no'},
            {data: 'service', name: 'service'},
            {data: 'message', name: 'message'},
            {data: 'status', name: 'status'},
            ]
        }).buttons().container().appendTo('#tech-data-table .col-md-6:eq(0)');
    });
</script>
@endpush