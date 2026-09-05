<?php 
	require("header.php"); 	
	require("menunav.php"); 
?>

<!-- Page Content -->
    <div class="page-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>Thank You!</h1>
            <span>For getting in touch!</span>
          </div>
        </div>
      </div>
    </div>
	<div class="container text-center"><br>
		<img src="images/success1.png" height="100">
		<h6>Your message was sent successfully.</h6>
		<div class="text-muted" style="margin-top:20px">
			We appreciate your interest on our services. One of our colleagues will get back to you shortly.
		</div>
		<h1 class="text-success"><button class="filled-button" onclick="jump('index.php')">Continue</button></h1>
	</div>
<br><br><br>

<?php require("footer.php");?>
