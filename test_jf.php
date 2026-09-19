<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$url = "https://media.mcjim-server.com/System/Info/Public";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

echo "Public Info Response: " . $response . "\n";
?>
