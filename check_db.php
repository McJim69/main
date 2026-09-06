<?php
require("connect.php");

$res = $conn->query("SELECT * FROM mcjim_wiki_articles");
echo "Articles found: " . $res->num_rows . "\n";
while($row = $res->fetch_assoc()) {
    echo $row['id'] . " | " . $row['title'] . " | Cat: " . $row['category_id'] . "\n";
}

$res = $conn->query("SELECT * FROM mcjim_wiki_categories");
echo "Categories found: " . $res->num_rows . "\n";
while($row = $res->fetch_assoc()) {
    echo $row['id'] . " | " . $row['title'] . "\n";
}
?>
