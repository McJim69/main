<?php
require_once '/var/www/html/billing/load.php';
$di = include '/var/www/html/billing/di.php';

$mail = new \FOSSBilling\Mail();
$mail->setDi($di);

$mail->setTo('admin@mcjim-server.com');
$mail->setFrom('admin@mcjim-server.com');
$mail->setSubject('Test via Symfony Mailer');
$mail->setBodyHtml('Hello world');

try {
    $mail->send();
    echo "Sent successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
