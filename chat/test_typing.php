<?php
require("../connect.php");

// Check if last_typing column exists
$res = mysqli_query($conn, "DESCRIBE mcjim_chat_room_members");
echo "=== mcjim_chat_room_members schema ===\n";
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " (" . $row['Type'] . ") default: " . $row['Default'] . "\n";
}

// Test typing update query
echo "\n=== Testing typing update ===\n";
$stmt = $conn->prepare("UPDATE mcjim_chat_room_members SET last_typing = CURRENT_TIMESTAMP WHERE room_id = ? AND username = ?");
if ($stmt) {
    echo "Prepare OK\n";
    $stmt->close();
} else {
    echo "Prepare FAILED: " . $conn->error . "\n";
}

// Test the meta query
echo "\n=== Testing meta query ===\n";
$stmt = $conn->prepare("SELECT m.username, last_seen_message_id, (last_typing > DATE_SUB(NOW(), INTERVAL 5 SECOND)) as is_typing, u.imgUrl FROM mcjim_chat_room_members m INNER JOIN users u ON m.username = u.username WHERE room_id = ? AND m.username != ?");
if ($stmt) {
    echo "Meta query prepare OK\n";
    $stmt->close();
} else {
    echo "Meta query FAILED: " . $conn->error . "\n";
}

// Check if session.php exists
echo "\n=== session.php check ===\n";
echo file_exists(__DIR__ . '/../session.php') ? "EXISTS\n" : "MISSING - this is the problem!\n";

// Check what session.php does
if (file_exists(__DIR__ . '/../session.php')) {
    echo file_get_contents(__DIR__ . '/../session.php');
}
?>
