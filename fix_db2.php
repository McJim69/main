<?php
require("connect.php");
if ($conn->query("ALTER TABLE users MODIFY jellyfin VARCHAR(8192)")) {
    echo "Successfully updated column length to 8192.";
} else {
    echo "Error updating column: " . $conn->error;
}
