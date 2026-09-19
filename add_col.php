<?php
require("connect.php");
if ($conn->query("ALTER TABLE users ADD COLUMN jellyfin_userid VARCHAR(100) NULL")) {
    echo "Successfully added jellyfin_userid column.";
} else {
    echo "Error: " . $conn->error;
}
