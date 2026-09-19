<?php
require("connect.php");
if ($conn->query("ALTER TABLE users MODIFY jellyfin VARCHAR(1024)")) {
    echo "Successfully updated column length.";
} else {
    echo "Error updating column: " . $conn->error;
}
