<?php
	// Start session
	session_start();

	// Clear all session variables
	$_SESSION = array();

	// If cookies are used, expire them
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	// Destroy the session
	session_destroy();

	// Force expire across subdomains
	setcookie("PHPSESSID", "", time() - 3600, "/", ".mcjim-server.com");

	// Optional: redirect to login page
	header("Location: /login.php");
	exit;
?>