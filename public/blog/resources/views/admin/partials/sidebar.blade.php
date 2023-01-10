<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #000 !important;">
    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp

    <!-- Brand Logo -->
    <a href="javascript::void(0);" class="brand-link">
        <img src="{{ asset('assets/admin/header_logo.png')}}" alt="Admin Logo" width="70px;" class="brand-image" style="margin-left: 2.5rem;/>
        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>
   
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
               
                <li class="nav-item {{ ( Route::currentRouteName() == 'admin.dashboard' ) ? 'active menu-open' : '' }}">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{ ($segment2 == 'category') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-list-alt"></i>
                        <p>{{ __('Category')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ ( Route::currentRouteName() == 'admin.category.index' ) ? 'active' : '' }}">
                            <a href="{{route('admin.category.index')}}" class="nav-link {{ ( Route::currentRouteName() == 'admin.category.index' ) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List')}}</p>
                            </a>
                        </li>
                    </ul>
                    </a>
                </li>

                <li class="nav-item {{ ($segment2 == 'products') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-window-restore" aria-hidden="true"></i>
                        <p>{{ __('Products')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.products.index')}}" class="nav-link {{ ( Route::currentRouteName() == 'admin.products.index' ) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List')}}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ ( Route::currentRouteName() == 'admin.contact.us.index' ) ? 'active menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-comment-alt" aria-hidden="true"></i>
                        <p>{{ __('Contact Us')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.contact.us.index')}}" class="nav-link {{ ( Route::currentRouteName() == 'admin.contact.us.index' ) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List')}}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ ( Route::currentRouteName() == 'admin.newsletter.index' ) ? 'active menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-bell" aria-hidden="true"></i>
                        <p>{{ __('Newsletter')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.newsletter.index')}}" class="nav-link {{ ( Route::currentRouteName() == 'admin.newsletter.index' ) ? 'active' : '' }}">
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