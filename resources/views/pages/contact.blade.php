<section class="col-main col-sm-12">
    <div id="contact" class="page-content page-contact">
      <div class="page-title">
        <h2>{{trans('contact.Contact Us')}}</h2>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-6" id="contact_form_map">
            <iframe width="100%" height="500px" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1605.811957341231!2d25.45976406005396!3d36.3940974010114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1550912388321"  allowfullscreen></iframe>
        </div>
        <div class="col-sm-6">
            <form action="{{url('/contact')}}" method="post">
                @csrf
            <div class="contact-form-box">
                <div class="form-selector">
                    <label for="name">{{trans('contact.First Name')}}</label>
                    <input type="text" class="form-control input-sm" id="name" name="first_name" placeholder="Enter Your name" required="">
                </div>
                <div class="form-selector">
                    <label for="email">{{trans('contact.Last Name')}}</label>
                    <input type="text" class="form-control input-sm" id="last-name" name="last_name" placeholder="Last Name" required="">
                </div>
                <div class="form-selector">
                    <label for="review">{{trans('contact.Phone number')}}</label>
                    <input type="text" class="form-control input-sm" id="review" name="phone" placeholder="Enter your number" required="">
                </div>
                <div class="form-selector">
                    <label for="email">{{trans('contact.Email')}}</label>
                    <input type="text" class="form-control input-sm" id="email" name="email" placeholder="Email" required="">
                </div>
                <div class="form-selector">
                    <label for="review">{{trans('contact.Write Your Message')}}</label>
                    <textarea class="form-control input-sm"name="message" placeholder="Write Your Message" id="exampleFormControlTextarea1" rows="2" required></textarea>
                </div>
                <div class="form-selector">
                <button class="button"><i class="icon-paper-plane icons"></i>&nbsp; <span>{{trans('contact.Send Message')}}</span></button>
                &nbsp; <a href="#" class="button">Clear</a> </div>
            </div>
            </form>
        </div>
      </div>
    </div>
</section>