<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('author.dashboard')}}">
            <div class="logo-img">
               <img width="100" src="{{ asset('admin/img/logo_white.png')}}" class="header-brand-img" title="RADMIN"> 
            </div>
        </a>
        {{-- <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div> --}}
        {{-- <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button> --}}
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp
    
    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment2 == 'blogs') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-edit"></i><span>{{ __('Blogs')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{route('author.blogs.index')}}" class="menu-item {{ ( Route::currentRouteName() == 'author.blogs.index' ) ? 'active' : '' }}">{{ __('List')}}</a>
                        <a href="{{route('author.blogs.create')}}" class="menu-item {{ ( Route::currentRouteName() == 'author.blogs.create' ) ? 'active' : '' }}">{{ __('Add Blog')}}</a>
                    </div>
                </div>   
            </nav>
        </div>
    </div>
</div>