<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
        $church_user_id = 0;
        if (auth()->user()->u_type == 'CHR') {
            $church_user_id = auth()->user()->id;
        }
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
                    <a href="{{route('church.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ ( Route::currentRouteName() == 'church.show' ) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="{{route('church.show')}}" class="nav-link">
                        <i class="nav-icon fas fa-church"></i>
                        <p>Church Profile</p>
                    </a>
                </li>
                <li class="nav-item {{ ($segment1 == 'events') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-calendar" aria-hidden="true"></i>
                        <p>{{ __('Events')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ ( Route::currentRouteName() == 'events.index' ) ? 'active' : '' }}">
                            <a href="{{route('events.index', ['church_user_id' => $church_user_id])}}" class="nav-link {{ ( Route::currentRouteName() == 'events.index' ) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List')}}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ ( Route::currentRouteName() == 'calendar' ) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="{{route('calendar')}}" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>Calendar</p>
                    </a>
                </li>
                <li class="nav-item {{ ($segment1 == 'banners') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-image" aria-hidden="true"></i>
                        <p>{{ __('Banners')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ ( Route::currentRouteName() == 'banners.list' ) ? 'active' : '' }}">
                            <a href="{{route('banners.list', ['u_type' => auth()->user()->u_type, 'church_id' => auth()->user()->church->id])}}" class="nav-link {{ ( Route::currentRouteName() == 'banners.list' ) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List')}}</p>
                            </a>
                        </li>
                        <li class="nav-item {{ ( Route::currentRouteName() == 'banners.create' ) ? 'active' : '' }}">
                            <a href="{{route('banners.create', ['u_type' => auth()->user()->u_type, 'church_id' => auth()->user()->church->id])}}" class="nav-link {{ ( Route::currentRouteName() == 'banners.create' ) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Create')}}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ ( Route::currentRouteName() == 'church.contactus.index' ) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="{{route('church.contactus.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Contactus</p>
                    </a>
                </li>
                <li class="nav-item {{ ( Route::currentRouteName() == 'church.workus.index' ) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="{{route('church.workus.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-envelope-open-text"></i>
                        <p>Work with Us</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>