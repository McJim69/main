<?php
	// ajax_monitoring_servers.php
	session_start();
	require_once("connect.php");
	header('Content-Type: application/json; charset=utf-8');

	// 1. Unified Authentication Check
	if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
		echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
		exit;
	}

	if ($_SESSION["access"] !== "Admin") {
		echo json_encode(['status' => 'error', 'message' => 'Access denied']);
		exit;
	}

	// Buhaton ang write close para dili ma-lock ang session sa ubang dungan nga requests
	session_write_close(); 

	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

	if ($action == '') {
		echo json_encode(['status' => 'error', 'message' => 'No action specified']);
		exit;
	}

	// ACTION A: Fetch FOSSBilling Metrics (Gi-integrate gikan sa pikas file)
	if ($action == 'fetch_billing') {
		require_once("credentials.php");
		$sharedSecret = FOSSBILLING_SSO_SECRET;

		$payload = [
			'action' => 'get_metrics',
			'time' => time(),
			'email' => $_SESSION['email'] ?? 'admin@mcjim-server.com'
		];

		$payloadJson = json_encode($payload);
		$payloadBase64 = base64_encode($payloadJson);
		$signature = hash_hmac('sha256', $payloadBase64, $sharedSecret);

		$ch = curl_init('https://mcjim-server.com');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
			'payload' => $payloadBase64,
			'signature' => $signature
		]));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 6); // Safety boundary fallback timeout

		$response = curl_exec($ch);
		$curlError = curl_error($ch);
		curl_close($ch);

		// Safety protection framework batay sa network structure status
		if ($response === false || empty($response)) {
			echo json_encode([
				'status' => 'error', 
				'message' => 'Billing portal unreachable: ' . $curlError,
				'income' => '0.00', 'clients' => '-', 'tickets' => '-'
			]);
			exit;
		}

		$testJson = json_decode($response, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			echo json_encode([
				'status' => 'error', 'message' => 'Invalid JSON from billing target source',
				'income' => '0.00', 'clients' => '-', 'tickets' => '-'
			]);
			exit;
		}

		echo $response;
		exit;
	}

	// ACTION B: Fetch Monitored Servers
	if ($action == 'fetch_servers') {
		$query = "SELECT * FROM mcjim_monitored_servers ORDER BY server_name ASC";
		$result = mysqli_query($conn, $query);
		$servers = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$servers[] = $row;
		}
		echo json_encode(['status' => 'success', 'data' => $servers]);
		exit;
	}

	// ACTION C: Add New Server Entry
	if ($action == 'add_server') {
		$name = isset($_POST['server_name']) ? trim($_POST['server_name']) : '';
		$url = isset($_POST['url']) ? trim($_POST['url']) : '';
		
		if (empty($name) || empty($url)) {
			echo json_encode(['status' => 'error', 'message' => 'Name and URL are required']);
			exit;
		}
		
		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid URL format']);
			exit;
		}
		
		$now = date('Y-m-d H:i:s');
		$stmt = $conn->prepare("INSERT INTO mcjim_monitored_servers (server_name, url, created_at) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $name, $url, $now);
		
		if ($stmt->execute()) {
			echo json_encode(['status' => 'success', 'message' => 'Server added']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to add server']);
		}
		exit;
	}

	// ACTION D: Delete Monitored Server
	if ($action == 'delete_server') {
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		
		$stmt = $conn->prepare("DELETE FROM mcjim_monitored_servers WHERE id = ?");
		$stmt->bind_param("i", $id);
		
		if ($stmt->execute()) {
			echo json_encode(['status' => 'success', 'message' => 'Server deleted']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete server']);
		}
		exit;
	}

	// ACTION E: Run Individual Server Ping Check
	if ($action == 'check_server') {
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		
		$stmt = $conn->prepare("SELECT url FROM mcjim_monitored_servers WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$res = $stmt->get_result()->fetch_assoc();
		
		if (!$res) {
			echo json_encode(['status' => 'error', 'message' => 'Server not found']);
			exit;
		}
		
		$url = $res['url'];
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
		$start = microtime(true);
		curl_exec($ch);
		$end = microtime(true);
		
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlError = curl_error($ch);
		curl_close($ch);
		
		$status = 'Offline';
		if ($httpCode >= 200 && $httpCode < 400 && empty($curlError)) {
			$status = 'Online';
		}
		
		$responseTime = intval(($end - $start) * 1000);
		$now = date('Y-m-d H:i:s');
		
		$stmtUpdate = $conn->prepare("UPDATE mcjim_monitored_servers SET status = ?, response_time_ms = ?, last_checked = ? WHERE id = ?");
		$stmtUpdate->bind_param("sisi", $status, $responseTime, $now, $id);
		$stmtUpdate->execute();
		
		echo json_encode([
			'status' => 'success',
			'data' => [
				'id' => $id,
				'server_status' => $status,
				'response_time_ms' => $responseTime,
				'last_checked' => $now
			]
		]);
		exit;
	}

	echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
