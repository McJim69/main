<?php	
	require("connect.php");
    if (!isset($_SESSION['user'])) {
		header("Location: index.php");
		exit;
    }
	require("header.php");
	require("menunav.php");
?>

<script>setActive("download");</script>

<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp)no-repeat;background-size:cover;background-position:center center">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Downloads</h1>
				<span>Downloadable Files</span>
			</div>
		</div>
	</div>
</div>

<link href="assets/css/card-grid.css" rel="stylesheet">

<div class="container">
  <div class="row" style="margin: 20px 0px 20px 0px">
			<?php
				$i=1;
				$folderPath = 'download/';
				$dir = new DirectoryIterator($folderPath);

				foreach ($dir as $fileinfo) {
					if ($fileinfo->isFile()) {
						$file = $fileinfo->getFilename();
						
						if ($file === '.htaccess') {
							continue;
						}

						$type = $fileinfo->getExtension();
						$size = $fileinfo->getSize();
						$bits = number_format($size / 1024, 2);
						echo "
						<div class='col-lg-3' style='border:0;padding:15px'>
							<a href='download/$file'>
								<div class='box-cont' title='Click to Download' style='position:relative'> 
									<div class='itemno'>
										<b>$i</b>
									</div>                          
									<img ";
									if ($type === 'apk') { 
										echo " src='images/apk.webp' ";
									} elseif ($type === 'zip') {    
										echo " src='images/zip.webp' ";
									} elseif ($type === 'rar') {    
										echo " src='images/rar.webp' ";
									} elseif ($type === 'txt') { 
										echo " src='images/text.webp' ";
									} elseif ($type === 'exe') { 
										echo " src='images/exe.webp' ";     
									} elseif ($type === 'mp3') { 
										echo " src='images/mp3.webp' ";    
									} elseif ($type === 'pdf') { 
										echo " src='images/pdf.webp' ";  	
									} elseif ($type === 'mp4') { 
										echo " src='images/media.webp' "; 										
									} else {    
										echo " src='images/unknown.webp' ";
									}
									echo"> 
									<br>$file<br>
									<div class='text-info'>
										<small>Size: $bits KB</small><br>
										<small>File Type: <b class='text-uppercase'>$type</b></small>
									</div>
								</div>
							</a>
						</div>";
						$i++;
					}
				}
			?>
	</div>
</div>

<?php
	require("footer.php");
?>