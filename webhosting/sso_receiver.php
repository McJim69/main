<?php
/**
 * sso_receiver.php
 * UPLOAD THIS FILE TO THE ROOT OF YOUR FOSSBILLING INSTALLATION ON 10.0.10.52
 * (e.g. /var/www/fossbilling/sso_receiver.php)
 */

require_once 'load.php';
$di = include 'di.php';

$payloadBase64 = $_GET['payload'] ?? '';
$signature = $_GET['signature'] ?? '';

// MUST MATCH THE SECRET IN credentials.php ON THE MAIN SITE (10.0.10.15)
// Replace 'YOUR_SECRET_HERE' with the actual FOSSBILLING_SSO_SECRET value
$sharedSecret = '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08';

if (empty($payloadBase64) || empty($signature)) {
    die("Missing SSO payload or signature.");
}

$expectedSignature = hash_hmac('sha256', $payloadBase64, $sharedSecret);

if (!hash_equals($expectedSignature, $signature)) {
    die("Invalid SSO signature. Check your Shared Secret Key.");
}

$payload = json_decode(base64_decode($payloadBase64), true);

if (!$payload || !isset($payload['time'])) {
    die("Invalid SSO payload.");
}

// Expire the token after 60 seconds to prevent replay attacks
if (time() - $payload['time'] > 60) {
    die("SSO token expired. Please try logging in again.");
}

$email = $payload['email'];
$fullname = $payload['fullname'];
$username = $payload['username'];

// Get First Name and Last Name
$nameParts = explode(' ', $fullname, 2);
$firstName = $nameParts[0];
$lastName = $nameParts[1] ?? 'User';

// 1. Find the client by email
$client = $di['db']->findOne('Client', 'email = ?', [$email]);

if (!$client) {
    // 2. Auto-register if the client doesn't exist in FOSSBilling yet
    $clientService = $di['mod_service']('client');
    $password = bin2hex(random_bytes(10)); // Random secure password
    
    try {
        $clientId = $clientService->clientCreate([
            'email'      => $email,
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'password'   => $password,
            'currency'   => 'USD' // Change if your default currency is different
        ]);
        $client = $di['db']->load('Client', $clientId);
    } catch (Exception $e) {
        die("Failed to auto-register user in FOSSBilling: " . $e->getMessage());
    }
}

// 3. Log the user in securely via FOSSBilling Session
$di['session']->set('client_id', $client->id);
$di['session']->set('client', true);

$returnUrl = $payload['return'] ?? '/';
$queryString = $payload['query'] ?? '';

// Build final redirect URL
$finalRedirect = $returnUrl;
if (!empty($queryString)) {
    // Remove 'return=' from the query string to clean it up
    $cleanQuery = preg_replace('/&?return=[^&]*/', '', $queryString);
    if (!empty($cleanQuery)) {
        $finalRedirect .= '?' . ltrim($cleanQuery, '&');
    }
}

// 4. Redirect them to the requested page!
header("Location: " . $finalRedirect);
exit();
