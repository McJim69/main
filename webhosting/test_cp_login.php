<?php
// Test CyberPanel API login
$host = 'panel.mcjim-server.com';
$port = '8090';
$username = 'louieca0'; // from your screenshot
$password = 'REPLACE_ME'; // I will ask user to replace this or we can test admin?

$url = "https://{$host}:{$port}/api/loginAPI";

$payload = [
    'username' => $username,
    'password' => $password,
    'languageSelection' => 'english'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
}
curl_close($ch);

echo "Response from CyberPanel:\n";
echo $response;
