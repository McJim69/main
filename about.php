<?php
	require("connect.php");
	require("header.php");
	require("menunav.php");
?>

<script>setActive("about");</script>

<!-- Page Content -->
    <div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp?<?php echo time();?>)no-repeat;background-size:cover;background-position:center center">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>About Us</h1>
            <span>We have over 10 years of experience<br>empowering Digital Transformation with Tailored IT Solutions.</span>
          </div>
        </div>
      </div>
    </div>
    <div class="more-info about-info" style="border:0">
      <div class="container" style="margin-top:-90px">
        <div class="row" style="border:0">
          <div class="col-md-12" style="border:0">
            <div class="more-info-content" style="border:0">
              <div class="row" style="border:0">
                <div class="col-md-6 align-self-center" style="border:0">
                  <div class="right-content" style="border:0">
					<h2 class="text-secondary">McJim Cyberworks</h2>
					<p style="color:#bbb">
						McJim Cyberworks specialize in delivering cutting-edge IT solutions tailored to the 
						unique needs of businesses. With a dedicated team of experts, we offer a comprehensive 
						range of services, including cloud computing, cybersecurity, software development, and 
						IT consultancy. Our mission is to empower organizations to thrive in the digital age by 
						providing innovative, reliable, and scalable technology solutions. 					
					</p>
                  </div>
                </div>
                <div class="col-md-6" style="border:0">
                  <div class="left-image" style="border:0">
                    <img src="images/network.webp?<?php echo time();?>" alt="McJim Cyberworks" style="border:0">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><br><br>
<?php require("footer.php");?>