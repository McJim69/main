<style>
.pp-A7U93SR9K428N{
	text-align:center;
	border:none;
	border-radius:1.5rem;
	width:auto !important;
	padding:0 2rem;
	height:2rem;
	font-weight:bold;
	background:var(--primary-gradient);
	font-family:"Helvetica Neue",Arial,sans-serif;
	font-size:0.875rem;
	line-height:1.125rem;
	cursor:pointer;
}
</style>

<!-- Footer Starts Here -->
<footer>
	<div class="container d-flex justify-content-center align-items-betwen">
		<div class="row">
			<div class="col-md-3 footer-item"><h4 class="text-muted">🌐 McJim Cyberworks</h4>
				<p style="color:#bbb">Empowering Digital Transformation with Tailored IT Solutions.</p>
				<ul class="social-icons">
					<li><a style="background:#545454" href="https://facebook.com/mcjimserver" target="_blank"><i class="fab fa-facebook-f text-white"></i></a></li>
					<li><a style="background:#545454" href="https://github.com/McJim69" target="_blank"><i class="fab fa-github text-white"></i></a></li>
					<li><a style="background:#545454" href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in text-white"></i></a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-item"><h4 class="text-muted">📜 Legal Terms</h4>
				<ul class="menu-list">
					<li><a style="color:#bbb" href="disclaimer.php"><i class="fas fa-triangle-exclamation"></i> Disclaimer</a></li>
					<li><a style="color:#bbb" href="terms.php"><i class="fas fa-file"></i> Terms of Use</a></li>
					<li><a style="color:#bbb" href="privacy.php"><i class="fas fa-shield-halved"></i> Privacy Statement</a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-item"><h4 class="text-muted">👩‍💼 Contact Info</h4>
				<ul class="menu-list">
					<li><a style="color:#bbb" href="contact.php"><i class="fas fa-globe"></i> Contact Us</a></li>
					<li><a style="color:#bbb" href="https://facebook.com/mcjimserver" target="_blank"><i class="fab fa-facebook-f"></i> facebook/mcjimserver</a></li>
					<li><a style="color:#bbb" href="#"><i class="fas fa-envelope"></i> info@mcjim-server.com</a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-item last-item"><h4 class="text-muted">🌱 Small Act, Big Help  </h4>
				<div style="margin-top:-20px;"><small>
				We’re grateful to share our services freely, 
				hoping they bring value to you. &nbsp; If you feel useful, 
				a small donation would mean so much.</small>
				</div>
				<div class="mt-2">
				 <?php if (isset($_SESSION['user'])) { ?>
				  <a href="billing_sso.php" target="_blank" style="display:inline-grid;justify-items:center;align-content:start;gap:0.5rem;">
					<button class="pp-A7U93SR9K428N text-dark" type="submit"><i class="fab fa-paypal text-dark"></i> Donate Now</button>
				  </a>
				 <?php } else { ?>
				  <form action="https://www.paypal.com/ncp/payment/A7U93SR9K428N" method="post" target="_blank" style="display:inline-grid;justify-items:center;align-content:start;gap:0.5rem;">
					<button class="pp-A7U93SR9K428N text-dark" type="submit"><i class="fab fa-paypal text-dark"></i> Donate Now</button>
				  </form>
				 <?php } ?>
				</div>
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

<!-- Sticky Bottom-Right Chat Pill Button -->
<a href="/chat/" id="chatStickyBtn" class="btn btn-sm rounded-pill sticky-chat-pill">
	<i class="fas fa-comments"></i> <span>Chat</span>
</a>

<!-- Bootstrap core JavaScript -->
<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_SESSION['user'])) { ?>
<script src="/chat/chat_notification.js?v=<?php echo defined('SITE_VERSION') ? SITE_VERSION : '1.0'; ?>"></script>
<?php } ?>

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
