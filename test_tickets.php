<?php
require("connect.php");
$res = mysqli_query($conn, "DESCRIBE mcjim_tickets;");
while ($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
