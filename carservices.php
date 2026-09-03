<?php 
	require("connect.php");
	require("header.php");
	require("menunav.php");
	$proj="carservices";
	$name="Car AC Services System";
	require("prohead.php");
?>

<div id="<?php echo $proj;?>" style="margin-top:60px">
	<div class="container">
		<div id="<?php echo $proj;?>">
			<h3><b><?php echo $name;?></b></h3>
			<p style="text-align:justify;margin-left:30px">
				This project is entitled <?php echo $name;?>. 
				This web-based application provides an online platform for Company's possible clients to book a request 
				for their services. This project was mainly developed using PHP Language and MySQL Database. 
				It has a pleasant user interface using Bootstrap 5 Framework and Corona Dark Admin Template. 
				The project contains multiple features and functionalities.
			</p>
			<p style="text-align:justify;margin-left:30px">
				<br><b style="font-size:25px">How does the System Work?</b><br>
				<?php echo $name;?> is built with 2 modules which are the <b>Public</b> and the <b>Management</b> sites. 
				This project is a sort of Sales and Inventory System.
			</p>
			<p style="text-align:justify;margin-left:30px">
				On the <b>Management</b> side, this side is only accessible to the company management. 
				It requires the users to log in with their valid system user credentials to gain access 
				to the features and functionalities of this site. There 2 types of user roles on this project 
				which are the Administrator and the Staff. The Administrator has the privilege to access and manage 
				all the features and functionalities of this site while the staff only have limited permissions. 
				Here, users can manage the list of services, bookings, and inquiries. 
				They can also update the content of some public site's page content dynamically on this site.
			</p>	
			<p style="text-align:justify;margin-left:30px">
				On the <b>Public</b> Site, visitors, clients, or possible clients can explore the different 
				page content and list the active services that the company is providing. They can view and read 
				the whole details about the service they desire and book a request. The Booking Form requires 
				the clients to fill in all the required fields in order to submit the request. 
				Also, they can submit or send a message to the management for any concerns or requirements.
			</p>	
			<p style="text-align:justify;margin-left:30px">
				<br><b style="font-size:25px">Features and Functionalities</b><br>
				This <?php echo $name;?> is containing the following features and functionalities:
			</p>		
			<p style="text-align:justify;margin-left:30px">
				<b>Management Site</b><br>
				<div style="margin-left:80px;font-size:14px">
				<li>Add/Edit System Settings: About, Services, Category, Units, Website Status, Website Information</li>
				<li>Add/Edit Products, Customers, Technicians, Transactions, Sales, Manufacturers</li>
				<li>Database Management: View, Backup, Restore and Empty Data</li>
				<li>Add/Edit Media Galleries: Photos and Pictures</li>
				<li>Add/Edit Remove System Users</li>
				<li>Upload/Download Files</li>
				<li>Dark/Light Theme</li>
				<li>Login/Logout</li>
				</div>
			</p>		
			<p style="text-align:justify;margin-left:30px">
				<b>Public Site</b><br>
				<div style="margin-left:80px;font-size:14px">
				<li>Hone Page</li>
				<li>About Us</li>
				<li>Products</li>
				<li>Galleries</li>
				<li>Services</li>
				<li>Booking</li>
				<li>Contact</li>
				</div>
			</p><br>		
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:25px">Technologies</b><br>
				This <?php echo $name;?> was developed using the following Technologies:
				<div style="margin-left:80px;font-size:14px">
				<li>CSS</li>
				<li>PHP</li>
				<li>HTML</li>
				<li>WAMP</li>
				<li>jQuery</li>
				<li>JavaScript</li>
				<li>Notepad++</li>
				<li>MySQL Database</li>
				<li>Bootstrap Framework</li>
				<li>Corona Dark Admin Template</li>
				</div>
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:25px">Snapshots</b><br>
				Here are some snapshots of the <?php echo $name;?> project:
			</p>		
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Home Page</b>
				<img src="images/projects/<?php echo $proj;?>/homepage.jpg" class="snapshot">
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Services Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/services.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Booking Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/booking.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Dashboard (Light)</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-dashboard-light.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Dashboard (Dark)</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-dashboard-dark.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Customers</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-customers.jpg" class="snapshot">
			</p><br>			
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Database Management</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-database.jpg" class="snapshot">
			</p><br>		
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Galleries (Photos)</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-galleries-pics.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Galleries (Videos)</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-galleries-vids.jpg" class="snapshots">
			</p><br>		
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Manufacturers</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-manufacturer.jpg" class="snapshot">
			</p><br>			
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Products</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-products.jpg" class="snapshot">
			</p><br>				
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Sales</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-sales.jpg" class="snapshot">
			</p><br>		
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin System Settings</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-system-settings.jpg" class="snapshot">
			</p><br>			
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Users Management</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-users-mgt.jpg" class="snapshot">
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:25px">How to Run?</b><br>
				<b style="font-size:20px">Requirements</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li>PC width Min 8GB RAM</li>
					<li>Apache(WAMP) Server</li>
					<li>MySQL Database</li>
					<li>Notepad++</li>
				</div>
			</p>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">System Installation</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li>Download the source code @ www.mcjim-server.com/download/<?php echo $proj;?>.zip.</li>
					<li>Extract the downloaded file to your server (localhost) root folder ex. www for WAMP or htdocs on XAMMP.</li>
					<li>Import the included .sql file located in database folder which is the database of the system using phpMyAdmin.</li>
					<li>Edit the database name in all the connect.php files depending on the settings of the database you created sql file.</li>
				</div>
			</p>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">How to Use</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li>Use this administrator credential to login:</li>
					<ul>
						<li>Username: <b>admin</b></li>
						<li>Password: <b>admin</b></li>
					</ul>
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