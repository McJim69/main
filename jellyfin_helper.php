<?php
	require_once("jellyfin_token.php");

	// ✅ Helper function to call Jellyfin API using stored per-user token
	function jellyfin_api($endpoint) {

		$token = API_KEY;

		$url = WEB_HOST . $endpoint;
		$headers = [
			"X-Emby-Authorization: MediaBrowser Client=\"PHP\", Device=\"Web\", DeviceId=\"12345\", Version=\"1.0\", Token=\"$token\""
		];

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}
?>

<?php

//	// ✅ If Jellyfin userId exists, try to authenticate
//	if (!empty($rs['uno'])) {
//		$url = "https://media.mcjim-server.com/Users/AuthenticateByName";
//		$payload = json_encode([
//			"Name"     => $user,
//			"Password" => $pass
//		]);
//		$headers = [
//			"Content-Type: application/json",
//			"X-Emby-Authorization: MediaBrowser Client=\"PHP\", Device=\"Web\", DeviceId=\"12345\", Version=\"1.0\""
//		];
//
//		$ch = curl_init($url);
//		curl_setopt($ch, CURLOPT_POST, true);
//		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//		$response = curl_exec($ch);
//		curl_close($ch);
//
//		$data = json_decode($response, true);
//		$jellyfinToken = $data["AccessToken"] ?? null;
//
//		if ($jellyfinToken) {
//			// ✅ Update DB with fresh token
//			$updateStmt = $conn->prepare("UPDATE users SET jellyfin=? WHERE uno=?");
//			$updateStmt->bind_param("si", $jellyfinToken, $rs["uno"]);
//			$updateStmt->execute();
//			$updateStmt->close();
//		}
//	}
//
//	// ✅ Set cookie only if token exists
//	if ($jellyfinToken) {
//		setcookie("jellyfin_auth", $jellyfinToken, time()+3600, "/", ".mcjim-server.com", true, true);
//	}

?>