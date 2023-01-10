<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="UTF-8">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="Technomads.in">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Facebook Meta Tags -->
   <meta property="og:url" content="http://roltonn.hostappshere.co.in/">
   <meta property="og:type" content="website">
   <meta property="og:title" content="{{config('app.name')}} | Best Packaging Solutions">
   <meta property="og:description" content="{{config('app.name')}} | Best Packaging Solutions">
   <meta property="og:image" content="https://res.cloudinary.com/dqffs1rxq/image/upload/v1657021933/roltonn_bfy7rc.png">

   <!-- Twitter Meta Tags -->
   <meta name="twitter:card" content="summary_large_image">
   <meta property="twitter:domain" content="roltonn.hostappshere.co.in">
   <meta property="twitter:url" content="http://roltonn.hostappshere.co.in/">
   <meta name="twitter:title" content="{{config('app.name')}} | Best Packaging Solutions">
   <meta name="twitter:description" content="{{config('app.name')}} | Best Packaging Solutions">
   <meta name="twitter:image"
      content="https://res.cloudinary.com/dqffs1rxq/image/upload/v1657021933/roltonn_bfy7rc.png">

   <!-- ======= TITLE ======= -->
   <title>{{config('app.name')}} @yield('title') </title>


   <!-- ======= FAVICON ======= -->
   @if(View::exists('front.partials.css'))
      @include('front.partials.css')
   @endif
</head>

<body>
   <!-- ========== HEADER ========== -->
   @if(View::exists('front.partials.header'))
      @include('front.partials.header')
   @endif

    @yield('content')
  
    <!-- ==========  CONTACT US ========== -->
    @if(View::exists('front.partials.contact-us'))
        @include('front.partials.contact-us')
    @endif

   <!-- ========== FOOTER  ========== -->
   @if(View::exists('front.partials.footer'))
      @include('front.partials.footer')
   @endif

   <!-- jQuery library -->
   @if(View::exists('front.partials.js'))
      @include('front.partials.js')
   @endif
</body>

</html>