<?php
	ob_start();
	require("connect.php");

	require("header.php");
	
	require("menunav.php");
	require("banner.php");
	?>

	<link rel="stylesheet" href="assets/css/accordion.css">
	<script>setActive("home");</script>
	<div style="padding-top:5px">
	<?php 
	require("webdev.php");
	require("hardware.php");
	require("server.php");
	require("network.php");
	require("media-server.php");
	require("meet-server.php");
	?>
	</div>

	<?php 
	require("footer.php");
	ob_end_flush();
?>
