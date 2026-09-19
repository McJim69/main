<?php
	require("connect.php");
	require("header.php");
	require("menunav.php");
?>

<script>setActive("about");</script>

<!-- Page Content -->
    <div class="page-heading header-text">
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
					<p>
						McJim Cyberworks delivers tailored IT solutions for businesses, 
						offering cloud computing, cybersecurity, software development, and consultancy.
					</p>
					<p>
						<h5>MISSION</h5>
						Our mission is to empower organizations in the digital age with innovative, reliable, and scalable technology.
					</p>
					<p>
						<h5>GOAL</h5>
						Our main objective in undertaking this business is to provide Information Technology (IT) sales and services to marginalized communities, particularly those in distant areas, since they are less fortunate in accessing modern services.
					</p>
                  </div>
                </div>
                <div class="col-md-6" style="border:0">
                  <div class="left-image" style="border:0">
                    <img src="images/network.webp?<?= SITE_VERSION ?>" alt="McJim Cyberworks" style="border:0">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><br><br>
<?php require("footer.php");?>