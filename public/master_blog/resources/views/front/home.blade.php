<!doctype html>
<html class="no-js" lang="en">
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Master Blog Admin</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- themekit admin template asstes -->
        <link rel="stylesheet" href="{{ asset('all.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/icon-kit/dist/css/iconkit.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/ionicons/dist/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>

    <body>
		<div class="container">
      <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
          
          <div class="col-4 text-center">
            <a class="blog-header-logo text-dark" href="#">Home</a>
          </div>
          <div class="col-4 d-flex justify-content-end align-items-center">
            <a class="text-muted" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
            </a>
            @if (auth()->check() &&  auth()->user()->hasRole('role_admin') )
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.dashboard') }}">Dashboard</a>
            @elseif (auth()->check() &&  auth()->user()->hasRole('role_author') )
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('author.dashboard') }}">Dashboard</a>
            @else
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Sign In</a>
            @endif
          </div>
        </div>
      </header>

      <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
          <h1 class="display-4 font-italic">Title of a longer featured blog post</h1>
          <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what's most interesting in this post's contents.</p>
          <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
        </div>
      </div>

      <div class="row mb-2">
        @if(count($blogs) > 0)        
            @forelse ($blogs as $blog)
              <div class="col-md-6">
                  <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                      <strong class="d-inline-block mb-2 text-primary text-capitalize">{{$blog->category}}</strong>
                      <h3 class="mb-0">
                        <a class="text-dark text-capitalize" href="{{ route('/') }}/{{$blog->slug}}">{{$blog->title}}</a>
                      </h3>
                      <div class="mb-1 text-muted">
                        <?php 
                            $date = str_replace('/', '-', $blog->publish_date );
                            echo $newDate = date("d F", strtotime($date));
                        ?>
                      </div>
                      <p class="card-text mb-auto text-capitalize">{{ $blog->meta_description }}</p>
                      <a href="{{ route('single.blog.show', $blog->slug) }}">Continue reading</a>
                    </div>
                    @if (File::exists(store_blog_path().$blog->feature_image)) 
                        <img class="card-img-right flex-auto d-none d-md-block" data-src="{{ route('/') }}{{ $blog->slug }}" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="{{ blog_public_path().$blog->feature_image }}" data-holder-rendered="true">
                    @endif 
                    
                  </div>
                </div>
          @empty
              <!-- <p>No Blogs</p> -->
          @endforelse
      @endif  
      	
        
        {{--  <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-success">Design</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">Post title</a>
              </h3>
              <div class="mb-1 text-muted">Nov 11</div>
              <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
              <a href="#">Continue reading</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block" data-src="holder.js/200x250?theme=thumb" alt="Thumbnail [200x250]" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20250%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17c50133a93%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17c50133a93%22%3E%3Crect%20width%3D%22200%22%20height%3D%22250%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2256.1953125%22%20y%3D%22131%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="width: 200px; height: 250px;">
          </div>
        </div>   --}}
      </div>
    </div>
		<script src="{{ asset('all.js') }}"></script>
        
    </body>
</html>

