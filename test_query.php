<?php
require 'connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$room_id = 1;
$currentUser = 'admin';

$metaQuery = "SELECT m.username, last_seen_message_id, (last_typing > DATE_SUB(NOW(), INTERVAL 5 SECOND)) as is_typing, u.imgUrl FROM mcjim_chat_room_members m INNER JOIN users u ON m.username = u.username WHERE room_id = ? AND m.username != ?";
$metaStmt = $conn->prepare($metaQuery);
if (!$metaStmt) {
    echo "Prepare failed: " . $conn->error;
} else {
    echo "Prepare succeeded!";
}
?>
