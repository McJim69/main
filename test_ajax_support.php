<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET['action'] = 'fetch_ticket';
$_GET['id'] = '1';

session_start();
$_SESSION['user'] = 'Admin';
$_SESSION['access'] = 'User'; // Make them non-admin!

ob_start();
include("ajax_support.php");
$out = ob_get_clean();
echo "OUT:\n" . $out;
?>
