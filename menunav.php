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

<style>
.nav-item img{
	aspect-ratio:2/2;
	height:38px;
	margin-top:-8px;
	margin-bottom:-5px;
	border-radius:50%;
	box-shadow:0 8px 32px 0 rgba(0, 0, 0, 0.37);
}
</style>

<header>
	<nav class="navbar navbar-expand-lg">
		<div class="container">
			<a class="navbar-brand" href="index.php" style="margin-top:0px">
				<!-- <h2>MCJIM <em> Cyberworks</em></h2> -->
				<img src="images/header_logo1.png?<?php echo date("h:i:s");?>" height="50">
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
					<li class="nav-item" id="contact">
						<a class="nav-link" href="contact.php">Contact</a>
					</li>		
					<li class="nav-item" id="blog">
						<a class="nav-link" href="blog.php">blog</a>
					</li>		
					<?php if(!isset($_SESSION['user'])){ ?>
					<li class="nav-item" id="login">
						<a class="nav-link" href="login.php">Login</a>
					</li>	
					<li class="nav-item" id="signup">
						<a class="nav-link" href="user_register.php">Signup</a>
					</li>	
					<?php } else { ?>
					<li class="nav-item" id="download">
						<a class="nav-link" href="downloads.php">Download</a>
					</li>		
					<li class="nav-item" id="support">
						<a class="nav-link" href="support.php">Support</a>
					</li>
					<li class="nav-item" id="docs">
						<a class="nav-link" href="docs.php">Wiki</a>
					</li>
					<li class="nav-item" id="file-drop">
						<a class="nav-link" href="file-drop.php">File Drop</a>
					</li>
					<li class="nav-item dropdown" id="user">
					  <a class="nav-link dropdown-toggle" style="color:#bbb; display:inline-flex; align-items:center;" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
					  <ul class="dropdown-menu" style="background-color: rgba(10, 15, 30, 0.9);opacity:.8" aria-labelledby="userDropdown">
						<li class="nav-item" id="meet"><a class="nav-link" href="https://meet.mcjim-server.com" target="_blank">Meet</a></li>	
						<li class="nav-item" id="chat"><a class="nav-link" href="chat/">Chat</a></li>		
						<li class="nav-item" id="user"><a class="nav-link" href="user_profile.php">Profile</a></li>
						<?php if ($_SESSION["access"]=="Admin"){ ?>
						<li class="nav-item" id="users">
							<a class="nav-link" href="admin-users.php">Users</a>
						</li>		
						<li class="nav-item" id="projects">
							<a class="nav-link" href="admin-projects.php">Projects</a>
						</li>		
						<li class="nav-item" id="tickets">
							<a class="nav-link" href="admin-support.php">Tickets</a>
						</li>		
						<li class="nav-item" id="kanban">
							<a class="nav-link" href="kanban.php">Kanban</a>
						</li>
						<li class="nav-item" id="admin-docs">
							<a class="nav-link" href="admin-docs.php">Manage Wiki</a>
						</li>		
						<?php } ?>
						<li class="nav-item" id="logout"><a class="nav-link" onclick="endSession();" href="#">Logout</a></li>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>