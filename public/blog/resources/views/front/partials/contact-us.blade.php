<style>
   
</style>
<section class="contact-us mt-140" id="contact-us">
    <h2 class="section-title"> Contact Us </h2>
    <div class="contact-us-form">
       <div class="row mx-0">
          <div class="col-md-6 px-0">
             <div class="contact-form">
                <h4 class="sub-section-title">Send Message</h4>
                
                <div class="page-wrapper">
                  
                   <div class="content-wrapper">
                     
                      <form id="contact_us_form">
                        <span class="print-error-msg invalid-feedback" role="alert" style="display:none">
                           <strong><ul></ul></strong>
                        </span>
                           @csrf
                         <div class="field-wrapper">
                            <label for="name" id="name_id">Full name</label>
                            <input type="text" name="name" value="" id="name" class="text-field-input " required>
                         </div>
                         <div class="field-wrapper">
                            <label for="email" id="email_id">Your email</label>
                            <input type="email" name="email" value="" id="email" class="text-field-input " required>
                         </div>

                         <div class="field-wrapper">
                            <label for="tel" id="mobile_no_id">Phone number</label>
                            <input type="tel" name="mobile_no" value="" id="tel" class="text-field-input "
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               maxlength="10">
                         </div>
                         <div class="field-wrapper">
                            <label for="message" id="message_id">Message</label>
                            <textarea name="message" id="" cols="0" rows="" class="text-field-input " required></textarea>
                         </div>
                         <div class="text-center">
                            <button type="button"  id="contactForm"> {{ __('Send')}}</button>
                            <button id="spinnerUpdate" type="button" disabled>
                              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                              Loading...
                          </button>
                         </div>
                      </form>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-6 px-0">
             <div class="contact-bg">
                <div class="overlay"></div>
                <div class="p-absolute">
                   <div class="d-flex  align-items-center">
                      <div>
                         <img src="{{asset('/')}}assets/img/home/call.png" alt="">
                      </div>
                      <div class="contact-number">
                         <a href="tel:+919016308972">+91 9016308972</a>
                         <a href="tel:+918411927131">+91 8411927131</a>
                      </div>
                   </div>
                   <div class="d-flex  align-items-center email-id">
                      <div>
                         <img src="{{asset('/')}}assets/img/home/location.png" alt="">
                      </div>
                      <div class="contact-number">
                         <a href="#">
                           Plot no. C16/5, Road no. 5, Hoziwala Industrial Estate, Sachin - Palsana Highway, Sachin, Surat, Gujarat 394315
                         </a>
                      </div>
                   </div>
                   <div class="d-flex  align-items-center">
                      <div>
                         <img src="{{asset('/')}}assets/img/home/email.png" alt="">
                      </div>
                      <div class="contact-number">
                         <a href="mailto: {{project('app_contact_email')}}">{{project('app_contact_email')}}</a>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</section>