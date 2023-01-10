<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
	<title>@yield('title','') | Cove</title>
	<!-- initiate head with meta tags, css and script -->
	@include('author.partials.head')

</head>
<body id="app" >
    <div class="wrapper">
    	<!-- initiate header-->
    	@include('author.partials.header')
    	<div class="page-wrap">
	    	<!-- initiate sidebar-->
	    	@include('author.partials.sidebar')

	    	<div class="main-content">
	    		@include('components.flash-message')
	    		<!-- yeild contents here -->
	    		@yield('content')
	    	</div>

	    	<!-- initiate chat section-->
	    	@include('author.partials.chat')


	    	<!-- initiate footer section-->
	    	@include('author.partials.footer')

    	</div>
    </div>
    
	<!-- initiate modal menu section-->
	@include('author.partials.modalmenu')

	<!-- initiate scripts-->
	@include('author.partials.script')	
</body>
</html>