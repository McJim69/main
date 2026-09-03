<?php
	require("connect.php");
	require("header.php");
	require("menunav.php");
?>

<script>setActive("contact");</script>

<style>
@media(max-width:760px){.mobile{padding:0;margin:0}}
</style>

<!-- Page Content -->
    <div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp)no-repeat;background-size:cover;background-position:center center">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>Contact Us</h1>
            <span>feel free to send us a message</span>
          </div>
        </div>
      </div>
    </div>
    <div class="contact-information">
      <div class="container">
        <div class="row">
          <div class="col-md-4" style="margin-bottom:20px">
            <div class="contact-item">
              <i class="fa fa-phone"></i>
              <h4>Phone</h4>
              <a href="#">+639776848642</a>
            </div>
          </div>
          <div class="col-md-4" style="margin-bottom:20px">
            <div class="contact-item">
              <i class="fa fa-envelope"></i>
              <h4>Email</h4>
              <a href="#">info@mcjim-server.com</a>
            </div>
          </div>
          <div class="col-md-4" style="margin-bottom:20px">
            <div class="contact-item">
              <i class="fa fa-map-marker"></i>
              <h4>Location</h4>
              <a href="#">Pagadian City, Philippines</a>
            </div>
          </div>
        </div>
      </div>
    </div><br>
  <div class="container">	
    <div class="callback-form contact-us">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Send us a <em>message</em></h2>
            </div>
          </div>
          <div class="col-md-12 mobile">
            <div class="contact-form">
              <form action="https://api.web3forms.com/submit" method="post" role="form">
			  <input type="hidden" name="access_key" value="2f07fb4b-4d9c-40e3-89a2-ac81d27fad3b">
                <div class="row">
                  <div class="col-lg-4 col-md-12 col-sm-12 mobile">
                    <fieldset>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-4 col-md-12 col-sm-12 mobile">
                    <fieldset>
                      <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*" placeholder="E-Mail Address" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-4 col-md-12 col-sm-12 mobile">
                    <fieldset>
                      <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12 mobile">
                    <fieldset>
                      <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message" required=""></textarea>
                    </fieldset>
                  </div>
				  <input type="checkbox" name="botcheck" class="hidden" style="display: none;">
                  <div class="col-lg-12 text-center">
                    <fieldset>
                      <button type="submit" id="form-submit" class="btn btn-primary filled-button">Send Message</button>
                    </fieldset>
					<input type="hidden" name="redirect" value="https://mcjim-server.com/home/thanks.php">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<br><br>
<div class="container"> 
	<div class="container" style="padding:5px;background:#bbb;border-radius:10px">
		<div id="map" >
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1976.320321006615!2d123.43113614107169!3d7.827805303191535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3254180f6d04025f%3A0x191d8e1945a03454!2sZamboanga%20del%20Sur%20Provincial%20Capitol!5e0!3m2!1sen!2sph!4v1762055926602!5m2!1sen!2sph" width="100%" height="500px" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
</div>
<br><br><br><br><br>
</body>

<?php require("footer.php");?>
