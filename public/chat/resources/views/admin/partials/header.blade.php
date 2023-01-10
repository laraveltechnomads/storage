<nav class="main-header navbar navbar-expand navbar-white navbar-light" id="refreshDivID">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto  bell-notification">
        <li class="nav-item dropdown bell-notification-show">
            <?php
                $userADM = \App\Models\User::find(1);
                $countNewUsers = $userADM->unreadNotifications->count();
            ?>
            <a class="nav-link ringing-bell" data-toggle="dropdown" href="#">
            <i class="fa fa-bell @if($countNewUsers > 0)faa-ring @endif animated" id="newUSerBell"></i>
                <span class="badge badge-warning navbar-badge" id="newUserCount">{{ $countNewUsers }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification-load">
                @include('admin.partials.notify')
            </div>

        </li>
        <li class="nav-item">
            <a class="nav-link" data-slide="true" href="{{ url('logout') }}" role="button">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <i class='fas fa-sign-out-alt fa-2x'></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-slide="true" role="button">
            </a>
        </li>
    </ul>
    
</nav>