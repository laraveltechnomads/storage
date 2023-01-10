@extends('front.layouts.master')
@section('title', ' | Paper Core')

@section('content')
<section class="common-banner">
    <div class="paper-core-bg">
       <div class="container">
          <div class="row justify-content-center">
             <div class="col-xl-6 col-md-9">
                <h2 class="title">Paper core division</h2>
                <p class="description">Paper cores are strong cardboard tubes or cylinders used in electrical, fabric, paper or adhesive packaging – generally as a sturdy core or base around which the material is wound for storage or distribution.
                </p>
             </div>
          </div>
       </div>
    </div>
 </section>
 <section class="paper-core mt-140">
    <div class="container">
       <div class="row align-items-center">
          <div class="col-md-6">
             <h2 class="sub-title">SALIENT FEATURES:</h2>
             <p class="sub-description">We manufacture high compression strength cores in custom built drying chambers where the drying the product ensures the strength is maintained. Our machines specs are high end with high speed slitter/ rewinder and spiral winding capabilities. We have options of printed cores too where the client can choose to print their logo.<br>Superior Manufacturing Processes to ensure that our cores offer the highest in
                quality, performing under the toughest packaging demands
             </p>
             <h2 class="sub-title">INDUSTRY USE:</h2>
             <p class="sub-description">BOPP Films, Cables and Wires, Flexible Packaging, packing of Furnishing
                Fabrics, Packing of Denims, PP Strapping, Texturizing, Packing of Carpet, Multi-Layer Films, Paper
                Industry, Aluminium Foils, Polyester Films, Asbestos Industry, Kraft Paper Mills etc.
             </p>
           
          </div>
          <div class="col-md-6">
             <img src="{{asset('/')}}assets/img/paper-core/silent.png" alt="" class="img-fluid">
          </div>
       </div>
       <div class="container table-responsive px-0 mt-5">

          <h2 class="sub-title">SPECIFICATION:</h2>
          <table class="table">
             <thead class="thead-sky">
                <tr>
                   <th scope="col"></th>
                   <th scope="col">Range</th>
                </tr>
             </thead>
             <tbody>
                <tr>
                   <th scope="row">Internal Diameter</th>
                   <td>1 inch to 22 inch</td>
                </tr>
                <tr>
                   <th scope="row">Core Thickness </th>
                   <td>2 mm to 25 mm</td>
                </tr>
                <tr>
                   <th scope="row">Core Length </th>
                   <td>up to 8,000 mm</td>
                </tr>
                <tr>
                   <th scope="row">Radial Compression Strength</th>
                   <td>up to 1,000 kgf / 100 mm Core Length</td>
                </tr>
                <tr>
                   <th scope="row">Inner and Outer Surface </th>
                   <td>Plain Kraft, White, up to 8 colour printing, Grinded and Wax Coated, <br> Polycoated,
                      Embossed, Knurled among others
                   </td>
                </tr>
             </tbody>
          </table>
       </div>

    </div>
 </section>
 <section class="corrugated-box types-and-qulity mt-140 new-paper-core">
    <div class="container">
       <div class="row justify-content-center">
          <div class="col-xl-3 col-md-6">
             <div class="product-box content">
                <div class="text-center">
                   <img src="{{asset('/')}}assets/img/paper-core/product-one.png" alt="" class="img-fluid">
                </div>
             </div>
          </div>
          <div class="col-xl-3 col-md-6">
             <div class="product-box content">
                <div class="text-center">
                   <img src="{{asset('/')}}assets/img/paper-core/product-two.png" alt="" class="img-fluid">
                </div>
             </div>
          </div>
          <div class="col-xl-3 col-md-6">
             <div class="product-box content">
                <div class="text-center">
                   <img src="{{asset('/')}}assets/img/paper-core/product-three.png" alt="" class="img-fluid">
                </div>
             </div>
          </div>
          <div class="col-xl-3 col-md-6">
             <div class="product-box content">
                <div class="text-center">
                   <img src="{{asset('/')}}assets/img/paper-core/product-four.png" alt="" class="img-fluid">
                </div>
             </div>
          </div>
       </div>
    </div>
</section>
@endsection

@section('js_script')
@endsection
