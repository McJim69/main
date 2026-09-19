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

// Authenticate against Jellyfin and get AccessToken
function get_jellyfin_token($user, $pass) {
    $url = "https://media.mcjim-server.com/Users/AuthenticateByName";
    $payload = json_encode([
        "Username" => $user,
        "Pw"       => $pass
    ]);
    $headers = [
        "Content-Type: application/json",
        "X-Emby-Authorization: MediaBrowser Client=\"PHP\", Device=\"Web\", DeviceId=\"mcjim-sso\", Version=\"1.0\""
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Disable SSL verification in case of local cert issues
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    file_put_contents("d:/Server/www/jellyfin_debug.log", "URL: $url\nPayload: $payload\nError: $error\nResponse: $response\n\n", FILE_APPEND);

    $data = json_decode($response, true);
    
    if (isset($data["AccessToken"]) && isset($data["User"]["Id"]) && isset($data["ServerId"])) {
        // Return a JSON string that the frontend can put directly into localStorage
        $authObj = [
            "Token"    => $data["AccessToken"],
            "UserId"   => $data["User"]["Id"],
            "ServerId" => $data["ServerId"],
            "DeviceId" => "mcjim-sso",
            "UserObj"  => $data["User"]
        ];
        return base64_encode(json_encode($authObj));
    }
    
    return null;
}
?>