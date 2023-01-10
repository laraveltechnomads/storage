<script src="{{asset('/')}}assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/')}}assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('/')}}assets/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/')}}assets/admin/dist/js/demo.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    @if(Session::has('success'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
        toastr.options =
        {
        "closeButton" : true,
        "progressBar" : true
        }
        toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.warning("{{ session('warning') }}");
    @endif
</script>
<link rel="stylesheet" href="{{asset('/')}}assets/admin/custom.js">

<script>
    function deleteShowFun(id)
    {
        console.log(id)
        swal({
            title: "Are you sure?",
            text: "Do you really want to delete this list?",
            icon: "warning",
            buttons: ["Cancel", "Delete Now"],
            dangerMode: true,
        })
        .then((willDelete) => {
                console.log('id', id)
            if (willDelete) {
                $.ajax({
                    type:'POST',
                    url: deleteRoute,
                    data:{id:id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data){
                    console.log('data:', data )
                    if(data == 1)
                    {
                        swal({
                            title: "Deleted",
                            text: "The list has been deleted!",
                            icon: "success",
                        });
                        location.reload(true);
                    }else{
                            swal("The list is not deleted!");
                        }
                    }
                });
            } else {
                swal("The list is not deleted!");
            }
        });
    }
</script>