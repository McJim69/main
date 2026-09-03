<?php
	require("connect.php");	
	require("header.php");	
	if(!isset($_SESSION['access']) || $_SESSION['access'] !== "Admin"){	
		header("location:../supjavs/"); 
		exit();
	}
	require("menunav.php");			
?>

<link href="assets/css/videos.css" rel="stylesheet">
  
<script>setActive("supjavs");</script>

<div class="page-heading header-text" style="background:url(assets/images/mcjim-cyberworks.webp)no-repeat;background-size:cover;background-position:center center">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>HD Uncensored JAV</h1>
				<button onclick="window.location.href='video_updater.php'" class="btn btn-primary">Update</button> &nbsp;
				<button onclick="window.location.href='supjavs.php'" class="btn btn-primary">Refresh</button>
			</div>
		</div>
	</div>
</div>

<div style="padding:15px 0 15px 0;background:#111;">
	<div class="container">
		<div class="col-md-12">
			<div class="row">
				<?php
					$i=1;
					$ex=$conn->query("select * from videos order by filename");
					while($rs=$ex->fetch_assoc()){
						$vids=$rs["vid"];
						$file=$rs["filename"];
						$path=$rs["filepath"];
						$pics=$rs["thumbpath"];
						$date=$rs["created_date"];						
					?>
					<div class="col-lg-3" style="padding:6px">
						<div class="video-cont">
							<div class="video-box" style="padding:6px"> 				
								<video
									id="<?php echo $vids;?>"
									title="<?php echo $file;?>"
									class="video-js vjs-default-skin"
									controls
									preload="none"
									poster="<?php echo $pics;?>?<?php echo date("h:i:s");?>">								
								<source src="<?php echo $path;?>" type="video/mp4">
								</video>
							</div>
							<div class="video-title">
								<small>
									<b><?php echo $i;?></b>. <?php echo $file;?>
								</small>
							</div>
						</div>
					</div>
				<?php $i++; } ?>
			</div>
		</div>
	</div>
</div>

<?php require("footer.php");?>
