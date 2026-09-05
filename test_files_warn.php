<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require("connect.php");
$_SESSION['user'] = 'Admin';
$_SESSION['access'] = 'Admin';

$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET['action'] = 'get';
$_GET['pid'] = 999999; // The one we inserted earlier!

ob_start();
include("ajax_projects_crud.php");
$out = ob_get_clean();
echo "OUT:\n" . $out;
?>
