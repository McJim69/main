<?php 
	require("connect.php");
	require("header.php");
	require("menunav.php");
	$proj="eventcounter";
	$name="Event Admission Counter";
	require("prohead.php");
?>

<div id="<?php echo $proj;?>" style="margin-top:60px">
	<div class="container" id="<?php echo $proj;?>">
		<h3><b><?php echo $name;?></b></h3>
			<p style="text-align:justify;margin-left:30px">
				The <?php echo $name;?> web application using PHP/MySQL is a project that serves as the automated 
				counting system of any large events or activities. This system works like the common registration system of 
				events but this is digitally populated registration by scanning QR codes issued by the event organizers. 
			</p>
			<p style="text-align:justify;margin-left:30px">
				<br><b style="font-size:25px">Features and Functionalities</b><br>
				<?php echo $name;?> is containing the following features:
			</p>
			<p style="text-align:justify;margin-left:30px">
				<div style="margin-left:80px;font-size:14px">
					<li>Create Additional Admission Tickets</li>
					<li>Generate Admission Tickets/Code</li>
					<li>Print Admision Tickets</li>
					<li>Create Event Title</li>					
					<li>Reset Counters</li>
					<li>Delete Events</li>				
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
				<b style="font-size:20px">Event Page (Create Modal)</b><br>
				<img src="images/projects/<?php echo $proj;?>/page2.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Event Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/page3.jpg" class="snapshot">
			</p><br>		
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">View Codes</b><br>
				<img src="images/projects/<?php echo $proj;?>/page4.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Print Codes</b><br>
				<img src="images/projects/<?php echo $proj;?>/page5.jpg" class="snapshot">
			</p><br><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">System Installation</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li><b>Download</b> the source code @ www.mcjim-server.com/download/<?php echo $proj;?>.zip</li>
					<li><b>Extract</b> the downloaded file to your server (localhost) root folder ex. <b>www</b> for WAMP or <b>htdocs</b> on XAMMP.</li>
					<li><b>Import</b> the included <b>database.sql</b> file located in <b>database</b> folder which is the database of the system using <b>phpMyAdmin</b>.</li>
					<li>After a successful import, open the extracted folder and open <b>connect.php</b>.</li>
					<li><b>Edit</b> the database name in the connection depending on the name of the database you created in importing the included <b>database.sql</b>.</li>
				</div>
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">How to Use</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li><b>Use</b> this Credential to Login</li>
						<div style="margin-left:40px;font-size:13px">
							<li>Username: admin</li>
							<li>Password: admin</li>
						</div>
					<li><b>Create Event</b> provide the title, venue and dates</li>
					<li><b>Generate Codes</b> provide number of tickets or code</li>
					<li><b>View Codes</b> prompted to generate codes if empty</li>
					<li><b>Add Codes</b> creates additional code for an event</li>

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
</div><br><br>

<?php require("footer.php");?>