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
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-user-circle fa-2x"></i>
              <span class="badge badge-warning navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
              <a href="{{route('change.password.page')}}" class="dropdown-item">
                <i class="fas fa-key mr-2"></i> Change Password
                <span class="float-right text-muted text-sm"></span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item" role="button" onclick="return confirm('Are you sure want to logout?');">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </a>
            </div>
        </li>
    </ul>
</nav>