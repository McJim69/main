<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET['id'] = 1;

session_start();
$_SESSION['user'] = 'Admin';
$_SESSION['access'] = 'Admin';
$_SESSION['id'] = 1;

ob_start();
include("view-invoice.php");
$out = ob_get_clean();
echo "OUT:\n" . substr($out, 0, 500);
?>
