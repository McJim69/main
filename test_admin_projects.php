<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require("connect.php");
$_SESSION['user'] = 'Admin';
$_SESSION['access'] = 'Admin';

ob_start();
include("admin-projects.php");
$out = ob_get_clean();
echo $out;
?>
