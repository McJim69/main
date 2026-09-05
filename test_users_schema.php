<?php
require("connect.php");
$res = mysqli_query($conn, "DESCRIBE users;");
while ($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
