<?php
require("connect.php");
$res = mysqli_query($conn, "DESCRIBE mcjim_wiki_categories");
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . "\n";
}
?>
