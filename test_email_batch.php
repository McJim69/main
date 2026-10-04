<?php
require_once '/var/www/html/billing/load.php';
$di = include '/var/www/html/billing/di.php';
$emailService = $di['mod_service']('email');

try {
    $emailService->sendTemplate([
        'to' => 'admin@mcjim-server.com',
        'to_name' => 'Admin',
        'code' => 'mod_email_test'
    ]);
    echo "Template queued.\n";
    
    // Now forcefully process the queue!
    $emailService->batchSend();
    echo "Batch send completed.\n";
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
