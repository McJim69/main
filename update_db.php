<?php
require 'connect.php';

$sql1 = "ALTER TABLE mcjim_chat_room_members ADD COLUMN last_typing timestamp NULL DEFAULT NULL";
$conn->query($sql1);

echo "DB altered successfully.";
?>
