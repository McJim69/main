<?php 
	require("connect.php");
	require("header.php");
	require("menunav.php");
	$proj="enrollment";
	$name="Student Enrollment System";
	require("prohead.php");
?>

<div id="<?php echo $proj;?>" style="margin-top:60px">
	<div class="container" id="<?php echo $proj;?>">
		<h3><b><?php echo $name;?></b></h3>
		<p style="text-align:justify;margin-left:30px">
			<?php echo $name;?> is created using PHP/MySQL and this application can help reduce the manpower 
			needed to facilitate an enrollment process. The double entries on enrolling two people at the same 
			time can eliminate human error. Online student enrollment enables students to enroll in their subjects
			prior to the commencement of their semesters.

		</p>
		<p style="text-align:justify;margin-left:30px">
			<br><b style="font-size:25px">Information</b><br>
		</p>		
		<p style="text-align:justify;margin-left:30px">
			<div style="margin-left:80px;font-size:14px">
				<li>Project Name: <?php echo $name;?></li>
				<li>Primary Language: PHP</li>
				<li>PHP Versions: 5.5 / 7.0</li>
				<li>Database Used: MySQL/MariaDB</li>
				<li>Application Type: Web</li>				
			</div>
		</p><br>	
		<p style="text-align:justify;margin-left:30px">
			<b style="font-size:25px">Features and Functionalities</b><br>
		</p>		
		<p style="text-align:justify;margin-left:30px">
			<div style="margin-left:80px;font-size:14px">
				<li>Students can create user account and fill-up enrollment form.</li>
				<li>It has an entry for Students, Course, Subject, Department and Faculty.</li>
				<li>Reservation of subject during the enrollment process.</li>
				<li>It is capable of advising of subject to the student by the Deans.</li>
				<li>Able to assign and assess the number of units.</li>
				<li>Class Listing</li>
				<li>Class scheduling</li>
				<li>Faculty subject loading</li>
				<li>Query filters for different entries</li>
				<li>Administrators can Backup, Restore and Empty Database.</li>
			</div>
		</p><br>	
		
		<p style="text-align:justify;margin-left:30px">
			<b style="font-size:25px">Snapshots</b><br>
				Here are some snapshots of the <?php echo $name;?> project:<br>
			<div style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Login Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/login-page.jpg" class="snapshot">
				</div><br>
			<div style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Home Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/home-page.jpg" class="snapshot">
			</div><br>
			<div style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Enrollment Form</b><br>
				<img src="images/projects/<?php echo $proj;?>/enrollment-form.jpg" class="snapshot">
			</div><br>	
			<div style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Student List</b><br>
				<img src="images/projects/<?php echo $proj;?>/student-list.jpg" class="snapshot">
			</div><br>
			<div style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Filled-up Form</b><br>
				<img src="images/projects/<?php echo $proj;?>/filledup-form.jpg" class="snapshot">
			</div><br>
			<div style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Backup/Restore Database</b><br>
				<img src="images/projects/<?php echo $proj;?>/backup-database.jpg" class="snapshot">
			</div>
		</p><br>
		<p style="text-align:justify;margin-left:30px">
			<b style="font-size:20px">System Installation</b><br>
			<div style="margin-left:80px;font-size:14px">
				<li><b>Download</b> the source code @ www.mcjim-server.com/download/<?php echo $proj;?>.zip</li>
				<li><b>Extract</b> the downloaded file to your server (localhost) root folder ex. <b>www</b> for WAMP or <b>htdocs</b> on XAMMP.</li>
				<li><b>Import</b> the included <b>.sql</b> file located in <b>db</b> folder which is the database of the system using <b>phpMyAdmin</b>.</li>
				<li>After a successful import, open the extracted folder and open <b>config.php</b> and <b>config2.php</b> in both the <b>includes</b> folder and in the <b>wpenroll/includes folder</b>.</li>
				<li><b>Edit</b> the database name in the connection depending on the name of the database you created in importing the included <b>.sql</b> file.</li>
				<li><b>Install</b> Database using browser ==> http://localhost/wpenroll/installDB.php.
			</div>
		</p><br>
		<p style="text-align:justify;margin-left:30px">
			<b style="font-size:20px">Type of Users and Priviledges</b><br>
			<div style="margin-left:80px;font-size:14px">
				<li><b>Administrator</b></li>
				<div style="margin-left:30px;font-size:13px">
					<li>CRUD Users Profile</li>
					<li>Backup, Restore and Empty Database</li>
					<li>CRUD any other data entries and functions</li>
				</div>
				<li><b>Registrar</b></li>
				<div style="margin-left:30px;font-size:13px">
					<li>CRU Users Profile</li>
					<li>Backup Database</li>
					<li>CRU any other data entries and functions</li>
				</div>
				<li><b>Encoder</b></li>
				<div style="margin-left:30px;font-size:13px">
					<li>Backup Database</li>
					<li>CRU any other data entries and functions</li>
				</div>						
				<li><b>Student</b></li>
				<div style="margin-left:30px;font-size:13px">
					<li>Signup, Login and Fill-up Enrollment Form</li>
					<li>Access only his/her own personal information</li>
				</div>	
			</div>
		</p><br>
		<p style="text-align:justify;margin-left:30px">
			<b style="font-size:20px">Default Login Credentials</b><br>
			<div style="font-size:13px;text-align:justify;margin-left:65px">
				<table class="table table-responsive">
					<thead>
						<th style="border:1px solid #bbb;padding:5px">Access</th>
						<th style="border:1px solid #bbb;padding:5px">Username</th>
						<th style="border:1px solid #bbb;padding:5px">Password</th>
					</thead>
					<tbody>
						<td style="border:1px solid #bbb;padding:5px">Administrator</td>
						<td style="border:1px solid #bbb;padding:5px">admin@westprime.com</td>
						<td style="border:1px solid #bbb;padding:5px">admin</td>
					</tbody>
					<tbody>
						<td style="border:1px solid #bbb;padding:5px">Registrar</td>
						<td style="border:1px solid #bbb;padding:5px">registrar@westprime.com</td>
						<td style="border:1px solid #bbb;padding:5px">registrar</td>
					</tbody>	
					<tbody>
						<td style="border:1px solid #bbb;padding:5px">Encoder</td>
						<td style="border:1px solid #bbb;padding:5px">encoder@westprime.com</td>
						<td style="border:1px solid #bbb;padding:5px">encoder</td>
					</tbody>
					<tbody>
						<td style="border:1px solid #bbb;padding:5px">Student</td>
						<td style="border:1px solid #bbb;padding:5px">student@westprime.com</td>
						<td style="border:1px solid #bbb;padding:5px">student</td>
					</tbody>						
				</table>
			</div>
		</p><br><br>
		<div style="text-align:center">
			<a href="/../projects/<?php echo $proj;?>/"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">TESTDEMO</button></a>
			<a href="/../download/"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">DOWNLOAD</button></a>
			<a href="/../projects/"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">TEMPLATES</button></a>
			<a href="index.php"><button style="width:222px;margin-top:5px" class="btn btn-sm btn-secondary">BACKHOME</button></a>	
		</div>
	</div>
</div><br><br>

<?php require("footer.php");?>