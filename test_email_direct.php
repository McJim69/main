<?php
require_once '/var/www/html/billing/load.php';
$di = include '/var/www/html/billing/di.php';
$mail = $di['mail'];
$mail->setTo('admin@mcjim-server.com');
$mail->setFrom('admin@mcjim-server.com');
$mail->setSubject('Test directly');
$mail->setBodyHtml('Hello world');
try {
    $mail->send();
    echo "Sent successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
