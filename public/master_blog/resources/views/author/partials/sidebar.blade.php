<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp
    
    <!-- Brand Logo -->
    <a href="{{route('/')}}" class="brand-link">
        <img src="{{ asset('/')}}assets/logo/logo.png" alt="Admin Logo" class="brand-image"  />
        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                {{-- <li class="nav-item">
                    <a href="{{route('/')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li> --}}
                <li class="nav-item {{ ($segment2 == 'blogs') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('Blogs')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ ( Route::currentRouteName() == 'author.blogs.index' ) ? 'active' : '' }}">
                            <a href="{{route('author.blogs.index')}}" class="nav-link {{ ( Route::currentRouteName() == 'author.blogs.index' ) ? 'active' : '' }}">
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