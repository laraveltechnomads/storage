<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('/')}}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-slide="true" href="{{ route('logout-user') }}" role="button">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <i class='fas fa-sign-out-alt fa-2x' style='color:black'></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-slide="true" role="button">
            </a>
        </li>
    </ul>
</nav>