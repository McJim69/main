<?php
	require("connect.php");

	// Auth + Admin guard — only admins can update user records
	if (!isset($_SESSION['user']) || !isset($_SESSION['access']) || $_SESSION['access'] !== 'Admin') {
		http_response_code(403);
		die(json_encode(["status" => "ERROR", "message" => "Unauthorized"]));
	}

	header('Content-Type: application/json');

	$target = $_GET["target"] ?? '';
	$uno    = intval($_GET["uno"] ?? 0);
	$value  = $_GET["value"] ?? '';

	$allowed = ['access','status']; // allow both columns
	if (!in_array($target, $allowed)) {
		die(json_encode(["status"=>"ERROR","message"=>"Invalid target column"]));
	}

	if ($uno <= 0 || empty($value)) {
		die(json_encode(["status"=>"ERROR","message"=>"Invalid parameters"]));
	}

	try {
		$stmt = $conn->prepare("UPDATE users SET $target=? WHERE uno=?");
		$stmt->bind_param("si", $value, $uno);
		$stmt->execute();
		$stmt->close();

		echo json_encode(["status"=>"OK","uno"=>$uno,"target"=>$target,"value"=>$value]);
	} catch (mysqli_sql_exception $e) {
		echo json_encode(["status"=>"ERROR","message"=>$e->getMessage()]);
	}
?>
