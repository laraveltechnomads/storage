<section class="content-header">   
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @yield('breadcrumb-title')
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                    @yield('breadcrumb-items')
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>