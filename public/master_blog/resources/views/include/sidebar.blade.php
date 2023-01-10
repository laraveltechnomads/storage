<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('author.dashboard')}}">
            <div class="logo-img">
               <img height="30" src="{{ asset('img/logo_white.png')}}" class="header-brand-img" title="RADMIN"> 
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp
    
    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('author.dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Author Dashboard')}}</span></a>
                </div>
                <div class="nav-lavel">{{ __('Pages')}} </div>
                <div class="nav-item {{ ($segment1 == 'blogs') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-edit"></i><span>{{ __('Blogs')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{route('blogs.index')}}" class="menu-item {{ ( Route::currentRouteName() == 'blogs.index' ) ? 'active' : '' }}">{{ __('Index')}}</a>
                        <a href="{{route('blogs.create')}}" class="menu-item {{ ( Route::currentRouteName() == 'blogs.create' ) ? 'active' : '' }}">{{ __('Create')}}</a>
                        <a href="{{route('blogs.edit')}}" class="menu-item {{ ( Route::currentRouteName() == 'blogs.edit' ) ? 'active' : '' }}">{{ __('Edit')}}</a>
                    </div>
                </div>
                
        </div>
    </div>
</div>