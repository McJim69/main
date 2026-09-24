<?php
require_once 'load.php';
$di = include 'di.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header('Location: https://mcjim-server.com/webhosting.html?error=missing');
    exit;
}

try {
    $api_guest = $di['api_guest'];
    $result = $api_guest->client_login(['email' => $email, 'password' => $password]);
    
    header('Location: /');
    exit;
} catch (Exception $e) {
    header('Location: https://mcjim-server.com/webhosting.html?error=invalid');
    exit;
}
