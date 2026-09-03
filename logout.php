<?php
	session_start();
	$_SESSION = [];
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	setcookie("PHPSESSID", "", time() - 3600, "/", ".mcjim-server.com");	
	session_unset();  
	session_destroy();
	header("Location: landing.php?logout=success");
	exit();
?>