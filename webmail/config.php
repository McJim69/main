<?php
// Mailcow API Configuration
// Replace 'YOUR_MAILCOW_API_KEY_HERE' with your actual Mailcow API key.
// Ensure this file is NOT accessible directly by configuring your web server or placing it outside the public directory if possible.

define('MAILCOW_API_KEY', 'A1B2C3D4E5F67890A1B2C3D4E5F67890');
define('MAILCOW_API_URL', 'https://mail.mcjim-server.com/api/v1');
define('MAILCOW_DOMAIN', 'mcjim-server.com'); // Default domain for new accounts

// Function to handle JSON responses
function sendJsonResponse($success, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}
?>
