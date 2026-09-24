import re

html_file = r'd:\Server\www\webhosting.html'

with open(html_file, 'r', encoding='utf-8') as f:
    content = f.read()

# Add CSS links
css_links = """
    <!-- Bootstrap core CSS -->
    <link href="https://mcjim-server.com/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">   
    <link rel="stylesheet" href="https://mcjim-server.com/assets/css/fontawesome.css">
    <link rel="stylesheet" href="https://mcjim-server.com/assets/css/style.css">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="/webhosting/styles.css">
"""
content = re.sub(r'<!-- Stylesheet -->\s*<link rel="stylesheet" href="/webhosting/styles.css">', css_links, content)


# Replace Navbar
navbar_replacement = """
<!-- Header -->
<div class="sub-header">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-xs-12">
				<ul class="left-info">
					<li><a href="#"><i class="fa fa-envelope"></i>info@mcjim-server.com</a></li>
					<li><a href="#"><i class="fa fa-phone"></i>+639776848642</a></li>
				</ul>
			</div>
			<div class="col-md-4">
				<ul class="right-icons">
					<li><a href="https://facebook.com/cybermcjim" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<li><a href="https://github.com/McJim69" target="_blank"><i class="fa fa-github"></i></a></li>
					<li><a href="https://www.linkedin.com/in/mcjim-maata-5092a6186" target="_blank"><i class="fa fa-linkedin"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<header>
	<nav class="navbar navbar-expand-lg">
		<div class="container">
			<a class="navbar-brand" href="https://mcjim-server.com/index.php" style="margin-top:0px">
				<img src="https://mcjim-server.com/images/logo2.webp" height="50">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto" style="margin-top:8px;margin-bottom:5px">
					<li class="nav-item" id="home"><a class="nav-link" href="https://mcjim-server.com/index.php">Home</a></li>
					<li class="nav-item" id="about"><a class="nav-link" href="https://mcjim-server.com/about.php">About</a></li>	  
					<li class="nav-item" id="projects"><a class="nav-link" href="https://mcjim-server.com/projects.php">Projects</a></li>
					<li class="nav-item" id="blog"><a class="nav-link" href="https://mcjim-server.com/blog.php">Blog</a></li>		
					<li class="nav-item" id="contact"><a class="nav-link" href="https://mcjim-server.com/contact.php">Contact</a></li>		
					<li class="nav-item" id="hosting"><a class="nav-link" href="https://host.mcjim-server.com/">Hosting</a></li>		
					<li class="nav-item" id="login"><a class="nav-link" href="https://mcjim-server.com/login.php">Login</a></li>	
					<li class="nav-item" id="signup"><a class="nav-link" href="https://mcjim-server.com/user_register.php">Join Us</a></li>
				</ul>
			</div>
		</div>
	</nav>
</header>
"""
content = re.sub(r'<!-- Navbar -->.*?</nav>', navbar_replacement, content, flags=re.DOTALL)

# Replace Footer
footer_replacement = """
<!-- Footer Starts Here -->
<footer>
	<div class="container d-flex justify-content-center align-items-betwen">
		<div class="row">
			<div class="col-md-3 footer-item"><h4 class="text-muted">🌐 McJim Cyberworks</h4>
				<p style="color:#bbb">Empowering Digital Transformation with Tailored IT Solutions.</p>
				<ul class="social-icons">
					<li><a style="background:#545454" href="https://facebook.com/mcjimserver" target="_blank"><i class="fa fa-facebook text-white"></i></a></li>
					<li><a style="background:#545454" href="https://github.com/McJim69" target="_blank"><i class="fa fa-github text-white"></i></a></li>
					<li><a style="background:#545454" href="https://www.linkedin.com" target="_blank"><i class="fa fa-linkedin text-white"></i></a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-item"><h4 class="text-muted">📜 Legal Terms</h4>
				<ul class="menu-list">
					<li><a style="color:#bbb" href="https://mcjim-server.com/disclaimer.php"><i class="fa fa-exclamation-triangle"></i> Disclaimer</a></li>
					<li><a style="color:#bbb" href="https://mcjim-server.com/terms.php"><i class="fa fa-file"></i> Terms of Use</a></li>
					<li><a style="color:#bbb" href="https://mcjim-server.com/privacy.php"><i class="fa fa-shield"></i> Privacy Statement</a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-item"><h4 class="text-muted">👩‍💼 Contact Info</h4>
				<ul class="menu-list">
					<li><a style="color:#bbb" href="https://mcjim-server.com/contact.php"><i class="text-center fa fa-globe"></i> Contact Us</a></li>	
					<li><a style="color:#bbb" href="https://facebook.com/mcjimserver" target="_blank"><i class="text-center fa fa-facebook"></i> facebook/mcjimserver</a></li>	
					<li><a style="color:#bbb" href="#"><i class="fa fa-envelope text-center"></i> info@mcjim-server.com</a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-item last-item"><h4 class="text-muted">🌱 Small Act, Big Help  </h4>
				<div style="margin-top:-20px;"><small>
				We’re grateful to share our services freely, 
				hoping they bring value to you. &nbsp; If you feel useful, 
				a small donation would mean so much.</small>
				</div>
				<div class="mt-2">
				 <style>.pp-A7U93SR9K428N{text-align:center;border:none;border-radius:1.5rem;min-width:11.625rem;padding:0 2rem;height:2rem;font-weight:bold;background-color:#FFD140;color:#000000;font-family:"Helvetica Neue",Arial,sans-serif;font-size:0.875rem;line-height:1.125rem;cursor:pointer;}</style>
				  <form action="https://www.paypal.com/ncp/payment/A7U93SR9K428N" method="post" target="_blank" style="display:inline-grid;justify-items:center;align-content:start;gap:0.5rem;">
					<input class="pp-A7U93SR9K428N" type="submit" value="Donate Now!" />
				  </form>
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
					Copyright &copy; 2020 - 2026 <a href="https://mcjim-server.com">McJim Cyberworks</a> Pagadian City, Philippines
				</p>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="https://mcjim-server.com/vendor/jquery/jquery.js"></script>
<script src="https://mcjim-server.com/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
"""
content = re.sub(r'<!-- Footer -->.*?</footer>', footer_replacement, content, flags=re.DOTALL)

with open(html_file, 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated HTML locally.")
