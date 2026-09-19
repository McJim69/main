<?php
require_once 'config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, 'Only POST requests are allowed.');
}

$rawInput = file_get_contents("php://input");
$input = json_decode($rawInput, true);

if (!isset($input['action'])) {
    sendJsonResponse(false, 'No action specified.');
}

$action = $input['action'];

if ($action === 'create-account') {
    if (empty($input['email']) || empty($input['password'])) {
        sendJsonResponse(false, 'Email and password are required.');
    }

    $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
    $password = $input['password'];
    
    if (strpos($email, '@') === false) {
        $email = $email . '@' . MAILCOW_DOMAIN;
    }

    $data = [
        'local_part' => explode('@', $email)[0],
        'domain' => explode('@', $email)[1],
        'password' => $password,
        'password2' => $password,
        'active' => 1,
        'name' => explode('@', $email)[0],
        'quota' => 3072
    ];

    $ch = curl_init(MAILCOW_API_URL . '/add/mailbox');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-API-Key: ' . MAILCOW_API_KEY
    ]);
    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $responseData = json_decode($response, true);

    // Some Mailcow responses return an array of objects
    $isSuccess = false;
    foreach ($responseData as $res) {
        if (isset($res['type']) && $res['type'] === 'success') {
            $isSuccess = true;
            break;
        }
    }
		
    if ($httpCode >= 200 && $httpCode < 300 && $isSuccess) {
        sendJsonResponse(true, 'Account created successfully!', $responseData);
    } else {
        $errorMsg = isset($responseData[0]['msg']) ? $responseData[0]['msg'] : (isset($responseData['msg']) ? $responseData['msg'] : 'Failed to create account.');
        sendJsonResponse(false, "Mailcow Error: " . $errorMsg, $responseData);
    }
} else {
    sendJsonResponse(false, 'Invalid action.');
}
?>
