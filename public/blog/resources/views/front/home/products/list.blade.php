<div class="row">
    @php
       $products = all_products();
    @endphp
    @forelse ($products as $key =>  $product)
       <div class="col-lg-6" style="margin-bottom:2%;">
          @php
             $product_slug = route("product_slug", [$product->product_slug]); 
             $product_image_url = product_file_show($product->product_image); 
             $product_name = Str::title($product->product_name); 
             $product_description = $product->product_description; 
             // echo $loop->iteration;
          @endphp
          <div class="product-outer-box">
             <div class="product-box-bg">
                <div class="row align-items-center">
                   <div class="col-sm-6 text-md-start text-center text-md-start text-center">
                      <a href="{{$product_slug}}"> <img src="{{$product_image_url}}" alt=""
                            class="img-fluid img-size"></a>
                   </div>
                   <div class="col-sm-6 text-md-start text-center">
                      <h3 class="product-title"> <a href="{{$product_slug}}"> {{$product_name}} </a></h3>
                      <p class="product-description"><a href="{{$product_slug}}"> {{$product_description}}</a>
                      </p>
                      <a href="{{$product_slug}}" class="learn-more">LEARN MORE <img
                            src="{{asset('/')}}assets/img/home/more-details.png" alt="" class="img-fluid">
                      </a>
                   </div>
                </div>
             </div>
          </div>
       </div>
    @empty
       <div class="col-lg-12" style="margin-bottom:2%;">
          <div class="product-outer-box">  
          </div>
       </div>
    @endforelse
</div>