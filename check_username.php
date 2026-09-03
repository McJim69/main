<?php
	require("connect.php");
	header('Content-Type: application/json');
	if (isset($_GET['username'])) {
		$username = trim($_GET['username']);
		$stmt = $conn->prepare("SELECT uno FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();
		echo json_encode(["available" => $stmt->num_rows === 0]);
		$stmt->close();
	}
?>
