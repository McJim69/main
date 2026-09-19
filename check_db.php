<?php
require("connect.php");
$result = $conn->query("SELECT username, jellyfin FROM users");
while($row = $result->fetch_assoc()) {
    echo "User: " . $row['username'] . " | Token Length: " . strlen((string)$row['jellyfin']) . "\n";
}
