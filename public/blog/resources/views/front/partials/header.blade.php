<section class="sticky-header">
    <div class="container">
       <header>
          <div class="navbar d-flex justify-content-between align-items-center">
             <a href="{{route('/')}}"><img src="{{asset('/')}}assets/img/logo/logo.png" alt=""></a>
             <div class="navbars" id="navbars">
                <!-- <button class="close-nav" ><i class="fas fa-times-circle"></i></button> -->
                <ul class="nav list-unstyled  d-md-flex d-inline-block mt-md-0 ">
                   <li class="nav-item"><a href="{{route('/')}}" class="nav-link {{ ( Route::currentRouteName() == '/' ) ? ' active-page' : '' }}">Home</a>
                   </li class="nav-item">
                   <li class="nav-item"><a href="{{asset('our-products')}}" class="nav-link  {{ ( Route::currentRouteName() == 'our.products' ) ? ' active-page' : '' }}">Our Products</a></li>
                   <li class="nav-item"><a href="{{route('about.us')}}" class="nav-link {{ ( Route::currentRouteName() == 'about.us' ) ? ' active-page' : '' }}">About us</a></li>
                   <li class="nav-item"><a href="{{route('contact.us')}}" class="nav-link {{ ( Route::currentRouteName() == 'contact.us' ) ? ' active-page' : '' }}">Contact</a></li>
                </ul>
             </div>
             <!-- <div class="menu-trigger"><button><i class="nav-icon  fas fa-bars"></i></button></div> -->
             <div class="menu-trigger">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
             </div>
          </div>
       </header>
    </div>
</section>