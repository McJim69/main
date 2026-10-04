<?php
require("connect.php");
$res = $conn->query("SELECT jellyfin FROM users WHERE username='McJim'");
if($row = $res->fetch_assoc()) {
    echo $row['jellyfin'];
}
?>
