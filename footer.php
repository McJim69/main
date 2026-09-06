<!-- Footer Starts Here -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-3 footer-item"><h4 class="text-muted">McJim Cyberworks</h4>
				<p style="color:#bbb">Empowering Digital Transformation with Tailored IT Solutions.</p>
				<ul class="social-icons">
					<li><a style="background:#545454" href="https://facebook.com/mcjimserver" target="_blank"><i class="fa fa-facebook text-white"></i></a></li>
					<li><a style="background:#545454" href="https://github.com/McJim69" target="_blank"><i class="fa fa-github text-white"></i></a></li>
					<li><a style="background:#545454" href="https://www.linkedin.com" target="_blank"><i class="fa fa-linkedin text-white"></i></a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-item"><h4 class="text-muted">Terms & Policy</h4>
				<ul class="menu-list">
					<li><a style="color:#bbb" href="disclaimer.php"><i class="fa fa-exclamation-triangle"></i> Disclaimer</a></li>
					<li><a style="color:#bbb" href="terms.php"><i class="fa fa-file"></i> Terms of Use</a></li>
					<li><a style="color:#bbb" href="privacy.php"><i class="fa fa-shield"></i> Privacy Statement</a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-item"><h4 class="text-muted">Page Links</h4>
				<ul class="menu-list">
					<li><a style="color:#bbb" href="index.php"><i class="fa fa-home"></i> Home</a></li>
					<li><a style="color:#bbb" href="about.php"><i class="fa fa-info-circle"></i> About Us</a></li>
					<li><a style="color:#bbb" href="contact.php"><i class="fa fa-book"></i> Contact Us</a></li>		
				</ul>
			</div>
			<div class="col-md-3 footer-item last-item"><h4 class="text-muted">Contact Info</h4>
				<ul class="menu-list">
					<li><a style="color:#bbb" href="#"><i class="text-center fa fa-phone"></i> 09776848642</a></li>	
					<li><a style="color:#bbb" href="https://facebook.com/mcjimserver" target="_blank"><i class="text-center fa fa-facebook"></i> facebook/mcjimserver</a></li>	
					<li><a style="color:#bbb" href="#"><i class="fa fa-envelope text-center"></i> info@mcjim-server.com</a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>
    
<div class="sub-footer">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p style="color:#bbb">
					Copyright &copy; 2020 - <?php echo date("Y");?> <a href="https://mcjim-server.com">McJim Cyberworks</a> Pagadian City, Philippines
				</p>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_SESSION['user'])): ?>
<script src="/chat/chat_notification.js?v=<?= SITE_VERSION ?>"></script>
<?php endif; ?>

<!-- Additional Scripts -->
<script src="assets/js/slick.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/accordions.js"></script>

<script language = "text/Javascript"> 
  cleared[0] = cleared[1] = cleared[2] = 0; // set a cleared flag for each field
  function clearField(t){                   // declaring the array outside of the
  if(! cleared[t.id]){                      // function makes it static and global
	  cleared[t.id] = 1; 		 			// you could use true and false, but that's more typing
	  t.value='';         					// with more chance of typos
	  t.style.color='#fff';
	  }
  }
</script>

<script>
	const headers = document.querySelectorAll(".accordion-header");
	headers.forEach(header => {
	  header.addEventListener("click", () => {
		const content = header.nextElementSibling;
		content.style.display = content.style.display === "block" ? "none" : "block";
	  });
	});
</script>
	
</body>

</html>
