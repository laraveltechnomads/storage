@extends('front.layouts.master')
@section('title', ' | Best Packaging Solutions')

@section('content')
<div class="slider">
   <div class="item">
      <div class="first-banner-wrapper first-banner-image">
         <div class="overlay"></div>
         <div class="container">
            <div class="about-banner">
               <h1 class="banner-title"> Leading Manufacturer of Premium Corrugated Box </h1>
               <p class="banner-description">Custom packaging and boxes can turn your brand into the total package
                  with full customization, instant quoting, and fast turnarounds.
               </p>
               <button>GET QUOTATION</button>
            </div>
         </div>
      </div>
   </div>
   <div class="item">
      <div class="first-banner-wrapper second-banner-image">
         <div class="overlay"></div>
         <div class="container">
            <div class="about-banner">
               <h1 class="banner-title"> Leading Manufacturer of Premium Corrugated Box </h1>
               <p class="banner-description">Custom packaging and boxes can turn your brand into the total package
                  with full customization, instant quoting, and fast turnarounds.
               </p>
               <button>GET QUOTATION</button>
            </div>
         </div>
      </div>
   </div>
   <div class="item">
      <div class="first-banner-wrapper third-banner-image">
         <div class="overlay"></div>
         <div class="container">
            <div class="about-banner">
               <h1 class="banner-title"> Leading Manufacturer of Premium Corrugated Box </h1>
               <p class="banner-description">Custom packaging and boxes can turn your brand into the total package
                  with full customization, instant quoting, and fast turnarounds.
               </p>
               <button>GET QUOTATION</button>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- ========== ROLTONN ========== -->
<section class="about-roltonn mt-140">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-lg-6 text-lg-start text-center order-lg-1 order-2">
            <img src="{{asset('/')}}assets/img/home/about-roltonn.png" alt="" class="img-fluid">
         </div>
         <div class="col-lg-6 order-lg-2 order-1">
            <h2 class="section-title" data-aos="fade-up" data-aos-duration="500">
               About Roltonn
            </h2>
            <p class="description" data-aos="fade-up" data-aos-duration="1500" data-aos-duration="500">Established in 2016, <b>Roltonn packaging solutions</b> s a manufacturer of corrugated boxes, edge/angle boards, paper core pipes and tubes and paper bags. The Company’s USP is core customization, be it shape, size or using specific printing for delivering the final packaging solution to the client. The range of products are varied types of eco-friendly, recyclable, space optimized, durable packaging solutions that fit all sorts of needs and requirements.
            </p>
            <p class="description" data-aos="fade-up" data-aos-duration="1500" data-aos-duration="500">Most client’s major pain point is to achieve product specific packaging that allow them to safely transport their finished goods or products from plant/warehouse to showrooms/customers and this is where Roltonn excels. The company’s belief in the traditional - Caveat Venditor approach assures all clients - utmost quality and reliability for timely deliveries of packaging that fits all their requirements.
            </p>
         </div>
      </div>
   </div>
</section>

<!-- ========== PRODUCT CATEGORIES ========== -->
<section class="product-categories mt-140" id="products">
   <div class="container">
      <h2 class="section-title" data-aos="fade-up" data-aos-duration="1500" data-aos-duration="500"> Product
         Categories
      </h2>
      <div class="product-boxs mt-81">
         @includeIf('front.home.products.list', ['products' => all_products()])
      </div>
   </div>
</section>

<!-- ========== PRODUCTION HISTORY  ========== -->
<section class="production-history mt-140">
   <div class="container">
      <div class="overlay"></div>
      <div class="counter" id="counter">
         <div class="row">
            <div class="col-lg-3 col-md-6 text-center pr-lg-0">
               <p class="counter-count counter-value" data-count="15">0</p>
               <img src="{{asset('/')}}assets/img/home/one.png" alt="" class="w-100 img-fluid">
               <p class="description">CORRUGATED BOXES
                  MANUFACTURED PER DAY
               </p>
            </div>
            <div class="col-lg-3 col-md-6 text-center px-lg-0">
               <p class="counter-count counter-value" data-count="15">0</p>
               <img src="{{asset('/')}}assets/img/home/two.png" alt="" class="w-100 img-fluid">
               <p class="description">PAPER CORE
                  PROCESSED PER DAY
               </p>
            </div>
            <div class="col-lg-3 col-md-6 text-center px-lg-0">
               <p class="counter-count counter-count-three counter-value" data-count="150">0</p>
               <img src="{{asset('/')}}assets/img/home/three.png" alt="" class="w-100 img-fluid">
               <p class="description">PAPER COURIER
                  PROCESSED PER DAY
               </p>
            </div>
            <div class="col-lg-3 col-md-6 text-center px-lg-0">
               <p class="counter-count counter-count-four counter-value" data-count="100" >0</p>
               <img src="{{asset('/')}}assets/img/home/four.png" alt="" class="w-100 img-fluid">
               <p class="description">ANGLE BOARD/ EDGE PROTECTORS
                  PROCESSED PER DAY
               </p>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- ========== INDUSTRIES SERVE ========== -->
<section class="industries-serve mt-140">
   <div class="container">
      <h2 class="section-title"> Industries we serve </h2>
      <div class="industries-serve-box mt-81">
         <div class="row">
            <div class="col-lg-3 col-sm-6 text-center" data-aos="zoom-in" data-aos-duration="1000">
               <div class="industries-serve-box-bg">
                  <img src="{{asset('/')}}assets/img/home/food.png" alt="" class="img-fluid">
                  <p class="industries-name">Food</p>
               </div>
            </div>
            <div class="col-lg-3 col-sm-6 text-center " data-aos="zoom-in" data-aos-duration="1000">
               <div class="industries-serve-box-bg">
                  <img src="{{asset('/')}}assets/img/home/healthcare.png" alt="" class="img-fluid">
                  <p class="industries-name">HealthCare</p>
               </div>
            </div>
            <div class="col-lg-3 col-sm-6 text-center " data-aos="zoom-in" data-aos-duration="1000">
               <div class="industries-serve-box-bg">
                  <img src="{{asset('/')}}assets/img/home/ecommerce.png" alt="" class="img-fluid">
                  <p class="industries-name">E-commerce </p>
               </div>
            </div>
            <div class="col-lg-3 col-sm-6 text-center " data-aos="zoom-in" data-aos-duration="1000">
               <div class="industries-serve-box-bg">
                  <img src="{{asset('/')}}assets/img/home/electronic.png" alt="" class="img-fluid">
                  <p class="industries-name">Electronic</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- ==========  DOWNLOAD BOCHURE ========== -->
<section class="download-brochure mt-140">
   <div class="brochure-bg">
      <div class="overlay"></div>
      <div class="container text-center">
         <button class=" button-3">Download Brochure</button>
      </div>
   </div>
</section>
@endsection

@section('js_script')
<script>
var a = 0;
$(window).scroll(function() {

   var oTop = $('#counter').offset().top - window.innerHeight;
   if (a == 0 && $(window).scrollTop() > oTop) {
      $('.counter-value').each(function() {
         var $this = $(this),
         countTo = $this.attr('data-count');
         $({
         countNum: $this.text()
         }).animate({
            countNum: countTo
         },
         {
            duration: 2500,
            easing: 'swing',
            step: function() {
               $this.text(Math.floor(this.countNum));
            },
            complete: function() {
               $this.text(this.countNum);
            }

         });
      });
      a = 1;
   }

});
</script>
@endsection