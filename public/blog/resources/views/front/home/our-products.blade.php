@extends('front.layouts.master')
@section('title', ' | Corrugated Box')

@section('content')
<!-- ========== PRODUCT CATEGORIES ========== -->
<section class="product-categories mt-140" id="products">
    <div class="container">

      <h2 class="section-title"> Product Categories</h2>
      <div class="product-boxs mt-50"> 
         @includeIf('front.home.products.list', ['products' => all_products()])
      </div>
        
    </div>
 </section>

@endsection

@section('js_script')
<script>
    $('#products').removeClass('mt-140');
</script>
@endsection