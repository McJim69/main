<?php
require_once '/var/www/html/billing/load.php';
$di = include '/var/www/html/billing/di.php';

$api = $di['api_guest'];
try {
    $api->client_reset_password(['email' => 'admin@mcjim-server.com']);
    echo "Password reset requested.\n";
    
    // Process queue
    $di['api_admin']->email_batch_sendmail();
    echo "Batch send processed.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
