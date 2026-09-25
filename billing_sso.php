<?php
require("connect.php");

// 1. Ensure user is logged into the main site
if (!isset($_SESSION["uno"]) || !isset($_SESSION["user"])) {
    header("Location: login.php?return=billing_sso.php");
    exit();
}

// 2. Fetch the latest user info from the database (including email and fullname)
$stmt = $conn->prepare("SELECT fullname, username, email FROM users WHERE uno = ? LIMIT 1");
$stmt->bind_param("i", $_SESSION["uno"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found.");
}

// If email is empty (legacy users), generate one based on username
$email = !empty($user['email']) ? $user['email'] : preg_replace('/[^a-zA-Z0-9._-]/', '', $user['username']) . '@mcjim-server.com';
$fullname = !empty($user['fullname']) ? $user['fullname'] : $user['username'];
$username = $user['username'];

// 3. Define the Shared Secret Key (MUST MATCH THE ONE ON FOSSBILLING)
require_once("credentials.php");
$sharedSecret = FOSSBILLING_SSO_SECRET;

// 4. Create the payload
$payload = [
    'fullname' => $fullname,
    'username' => $username,
    'email'    => $email,
    'time'     => time(),
    'return'   => $_GET['return'] ?? '/',
    'query'    => $_SERVER['QUERY_STRING'] // Pass all query params
];

$payloadJson = json_encode($payload);
$payloadBase64 = base64_encode($payloadJson);

// 5. Generate HMAC signature
$signature = hash_hmac('sha256', $payloadBase64, $sharedSecret);

// 6. Redirect to FOSSBilling SSO Receiver
$redirectUrl = "https://billing.mcjim-server.com/sso_receiver.php?payload=" . urlencode($payloadBase64) . "&signature=" . urlencode($signature);

header("Location: " . $redirectUrl);
exit();
?>
