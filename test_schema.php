<?php
require("connect.php");
$res = mysqli_query($conn, "DESCRIBE mcjim_invoices");
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . "\n";
}
?>
