<?php 
	require("connect.php");
	require("header.php");
	require("menunav.php");
	$proj="webportfolio";
	$name="Personal Job Portfolio";
	require("prohead.php");
?>

<div id="<?php echo $proj;?>" style="margin-top:60px">
	<div class="container" id="<?php echo $proj;?>">
		<h3><b><?php echo $name;?></b></h3>
			<p style="text-align:justify;margin-left:30px">
				The <?php echo $name;?> is a web-based application project developed in PHP and MySQL Database. 
				This project provides an online platform for a certain individual to give their possible clients an overview or idea 
				about their work. On this website project, the clients can read the relevant information about the subject. 
				It has a pleasant user interface and user-friendly features and functionalities.
			</p>
			<p style="text-align:justify;margin-left:30px">
				This <?php echo $name;?> has two sides of the user mode which are the Administrator and Public.
				If login as Administraor the page content is editable and more menu functions will appear for management.
			</p>			
			<p style="text-align:justify;margin-left:30px">
				<br><b style="font-size:25px">Features and Functionalities</b><br>
				<?php echo $name;?> is containing the following features:
			</p>		
			<p style="text-align:justify;margin-left:30px">
				<div style="margin-left:80px;font-size:14px">
					<li>Public</li>
					<div style="margin-left:40px;font-size:13px">
						<li>View Services</li>
						<li>View Portfolio</li>
						<li>Interact Contact</li>
						<li>Request Services</li>
					</div>
					<li>Administrator</li>
					<div style="margin-left:40px;font-size:13px">	
						<li>Update Services Content</li>
						<li>CRUD Portfolio Content</li>	
						<li>Backup and Restore</li>
						<li>Upload Files</li>
					</div>
				</div>
			</p><br>				
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:25px">Snapshots</b><br>
				Here are some snapshots of the <?php echo $name;?> project:
			</p>		
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Home Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/page1.jpg" class="snapshot">
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Services Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/page2.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Portfolio (Public)</b><br>
				<img src="images/projects/<?php echo $proj;?>/page3.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Contact Form</b><br>
				<img src="images/projects/<?php echo $proj;?>/page4.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Edit Content</b><br>
				<img src="images/projects/<?php echo $proj;?>/page5.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Portfolio (Admin)</b><br>
				<img src="images/projects/<?php echo $proj;?>/page6.jpg" class="snapshot">
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">User's Profile</b><br>
				<img src="images/projects/<?php echo $proj;?>/page7.jpg" class="snapshot">
			</p><br>			
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Backup and Restore</b><br>
				<img src="images/projects/<?php echo $proj;?>/page8.jpg" class="snapshot">
			</p><br><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">System Installation</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li><b>Download</b> the source code @ www.mcjim-server.com/download/<?php echo $proj;?>.zip</li>
					<li><b>Extract</b> the downloaded file to your server (localhost) root folder ex. <b>www</b> for WAMP or <b>htdocs</b> on XAMMP.</li>
					<li><b>Import</b> the included <b>.sql</b> file located in <b>database</b> folder which is the database of the system using <b>phpMyAdmin</b>.</li>
					<li><b>After</b> a successful import, open the extracted folder and open <b>connect.php</b> in your <b>document/root</b> folder.</li>
					<li><b>Edit</b> the database name in the connection depending on the name of the database you created in importing the included <b>.sql</b> file.</li>
				</div>
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">How to Use</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li>Use this Credential to Login:</li>
					<div style="margin-left:40px;font-size:13px">
						<li>Username: <b>admin</b></li>
						<li>Password: <b>admin</b></li>
					</div>
				</div>
			</p><br>
			<div style="text-align:center">
				<a href="/../projects/<?php echo $proj;?>/"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">TESTDEMO</button></a>
				<a href="/../download/<?php echo $proj;?>.zip"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">DOWNLOAD</button></a>
				<a href="/../projects/"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">TEMPLATES</button></a>
				<a href="index.php"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">BACKHOME</button></a>	
			</div>
		</div>
	</div>
</div><br>

<?php require("footer.php");?>