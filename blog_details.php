<?php
	require("connect.php");
	require("header.php");
	require("menunav.php");
?>

<script>setActive("blog");</script>

<link rel="stylesheet" href="/assets/css/blog.css?v=<?= SITE_VERSION ?>">	
<link rel="stylesheet" href="/vendor/venobox/venobox.min.css">	

<!-- Heading -->
<div class="page-heading header-text header">
  <div class="container">
	<div class="row">
	  <div class="col-md-12">
	    <h1>Read Our Blog</h1>
		  <span style="margin-bottom:20px">login > create > update > delete</span>
		  <?php if(isset($_SESSION['uno'])): ?>
		  <button style="margin-bottom:-10px" id="btnAddPost">Add New Post</button>
	    <?php endif; ?>
	  </div>
    </div>
  </div>
</div>

<?php require("ajax_posts_details.php"); ?>

<?php require("footer.php");?>

<script src="/vendor/venobox/venobox.min.js"></script>

<script>
$(document).ready(function(){
  $('.venobox').venobox({
    framewidth: 'auto',
    border: '6px',
    bgcolor: '#000',
    spinner: 'cube-grid',
    spinColor: '#fff',
    closeBackground: '#000',
    closeColor: '#fff'
  });
});
</script>