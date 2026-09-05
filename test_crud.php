<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require("connect.php");
// Mock session
$_SESSION['user'] = 'Admin';
$_SESSION['access'] = 'Admin';

// Call the script directly
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['action'] = 'update';
$_POST['pid'] = 999999;
$_POST['pname'] = 'Test Update';
$_POST['description'] = 'Test desc';
$_POST['plink'] = 'test-link';
$_POST['pimgUrl'] = 'test.jpg';
$_POST['long_desc'] = 'long desc';
$_POST['how_itworks'] = 'works';
$_POST['management'] = 'management';
$_POST['mgt_public'] = 'pub';
$_POST['mgt_admin'] = 'admin';
$_POST['features'] = 'features';
$_POST['tech_used'] = 'tech';

ob_start();
include("ajax_projects_crud.php");
$output = ob_get_clean();
echo "Output: " . $output;
?>
