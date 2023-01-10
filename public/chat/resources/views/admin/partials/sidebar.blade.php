<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp
    
    <!-- Brand Logo -->
    <a href="{{route('/')}}" class="brand-link">
        <img src="{{ project('app_logo_path') }}" alt="Admin Logo" class="brand-image"  />
        <span class="brand-text text-info">{{project('app_name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ ($segment2 == 'churches') || ($segment1 == 'events') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-church"  aria-hidden="true"></i>
                        <p>{{ __('Churches')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ ( Route::currentRouteName() == 'admin.churches.index' ) ? 'active' : '' }}">
                            <a href="{{route('admin.churches.index')}}" class="nav-link {{ ( Route::currentRouteName() == 'admin.churches.index' ) || ($segment1 == 'events') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List')}}</p>
                            </a>
                        </li>
                        @php
                            $church = \App\Models\Church::first();
                        @endphp
                        @if(!$church)
                        <li class="nav-item {{ ( Route::currentRouteName() == 'admin.churches.create' ) ? 'active' : '' }}">
                            <a href="{{route('admin.churches.create')}}" class="nav-link {{ ( Route::currentRouteName() == 'admin.churches.create' ) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Create')}}</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item {{ ( Route::currentRouteName() == 'calendar' ) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="{{route('calendar')}}" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>Calendar</p>
                    </a>
                </li>
                <li class="nav-item {{ ($segment2 == 'songs') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-music" aria-hidden="true"></i>
                        <p>{{ __('Songs')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ ( Route::currentRouteName() == 'admin.songs.index' ) ? 'active' : '' }}">
                            <a href="{{route('admin.songs.index')}}" class="nav-link {{ ( Route::currentRouteName() == 'admin.songs.index' ) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List')}}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ ($segment2 == 'users') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"  aria-hidden="true"></i>
                        <p>{{ __('Users')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ ( Route::currentRouteName() == 'admin.users.index' ) ? 'active' : '' }}">
                            <a href="{{route('admin.users.index')}}" class="nav-link {{ ( Route::currentRouteName() == 'admin.users.index' ) || ($segment1 == 'events') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List')}}</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>