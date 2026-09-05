<?php
session_start();
require("connect.php");

$_SESSION['user'] = 'Admin'; // Suppose user is Admin
$_SESSION['access'] = 'User';

// Insert dummy ticket
$conn->query("INSERT INTO mcjim_tickets (username, subject, description, priority) VALUES ('admin', 'Test', 'Desc', 'Low')");
$id = $conn->insert_id;

$_GET['action'] = 'fetch_ticket';
$_GET['id'] = $id;

ob_start();
include("ajax_support.php");
$out = ob_get_clean();
echo "OUT:\n" . $out;
?>
