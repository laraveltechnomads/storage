<section class="footer">
   <div class="container">
      <div class="row">
         <div class="col-md-5 col-12">
            <a href="{{route('/')}}"> <img src="{{asset('/')}}assets/img/logo/footer-logo.png" alt=""></a>
            <p class="footer-address">Plot no. C16/5, Road no. 5, Hoziwala Industrial Estate,<br> Sachin - Palsana Highway, Sachin, Surat<br> Gujarat 394315
            </p>
            <div class="social-media d-flex">

               <a href="#">
                  <div class="social-mdeia-box position-relative">
                     <div class="position-absolute">
                        <img src="{{asset('/')}}assets/img/social-icon/twitter.svg" alt="" class="white-icon">
                        <img src="{{asset('/')}}assets/img/social-icon/twitter-blue.svg" alt="" class="blue-icon">

                     </div>
                  </div>
               </a>
               <a href="#">
                  <div class="social-mdeia-box position-relative">
                     <div class="position-absolute">
                        <img src="{{asset('/')}}assets/img/social-icon/instagram.svg" alt="" class="white-icon">
                        <img src="{{asset('/')}}assets/img/social-icon/instagram-blue.svg" alt="" class="blue-icon">

                     </div>
                  </div>
               </a>
               <a href="#">
                  <div class="social-mdeia-box position-relative">
                     <div class="position-absolute">
                        <img src="{{asset('/')}}assets/img/social-icon/facebook.svg" alt="" class="white-icon">
                        <img src="{{asset('/')}}assets/img/social-icon/facebook-blue.svg" alt="" class="blue-icon">

                     </div>
                  </div>
               </a>
            </div>
         </div>
         <div class="col-md-2 col-6 footer-products">
            <h4 class="title"> Products </h4>
            <ul class="list-unstyled">
               <li><a href="{{route('corrugated.box')}}"> Corrugated box </a></li>
               <li><a href="{{route('paper.core')}}"> Paper core</a></li>
               <li><a href="{{route('angle.boards')}}"> Angle boards </a></li>
               <li><a href="{{route('paper.courier')}}">Paper courier</a></li>
            </ul>
         </div>
         <div class="col-md-2 col-6 footer-products">
            <h4 class="title"> Company </h4>
            <ul class="list-unstyled">
               <li><a href="{{route('about.us')}}"> About Us </a></li>
               <li><a href="{{route('contact.us')}}"> Contact Us</a></li>
            </ul>
         </div>
         <div class="col-md-3 footer-products mt-md-0 mt-4">
            <div class="newsletters">
               <h4 class="title">Newsletter </h4>
               <form id="newsletter_us_form">
                  @csrf
                  <div class="position-relative">
                     <input type="text" name="email_address" placeholder="Enter your email id" autocomplete="off">
                     <button type="button" id="sletterSubmit" class="newletter-btn"> <img src="{{asset('/')}}assets/img/social-icon/newsletter.png"
                           alt=""></button>
                  </div>
               </form>
            </div>
            <p class="about-newsletter">
            </p>
         </div>
      </div>
      <div class="text-center">
         <p class="copyright">© 2022 {{project('app_name')}} | Powered <a href="https://technomads.in/"> TechNomads Solutions Pvt Ltd
            </a></p>
      </div>
   </div>
</section>