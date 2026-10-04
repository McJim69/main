<?php
require_once '/var/www/html/billing/load.php';
$di = include '/var/www/html/billing/di.php';

$api = $di['api_admin'];
try {
    $api->email_email_send([
        'to' => 'admin@mcjim-server.com',
        'to_name' => 'McJim',
        'from' => 'admin@mcjim-server.com',
        'from_name' => 'FOSSBilling',
        'client_id' => 21,
        'subject' => 'Test Email to Client',
        'content' => 'This is a test email sent via the Admin API.'
    ]);
    echo "API call queued email for client 21.\n";
    
    // Process queue
    $api->email_batch_sendmail();
    echo "Batch send processed.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
