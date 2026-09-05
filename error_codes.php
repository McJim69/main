<?php 
	require("connect.php");	
	require("header.php");
	require("menunav.php");
?>

<style>
.error{
	font-size:180px;
	border-radius:20px;
	padding-right:20px;
	padding-left:20px;
	opacity:.8;
	font-weight:550;
	color: rgba(0,0,0,.6);
	background: rgba(255, 255, 255, 0.05);
	backdrop-filter: blur(12px);
	-webkit-backdrop-filter: blur(12px);
	border: 1px solid rgba(255, 255, 255, 0.18);
	box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
	text-shadow: 3px 2px 3px rgba(255,255,255,.2);
}
@media (max-width:780px){.error{font-size:120px}}
</style>

<div class="page-heading header-text">
	<div class="container" style="margin-top:-40px">
	<?php
		$code="";
		$ecode = http_response_code();
		$erowo = "<div class='row justify-content-center'>";
		$error = "<div><h1>E R R O R</h1></div>";
		$erowc = "</div>";
		$erbtn = "<div class='row justify-content-center'><button class='btn btn-dark' onclick=\"jump('index.php')\"><i class='fa fa-home'></i> Back to Home</button></div>";
		$ertop = "<div style='margin-top: 30px'></div>";
		$erbot = "<div style='margin-bottom:-50px'></div>";
		if ($code == 400) { 
			echo $erowo; echo $error; echo $erowc; echo $erowo;
			echo "<div class='error'>400</div>";   echo $erowc; echo $ertop; echo $erowo;
			echo "<div style='color:#bbb'>Sorry, I don't understand what you want me to do.</div>";
			echo $erowc; echo $ertop; echo $erbtn; echo $erbot;
			
		} elseif ($code == 403) { 
			echo $erowo; echo $error; echo $erowc; echo $erowo;
			echo "<div class='error'>403</div>";   echo $erowc; echo $ertop; echo $erowo;
			echo "<div style='color:#bbb'>You aren't allowed to be here.</div>";
			echo $erowc; echo $ertop; echo $erbtn; echo $erbot;
			
		} elseif ($code == 408) { 
			echo $erowo; echo $error; echo $erowc; echo $erowo;
			echo "<div class='error'>408</div>";   echo $erowc; echo $ertop; echo $erowo;
			echo "<div style='color:#bbb'>I refuse to wait any longer.</div>";
			echo $erowc; echo $ertop; echo $erbtn; echo $erbot;
			
		} elseif ($code == 500) { 
			echo $erowo; echo $error; echo $erowc; echo $erowo;
			echo "<div class='error'>500</div>";   echo $erowc; echo $ertop; echo $erowo;
			echo "<div style='color:#bbb'>I don't know what to do. This isn't your fault.</div>";
			echo $erowc; echo $ertop; echo $erbtn; echo $erbot;
			
		} elseif ($code == 502) { 
			echo $erowo; echo $error; echo $erowc; echo $erowo;
			echo "<div class='error'>502</div>";   echo $erowc; echo $erowo; echo $ertop;
			echo "<div style='color:#bbb'>I received some invalid information from my master.</div>";
			echo $erowc; echo $ertop; echo $erbtn; echo $erbot;
			
		} else { 
			echo $erowo; echo $error; echo $erowc; echo $erowo;
			echo "<div class='error'>404</div>";   echo $erowc; echo $ertop; echo $erowo; 
			echo "<div style='color:#bbb'>I can't find what you are looking for...</div>";
			echo $erowc; echo $ertop; echo $erbtn; echo $erbot;
		}
	?>
	</div>
</div>

<?php require("footer.php");?>
