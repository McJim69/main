<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
$_REQUEST['action'] = 'add_server';
$_POST['action'] = 'add_server';
$_POST['server_name'] = 'Test';
$_POST['url'] = 'https://test.com';

session_start();
$_SESSION['user'] = 'Admin';
$_SESSION['access'] = 'Admin';

ob_start();
include("ajax_monitoring.php");
$out = ob_get_clean();
echo "OUT:\n" . $out;
?>
