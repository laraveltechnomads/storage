<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- ======= JQUERY CDN ======= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- ======= AOS ======= -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- ======= SLICK SLIDER ======= -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
   integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
   crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- ======= CUSTOME JS ======= -->
<script src="{{asset('/')}}assets/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@yield('js_script')
<script>
   var contact_us_url = "{{ route('contact.us.form.send') }}";
   var newsletter_url =  "{{ route('newsletter.send') }}";
   
   @if(Session::has('success'))
       toastr.options =
       {
           "closeButton" : true,
           "progressBar" : true
       }
       toastr.success("{{ session('success') }}");
   @endif

   @if(Session::has('error'))
       toastr.options =
       {
           "closeButton" : true,
           "progressBar" : true
       }
       toastr.error("{{ session('error') }}");
   @endif

   @if(Session::has('info'))
       toastr.options =
       {
       "closeButton" : true,
       "progressBar" : true
       }
       toastr.info("{{ session('info') }}");
   @endif

   @if(Session::has('warning'))
       toastr.options =
       {
           "closeButton" : true,
           "progressBar" : true
       }
       toastr.warning("{{ session('warning') }}");
   @endif
</script>