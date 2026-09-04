<?php
	require("connect.php");
	require("header.php");
	require("menunav.php");
?>

<script>setActive("projects");</script>

<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp) no-repeat;background-size:cover;background-position:center center">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>WebDev Projects</h1>
        <span>Web Development Projects</span>
      </div>
    </div>
  </div>
</div>

<link href="assets/css/card-grid.css" rel="stylesheet">

<div class="container">
  <div class="row" style="margin: 20px 0px 20px 0px">
    <?php 
	$i=1;
    $ex = $conn->query("SELECT * FROM projects ORDER BY pid");
    while($rs = $ex->fetch_assoc()){
        $pidn = $rs["pid"];
        $name = $rs["pname"];
        $desc = $rs["description"];
        $link = $rs["plink"];
        $imgu = $rs["pimgUrl"];
    ?>
    <div class="col-md-3" style="border:0;padding:15px">
      <div class="box-cont">
		<div class="itemno">
			<b><?php echo $i;?></b>
		</div>                          
        <a href="../projects/<?php echo $link;?>/" target="_blank" title="Try Demo">
          <img src="images/projects/<?php echo $link;?>/logo.png">
        </a><br>
        <?php echo $name;?>
        <p class="text-info">Web Application</p>
        <a class="btn btn-sm buxton" href="project_details.php?id=<?php echo $pidn;?>">
          <small class="text-dark">View Details</small>
        </a>
      </div>
    </div>
    <?php $i++; } ?>
  </div>
</div>

<?php require("footer.php");?>
