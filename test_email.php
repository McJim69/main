<?php
require_once '/var/www/html/billing/load.php';
$di = include '/var/www/html/billing/di.php';
$emailService = $di['mod_service']('email');
try {
    $res = $emailService->sendTemplate([
        'to' => 'admin@mcjim-server.com',
        'to_name' => 'Admin',
        'code' => 'mod_email_test'
    ]);
    echo "Email queued or sent: " . ($res ? 'true' : 'false') . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
