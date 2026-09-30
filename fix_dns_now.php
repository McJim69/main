<?php
$apiUrl = "https://10.0.10.51:8090/api/submitDNSRecord";

$payload = [
    'adminUser'   => 'admin',
    'adminPass'   => 'McJim654123',
    'domainName'  => 'victoryfreewifi.net',
    'recordName'  => 'uisp',
    'recordType'  => 'A',
    'recordValue' => '10.0.10.130',
    'recordTTL'   => 3600
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

echo "Response:\n";
if ($error) {
    echo "cURL Error: " . $error . "\n";
} else {
    echo $response . "\n";
}
?>
