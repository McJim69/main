<?php 
	require("connect.php");
	require("header.php");
	require("menunav.php");
	$proj="victoryfreewifi";
	$name="WiFi Sites Management";
	require("prohead.php");
?>

<div id="<?php echo $proj;?>" style="margin-top:60px">
	<div class="container" id="<?php echo $proj;?>">
		<h3><b><?php echo $name;?></b></h3>
			<p style="text-align:justify;margin-left:30px">
				The <?php echo $name;?> web application using PHP/MySQL is a project that serves as Installation and Inventory Sysyem.
				Serves as monitoring and management for all installed wifi sites and devices.
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:25px">Features and Functionalities</b><br>
				<?php echo $name;?> is containing the following features:
			</p>		
			<p style="text-align:justify;margin-left:30px">
				<div style="margin-left:80px;font-size:14px">
					<li>Sites Monitoring</li>
					<li>Inventory System</li>
					<li>Accomplishment Reports</li>
					<li>Installation Certificate </li>				
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
				<b style="font-size:20px">View Sites</b><br>
				<img src="images/projects/<?php echo $proj;?>/page2.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Site Details</b><br>
				<img src="images/projects/<?php echo $proj;?>/page3.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Login Modal</b><br>
				<img src="images/projects/<?php echo $proj;?>/page4.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Add Installation</b><br>
				<img src="images/projects/<?php echo $proj;?>/page5.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Servers Monitor</b><br>
				<img src="images/projects/<?php echo $proj;?>/page6.jpg" class="snapshot">
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Summary Report</b><br>
				<img src="images/projects/<?php echo $proj;?>/page7.jpg" class="snapshot">
			</p><br>			
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">System Installation</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li><b>Download</b> the source code @ www.mcjim-server.com/download/<?php echo $proj;?>.zip</li>
					<li><b>Extract</b> the downloaded file to your server (localhost) root folder ex. <b>www</b> for WAMP or <b>htdocs</b> on XAMMP.</li>
					<li><b>Import</b> the included <b>database.sql</b> file located in <b>database</b> folder which is the database of the system using <b>phpMyAdmin</b>.</li>
					<li><b>After</b> a successful import, open the extracted folder, open <b>connect.php</b> and <b>connect.php</b>.</li>
					<li><b>Edit</b> the connection like database name, username and password matching your server's settings.</li>
				</div>
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">How to Use</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li>Login as Admininistrator to gain access of all system features.</li>
					<li>Use this administrator credential to login:</li>
					<div style="margin-left:40px;font-size:13px">
						<li>Username: <b>admin</b></li>
						<li>Password: <b>admin</b></li>
					</div>					
					<li><b>CRUD</b> Devices</li>
					<li><b>CRUD</b> Installations</li>
					<li><b>CRUD</b> Sysyem Users</li>
					<li><b>CRUD</b> Device Category</li>
					<li><b>CRUD</b> Team Leader-Installer</li>
					<li><b>Execute</b> Sysyem Backup/Restore</li>
				</div>
			</p><br>
			<div style="text-align:center">
				<a href="/../projects/<?php echo $proj;?>/"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">TESTDEMO</button></a>
				<a href="/../download/"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">DOWNLOAD</button></a>
				<a href="/../projects/"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">TEMPLATES</button></a>
				<a href="index.php"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">BACKHOME</button></a>	
			</div>
		</div>
	</div>
</div><br>

<?php require("footer.php");?>