<?php 
	require("connect.php");
	require("header.php");
	require("menunav.php");
	$proj="salonsystem";
	$name="Beauty Salon Management System";
	require("prohead.php");
?>

<div id="<?php echo $proj;?>" style="margin-top:60px">
	<div class="container" id="<?php echo $proj;?>">
		<h3><b><?php echo $name;?></b></h3>
			<p style="text-align:justify;margin-left:30px">
				The <?php echo $name;?> is a web-based application developed to assist salon owners and managers in
				efficiently managing their salon operations. This system is designed with various technologies to provide 
				a user-friendly and feature-rich experience. 
			</p>
			<p style="text-align:justify;margin-left:30px">
				<br><b style="font-size:25px">Technology Used</b>
			</p>		
			<p style="text-align:justify;margin-left:30px">
				<div style="margin-left:80px;font-size:14px">
					<li>HTML: For structuring web pages and content.</li>
					<li>CSS: For styling and enhancing the visual appeal of the application.</li>
					<li>PHP: Backend scripting for dynamic functionality.</li>
					<li>Bootstrap: A front-end framework for responsive web design.</li>
					<li>MySQL: The database management system to store salon data.</li>
					<li>JavaScript: Adds interactivity and dynamic features to the application.</li>
				</div>
			</p><br>					
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:25px">Features and Functionalities</b>
			</p>		
			<p style="text-align:justify;margin-left:30px">
				<div style="margin-left:80px;font-size:14px">
					<li>Appointment Management: Schedule and manage salon appointments easily.</li>
					<li>Customer Profiles: Maintain customer records and history for personalized service.</li>
					<li>Staff Management: Keep track of staff schedules, commissions, and performance.</li>
					<li>Inventory Management: Manage salon product inventory efficiently.</li>
					<li>Billing and Payments: Generate invoices and accept various payment methods.</li>
					<li>Reporting and Analytics: Gain insights into salon performance through reports.</li>			
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
				<b style="font-size:20px">About Us Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/page3.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Contact Us Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/page4.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Login Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/page5.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Dashboard</b><br>
				<img src="images/projects/<?php echo $proj;?>/page6.jpg" class="snapshot">
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Apointment List</b><br>
				<img src="images/projects/<?php echo $proj;?>/page7.jpg" class="snapshot">
			</p><br>			
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Sales Report</b><br>
				<img src="images/projects/<?php echo $proj;?>/page8.jpg" class="snapshot">
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">System Installation</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li><b>Download</b> the source code @ www.mcjim-server.com/download/<?php echo $proj;?>.zip</li>
					<li><b>Extract</b> the downloaded file to your server (localhost) root folder ex. <b>www</b> for WAMP or <b>htdocs</b> on XAMMP.</li>
					<li><b>Import</b> the included <b>.sql</b> file located in <b>SQL File</b> folder which is the database of the system using <b>phpMyAdmin</b>.</li>
					<li><b>After</b> a successful import, open the extracted folder and open <b>dbconnection.php</b> in <b>includes</b> folder</b>.</li>
					<li><b>Edit</b> the database name in the connection depending on the name of the database you created in importing the included <b>.sql</b> file.</li>
				</div>
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">How to Use</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li>Use this Administrator Credential to login:</li>
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
