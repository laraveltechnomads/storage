<!doctype html>
<html lang="en">
  <head>
    <script type="application/ld+json">		{
            "@context": "http://schema.org",
            "@type": "Article",
            "name": "{{ $blog->title }}",
            "author": {
                "@type": "person",  
                "name": "{{ $blog->author }}",
                "url": "{{ route('/') }}/{{ $blog->slug }}"
            },
            "datePublished": "{{ $blog->publish_date }}",
            "image": "{{ $blog->feature_image }}",
            "url": "{{ route('/') }}/{{ $blog->slug }}",
            "publisher": "Organisation",
            "mainEntityOfPage": "{{ $blog->title }}",
            "headline": "{{ $blog->title }}",
            "dateModified": "{{ date('Y-m-d' , strtotime($blog->updated_at) ) }}"
        }
    </script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Opengraph meta Tags -->
    <meta property="og:title" content="{{ $blog->meta_title }}" />
    <meta property="og:type" content="{{ $blog->categoy }}" /> 
    <meta property="og:url" content="{{ route('/') }}/{{ $blog->slug }}" />
    <meta property="og:image" content="{{ blog_public_path().$blog->feature_image}}" />
    <!-- Required meta tags -->
    <meta charset="utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="{{ $blog->meta_description }}" />
    <meta name="keywords" content="{{ $blog->meta_keywords }}" /> 
    <meta name="author" content="{{ $blog->author }}" />
    <meta name="robots" content="index, follow" /> 

    <link rel="icon" href="{{ asset('/')}}assets/logo/favicon.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>{{ $blog->title }}</title>
  </head>
  <body>

    <div class="container">
      <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
          <div class="col-4 text-center">
            {{--  <a class="blog-header-logo text-dark" href="{{ route('/') }}">Home</a>  --}}
          </div>
          <div class="col-4 d-flex justify-content-end align-items-center">
            {{--  <a class="text-muted" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
            </a>  --}}
            {{--  <a class="btn btn-sm btn-outline-secondary" href="#">Sign up</a>  --}}
          </div>
        </div>
      </header>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h3 class="pb-3 mb-4 font-italic border-bottom">
            <Article>Articles</Article>
          </h3>

          <div class="blog-post">
            <h2 class="blog-post-title text-capitalize">{{ $blog->title }}</h2>
            <p class="font-weight-bold">Published : {{ $blog->publish_date }}</p>
            
            <div class="col-md-12">
                @if (File::exists(store_blog_path().$blog->feature_image)) 
                    <img class="card-img-right flex-auto d-none d-md-block" data-src="{{ route('/') }}{{ $blog->slug }}" alt="Thumbnail [200x250]" src="{{ blog_public_path().$blog->feature_image }}" data-holder-rendered="true">
                @endif 
                <br>
            </div>
            <div style="word-break: break-all;">
                {!! $blog->description !!}
            </div> 
          </div>

        </div>
      </div><!-- /.row -->

    </div><!-- /.container -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>