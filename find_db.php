<?php
require_once __DIR__ . '/connect.php';
$res = $conn->query("SHOW TABLES");
echo "<h2>Tables:</h2><ul>";
while($row = $res->fetch_array()) {
    echo "<li>" . $row[0] . "</li>";
}
echo "</ul>";
?>
