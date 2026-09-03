<?php
	// auto-logout.php
	$inactive_time = 1800; // 30 minutes

	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	if (isset($_SESSION['last_activity'])) {
		$elapsed_time = time() - $_SESSION['last_activity'];

		if ($elapsed_time > $inactive_time) {
			session_unset();
			session_destroy();
			header("Location: index.php?timeout");
			exit();
		}
	}

	// Update timestamp only if user is logged in
	if (isset($_SESSION['user'])) {
		$_SESSION['last_activity'] = time();
	}
?>
