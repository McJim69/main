<!-- Header -->
<div class="sub-header">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-xs-12">
				<ul class="left-info">
					<li><a href="#"><i class="fas fa-envelope"></i>info@mcjim-server.com</a></li>
					<li><a href="#"><i class="fas fa-phone"></i>+639776848642</a></li>
				</ul>
			</div>
			<div class="col-md-4">
				<ul class="right-icons">
					<li><a href="https://facebook.com/cybermcjim" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
					<li><a href="https://github.com/McJim69" target="_blank"><i class="fab fa-github"></i></a></li>
					<li><a href="https://www.linkedin.com/in/mcjim-maata-5092a6186" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<style>
.nav-item img{
	aspect-ratio:2/2;
	height:38px;
	margin-top:-8px;
	margin-bottom:-5px;
	border-radius:50%;
	box-shadow:0 8px 32px 0 rgba(0, 0, 0, 0.37);
}
/* Dark dropdown styling */
#user .dropdown-menu .dropdown-item {
	color: #ccc;
	padding: 8px 20px;
	transition: background 0.2s, color 0.2s;
}
#user .dropdown-menu .dropdown-item:hover,
#user .dropdown-menu .dropdown-item:focus {
	background-color: rgba(255, 255, 255, 0.1);
	color: #fff;
}
#user .dropdown-menu .dropdown-item.text-danger:hover {
	background-color: rgba(220, 53, 69, 0.2);
	color: #ff6b6b;
}
#user .dropdown-menu {
	border: 1px solid rgba(255,255,255,0.1);
	border-radius: 8px;
	box-shadow: 0 8px 32px rgba(0,0,0,0.5);
	min-width: 160px;
	backdrop-filter: blur(10px);
	-webkit-backdrop-filter: blur(10px);
}
</style>

<header>
	<nav class="navbar navbar-expand-lg">
		<div class="container">
			<a class="navbar-brand" href="index.php" style="margin-top:0px">
				<!-- <h2>MCJIM <em> Cyberworks</em></h2> -->
				<img src="images/logo2.webp?<?=time()?>" height="50">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto" style="margin-top:8px;margin-bottom:5px">
					<li class="nav-item" id="home">
						<a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item" id="about">
						<a class="nav-link" href="about.php">About</a>
					</li>	  
					<li class="nav-item" id="projects">
						<a class="nav-link" href="projects.php">Projects</a>
					</li>
					<li class="nav-item" id="media">
						<a class="nav-link" href="movies.php">Movies</a>
					</li>
					<li class="nav-item" id="blog">
						<a class="nav-link" href="blog.php">Blog</a>
					</li>		
					<li class="nav-item" id="contact">
						<a class="nav-link" href="contact.php">Contact</a>
					</li>		
					<li class="nav-item" id="hosting">
						<a class="nav-link" href="webhosting.php">Hosting</a>
					</li>		
					<?php if(!isset($_SESSION['user'])){ ?>
					<li class="nav-item" id="login">
						<a class="nav-link" href="login.php">Login</a>
					</li>	
					<li class="nav-item" id="signup">
						<a class="nav-link" href="user_register.php">Signup</a>
					</li>	
					<?php } else { ?>
					<li class="nav-item" id="dashboard">
						<a class="nav-link" href="dashboard.php">Dashboard</a>
					</li>

					<li class="nav-item dropdown" id="user">
					  <a class="nav-link dropdown-toggle" style="color:#bbb; display:inline-flex; align-items:center;" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
					     <?php 
							$user_img = "images/user.webp";
							if (isset($_SESSION["imgUrl"]) && !empty($_SESSION["imgUrl"])) {
								$imgPath = "images/users/" . $_SESSION["imgUrl"];
								if (file_exists(__DIR__ . "/" . $imgPath)) {
									$user_img = $imgPath;
								}
							}
						 ?>
						 <img src="<?php echo htmlspecialchars($user_img);?>?<?php echo date("h:i:s");?>" style="width:25px;height:25px;border-radius:50%;">&nbsp;
						 <span><?php echo htmlspecialchars($_SESSION["user"]);?></span>
					  </a>
					  <ul class="dropdown-menu dropdown-menu-right" style="background-color: rgba(10, 15, 30, 0.9);" aria-labelledby="userDropdown">
						<li><a class="dropdown-item" href="https://meet.mcjim-server.com" target="_blank"><i class="fas fa-video me-2"></i> Meet</a></li>
						<li><a class="dropdown-item" href="chat/"><i class="fas fa-comments me-2"></i> Chat</a></li>
						<li><a class="dropdown-item" href="user_profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
						<li role="separator" class="dropdown-divider" style="border-color:rgba(255,255,255,0.15);"></li>
						<li><a class="dropdown-item text-danger" onclick="endSession();" href="#"><i class="fas fa-right-from-bracket me-2"></i> Logout</a></li>
					  </ul>
					</li>
					<?php } ?>	
				</ul>
			</div>
		</div>
	</nav>
</header>

<script>
	function endSession(){	
		if(confirm("Are you sure you want to Logout?")){
			window.location.href = 'logout.php';
		}
	}
</script>
