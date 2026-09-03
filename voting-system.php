<?php 
	require("connect.php");
	require("header.php");
	require("menunav.php");
	$proj="voting-system";
	$name="Online Voting System";
	require("prohead.php");
?>

<div id="<?php echo $proj;?>" style="margin-top:60px">
	<div class="container" id="<?php echo $proj;?>">
		<h3><b><?php echo $name;?></b></h3>
			<p style="text-align:justify;margin-left:30px">
				The <?php echo $name;?> web application using PHP/MySQL is a project that serves as the automated 
				voting system of an organization or school. This system works like the common manual system of election 
				voting system whereas this system must be populated by the list of the positions, candidates, and voters. 
			</p>
			<p style="text-align:justify;margin-left:30px">
				This system can help a certain organization or school to minimize the voting time duration because aside 
				they can provide the voters an online platform to vote, the system will automatically count the votes for 
				each candidate. The system has 2 sides of the user interface which are the administrator and voters’ side. 
				The admin user is in charge to populate and manage the data of the system and the voter side which is where 
				the voters will choose their candidate and submit their votes.
			</p>	
			<p style="text-align:justify;margin-left:30px">
				<br><b style="font-size:25px">Features and Functionalities</b><br>
				<?php echo $name;?> is containing the following features:
			</p>	
			<p style="text-align:justify;margin-left:30px">
				<div style="margin-left:80px;font-size:14px">
					<li>Vote Preview</li>
					<li>Multiple Votes</li>
					<li>CRUD Voters</li>
					<li>CRUD Positions</li>
					<li>CRUD Candidate</li>
					<li>Print Voting Results in PDF</li>
					<li>Result Tally via Horizontal Bar Chart</li>					
				</div>
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:25px">Plugins</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li>TCPDF</li>
					<li>Backup</li>
					<li>AdminLTE</li>					
				</div>
			</p><br>		
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:25px">Snapshots</b><br>
				Here are some snapshots of the <?php echo $name;?> project:
			</p>		
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Voters Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/voters-page.jpg" class="snapshot">
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Admin Page</b><br>
				<img src="images/projects/<?php echo $proj;?>/admin-page.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Voters List</b><br>
				<img src="images/projects/<?php echo $proj;?>/voters-list.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Backup Database</b><br>
				<img src="images/projects/<?php echo $proj;?>/backup-database.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Candidate List</b><br>
				<img src="images/projects/<?php echo $proj;?>/candidate-list.jpg" class="snapshot">
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">Candidate Position</b><br>
				<img src="images/projects/<?php echo $proj;?>/candidate-position.jpg" class="snapshot">
			</p><br>
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">System Installation</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li><b>Download</b> the source code @ www.mcjim-server.com/download/<?php echo $proj;?>.zip</li>
					<li><b>Extract</b> the downloaded file to your server (localhost) root folder ex. <b>www</b> for WAMP or <b>htdocs</b> on XAMMP.</li>
					<li><b>Import</b> the included <b>.sql</b> file located in <b>db</b> folder which is the database of the system using <b>phpMyAdmin</b>.</li>
					<li>After a successful import, open the extracted folder and open <b>conn.php</b> in both the <b>includes</b> folder and in the <b>admin/includes folder</b>.</li>
					<li><b>Edit</b> the database name in the connection depending on the name of the database you created in importing the included <b>.sql</b> file.</li>
				</div>
			</p><br>	
			<p style="text-align:justify;margin-left:30px">
				<b style="font-size:20px">How to Use</b><br>
				<div style="margin-left:80px;font-size:14px">
					<li>Login as administrator by adding <b>/admin/</b> in the <b>URL</b> example: http://localhost/admin. You should be redirected to the admin login page.</li>
					<li>Use this administrator credential to login:</li>
					<div style="margin-left:40px;font-size:12px">
						<li>Username: <b>admin</b></li>
						<li>Password: <b>admin</b></li>
					</div>
					<li><b>Add</b> the important data such as positions, candidates, and voters.</li>
					<li><b>Change</b> the title of the election by clicking the <b>Election Title</b> menu.</li>
					<li><b>Rearrange</b> the order of positions depending on the desired order to show in the ballot using the <b>Ballot Position</b> menu.</li>
					<li><b>Note: Voter IDs</b> should be distributed appropriately to participating voters to avoid mix-ups.</li>
					<li><b>Click Print</b> for election results.</li>
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