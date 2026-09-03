<?php
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
		header("X-Remote-User: " . $_SESSION['user']);
		http_response_code(200);
		exit;
	}
	http_response_code(401);
	exit;
?>