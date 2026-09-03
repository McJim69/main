<?php
$username = "Decon123";
$password = "Decon123";

$url = "https://media.mcjim-server.com/Users/New";

// ✅ Build raw JSON string manually (same as CLI)
$payload = '{
  "Name": "'.$username.'",
  "Password": "'.$password.'",
  "Policy": {},
  "Configuration": {}
}';

$headers = [
    "Content-Type: application/json",
    "Content-Length: " . strlen($payload),
    "X-Emby-Authorization: MediaBrowser Client=\"PHP\", Device=\"Web\", DeviceId=\"12345\", Version=\"1.0\", Token=\"93cc2300dbe64aaf98e878aca88813dd\""
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h3>HTTP Code: $httpCode</h3>";
echo "<h3>Payload Sent:</h3><pre>" . htmlspecialchars($payload) . "</pre>";
echo "<h3>Raw Response:</h3><pre>" . htmlspecialchars($response) . "</pre>";
